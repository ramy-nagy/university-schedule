<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Hall;
use App\Models\Doctor;
use App\Models\Subject;
use App\Models\StudentGroup;
use App\Models\Section;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['doctor', 'subject', 'hall', 'studentGroup'])
            ->orderBy('date')->orderBy('start_time')
            ->paginate(20);
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('admin.schedules.create', [
            'doctors'       => Doctor::all(),
            'subjects'      => Subject::all(),
            'halls'         => Hall::all(),
            'studentGroups' => StudentGroup::all(),
            'sections'      => Section::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'section_ids_input' => ['nullable', 'string', 'regex:/^\d+(,\d+)*$/'],
            'doctor_id'         => 'nullable|exists:doctors,id',
            'subject_id'        => 'required|exists:subjects,id',
            'hall_id'           => 'required|exists:halls,id',
            'student_group_id'  => 'required|exists:student_groups,id',
            'day_of_week'       => 'required|in:saturday,sunday,monday,tuesday,wednesday,thursday,friday',
            'start_time'        => 'required|date_format:H:i',
            'end_time'          => 'required|date_format:H:i|after:start_time',
            'type'              => 'required|in:lecture,lab',
        ], [
            'section_ids_input.regex' => 'صيغة أرقام الأقسام غير صحيحة. استخدم صيغة: 1,2,3',
        ]);

        // ── Parse comma-separated section IDs ──
        $sectionIds = [];
        if (!empty($data['section_ids_input'])) {
            $sectionIds = array_filter(array_map('intval', explode(',', $data['section_ids_input'])));
            
            // Validate that all section IDs exist
            $existingIds = Section::whereIn('id', $sectionIds)->pluck('id')->toArray();
            $invalidIds = array_diff($sectionIds, $existingIds);
            if (!empty($invalidIds)) {
                return back()->withInput()->withErrors([
                    'section_ids' => 'الأقسام التالية غير موجودة: ' . implode(', ', $invalidIds)
                ]);
            }
        }

        // ── Additional validation: sections required for labs ──
        if ($data['type'] === 'lab' && empty($sectionIds)) {
            return back()->withInput()->withErrors([
                'section_ids' => 'يجب اختيار قسم واحد على الأقل للحصص العملية'
            ]);
        }

        // ── Conflict Detection ────────────────────────────────
        $dataForConflict = array_merge($data, ['section_ids' => $sectionIds]);
        $conflicts = $this->detectConflicts($dataForConflict);

        if ($conflicts['has_conflict']) {
            return back()->withInput()
                ->with('conflict_error', $conflicts['message']);
        }

        // Create schedule without section IDs first
        $scheduleData = collect($data)->except(['section_ids_input'])->toArray();
        $schedule = Schedule::create($scheduleData);
        
        // Attach sections if provided
        if (!empty($sectionIds)) {
            $schedule->sections()->attach($sectionIds);
        }

        return redirect()->route('admin.schedules.index')
            ->with('success', 'تم إضافة التوقيت بنجاح ✅');
    }

    // ── Core Conflict Detection Method ────────────────────────
    private function detectConflicts(array $data, $excludeId = null): array
    {
        $q = Schedule::where('day_of_week', $data['day_of_week'])
            ->where(fn($q) =>
                $q->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                  ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
                  ->orWhere(fn($q) =>
                      $q->where('start_time', '<=', $data['start_time'])
                        ->where('end_time', '>=', $data['end_time'])
                  )
            );

        if ($excludeId) $q->where('id', '!=', $excludeId);

        // 1. Hall conflict (depends on type)
        if ($data['type'] === 'lecture') {
            // Lecture: Hall can only have one lecture at a time (no labs allowed)
            $hallConflict = (clone $q)->where('hall_id', $data['hall_id'])->first();
            if ($hallConflict) {
                return ['has_conflict' => true,
                    'message' => "⚠️ القاعة محجوزة بالفعل في هذا الوقت ({$hallConflict->start_time} - {$hallConflict->end_time})"];
            }
        } elseif ($data['type'] === 'lab') {
            // Lab: Hall can have labs with DIFFERENT section_ids, but not same section_id
            // Also cannot have lectures at same time
            $sectionIds = $data['section_ids'] ?? [];
            $hallConflict = (clone $q)
                ->where('hall_id', $data['hall_id'])
                ->where(function($q) use ($sectionIds) {
                    $q->where('type', 'lecture')  // Conflicts with lectures
                      ->orWhereHas('sections', function($q) use ($sectionIds) {
                          // Conflicts with labs of same section_id
                          if (!empty($sectionIds)) {
                              $q->whereIn('sections.id', $sectionIds);
                          }
                      });
                })
                ->first();
            if ($hallConflict) {
                $conflictType = $hallConflict->type === 'lecture' ? 'محاضرة نظرية' : 'قسم في نفس الموعد';
                return ['has_conflict' => true,
                    'message' => "⚠️ القاعة مشغولة بـ {$conflictType} ({$hallConflict->start_time} - {$hallConflict->end_time})"];
            }
        }

        // 2. Doctor conflict
        if (!empty($data['doctor_id'])) {
            $doctorConflict = (clone $q)->where('doctor_id', $data['doctor_id'])->first();
            if ($doctorConflict) {
                return ['has_conflict' => true,
                    'message' => "⚠️ الدكتور لديه محاضرة أخرى في نفس الوقت"];
            }
        }

        // 3. Student group conflict (depends on type)
        if ($data['type'] === 'lecture') {
            // Lecture: conflicts with ANY schedule for same group (lectures or labs)
            $groupConflict = (clone $q)->where('student_group_id', $data['student_group_id'])->first();
            if ($groupConflict) {
                return ['has_conflict' => true,
                    'message' => "⚠️ الفرقة الطلابية لديها محاضرة أخرى في نفس الوقت"];
            }
        } elseif ($data['type'] === 'lab') {
            // Lab: conflicts with lectures OR other labs with SAME section_id
            // Different sections of same group can have labs at same time
            $sectionIds = $data['section_ids'] ?? [];
            $groupConflict = (clone $q)
                ->where('student_group_id', $data['student_group_id'])
                ->where(function($q) use ($sectionIds) {
                    $q->where('type', 'lecture')  // Conflicts with lectures
                      ->orWhereHas('sections', function($q) use ($sectionIds) {
                          // Conflicts with labs of same section_id
                          if (!empty($sectionIds)) {
                              $q->whereIn('sections.id', $sectionIds);
                          }
                      });
                })
                ->first();
            if ($groupConflict) {
                $sectionNames = !empty($sectionIds) ? implode(', ', $sectionIds) : '';
                $conflictType = $groupConflict->type === 'lecture' ? 'محاضرة نظرية' : 'قسم في نفس الموعد';
                return ['has_conflict' => true,
                    'message' => "⚠️ الفرقة الطلابية (أقسام: {$sectionNames}) لديها {$conflictType} في نفس الوقت"];
            }
        }

        return ['has_conflict' => false, 'message' => ''];
    }

    public function edit(Schedule $schedule)
    {
        return view('admin.schedules.edit', [
            'schedule'      => $schedule,
            'doctors'       => Doctor::all(),
            'subjects'      => Subject::all(),
            'halls'         => Hall::all(),
            'studentGroups' => StudentGroup::all(),
            'sections'      => Section::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $data = $request->validate([
            'section_ids_input' => ['nullable', 'string', 'regex:/^\d+(,\d+)*$/'],
            'doctor_id'         => 'nullable|exists:doctors,id',
            'subject_id'        => 'required|exists:subjects,id',
            'hall_id'           => 'required|exists:halls,id',
            'student_group_id'  => 'required|exists:student_groups,id',
            'day_of_week'       => 'required|in:saturday,sunday,monday,tuesday,wednesday,thursday,friday',
            'start_time'        => 'required|date_format:H:i',
            'end_time'          => 'required|date_format:H:i|after:start_time',
            'type'              => 'required|in:lecture,lab',
        ], [
            'section_ids_input.regex' => 'صيغة أرقام الأقسام غير صحيحة. استخدم صيغة: 1,2,3',
        ]);

        // ── Parse comma-separated section IDs ──
        $sectionIds = [];
        if (!empty($data['section_ids_input'])) {
            $sectionIds = array_filter(array_map('intval', explode(',', $data['section_ids_input'])));
            
            // Validate that all section IDs exist
            $existingIds = Section::whereIn('id', $sectionIds)->pluck('id')->toArray();
            $invalidIds = array_diff($sectionIds, $existingIds);
            if (!empty($invalidIds)) {
                return back()->withInput()->withErrors([
                    'section_ids' => 'الأقسام التالية غير موجودة: ' . implode(', ', $invalidIds)
                ]);
            }
        }

        // ── Additional validation: sections required for labs ──
        if ($data['type'] === 'lab' && empty($sectionIds)) {
            return back()->withInput()->withErrors([
                'section_ids' => 'يجب اختيار قسم واحد على الأقل للحصص العملية'
            ]);
        }

        $dataForConflict = array_merge($data, ['section_ids' => $sectionIds]);
        $conflicts = $this->detectConflicts($dataForConflict, $schedule->id);
        if ($conflicts['has_conflict']) {
            return back()->withInput()->with('conflict_error', $conflicts['message']);
        }

        // Update schedule data without section_ids_input
        $scheduleData = collect($data)->except(['section_ids_input'])->toArray();
        $schedule->update($scheduleData);
        
        // Sync sections (replace old with new)
        if (!empty($sectionIds)) {
            $schedule->sections()->sync($sectionIds);
        } else {
            $schedule->sections()->detach();
        }

        return redirect()->route('admin.schedules.index')
            ->with('success', 'تم تعديل التوقيت بنجاح ✅');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'تم حذف التوقيت');
    }
}