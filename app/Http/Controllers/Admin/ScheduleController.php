<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Hall;
use App\Models\Doctor;
use App\Models\Subject;
use App\Models\StudentGroup;
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
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'doctor_id'        => 'required|exists:doctors,id',
            'subject_id'       => 'required|exists:subjects,id',
            'hall_id'          => 'required|exists:halls,id',
            'student_group_id' => 'required|exists:student_groups,id',
            'day_of_week'      => 'required|in:saturday,sunday,monday,tuesday,wednesday,thursday,friday',
            'start_time'       => 'required|date_format:H:i',
            'end_time'         => 'required|date_format:H:i|after:start_time',
            'type'             => 'required|in:lecture,lab',
        ]);

        // ── Conflict Detection ────────────────────────────────
        $conflicts = $this->detectConflicts($data);

        if ($conflicts['has_conflict']) {
            return back()->withInput()
                ->with('conflict_error', $conflicts['message']);
        }

        Schedule::create($data);
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

        // 1. Hall conflict
        $hallConflict = (clone $q)->where('hall_id', $data['hall_id'])->first();
        if ($hallConflict) {
            return ['has_conflict' => true,
                'message' => "⚠️ القاعة محجوزة بالفعل في هذا الوقت ({$hallConflict->start_time} - {$hallConflict->end_time})"];
        }

        // 2. Doctor conflict
        $doctorConflict = (clone $q)->where('doctor_id', $data['doctor_id'])->first();
        if ($doctorConflict) {
            return ['has_conflict' => true,
                'message' => "⚠️ الدكتور لديه محاضرة أخرى في نفس الوقت"];
        }

        // 3. Student group conflict
        $groupConflict = (clone $q)->where('student_group_id', $data['student_group_id'])->first();
        if ($groupConflict) {
            return ['has_conflict' => true,
                'message' => "⚠️ الفرقة  الطلابية لديها محاضرة أخرى في نفس الوقت"];
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
        ]);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $data = $request->validate([
            'doctor_id'        => 'required|exists:doctors,id',
            'subject_id'       => 'required|exists:subjects,id',
            'hall_id'          => 'required|exists:halls,id',
            'student_group_id' => 'required|exists:student_groups,id',
            'day_of_week'      => 'required|in:saturday,sunday,monday,tuesday,wednesday,thursday,friday',
            'start_time'       => 'required|date_format:H:i',
            'end_time'         => 'required|date_format:H:i|after:start_time',
            'type'             => 'required|in:lecture,lab',
        ]);

        $conflicts = $this->detectConflicts($data, $schedule->id);
        if ($conflicts['has_conflict']) {
            return back()->withInput()->with('conflict_error', $conflicts['message']);
        }

        $schedule->update($data);
        return redirect()->route('admin.schedules.index')
            ->with('success', 'تم تعديل التوقيت بنجاح ✅');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'تم حذف التوقيت');
    }
}