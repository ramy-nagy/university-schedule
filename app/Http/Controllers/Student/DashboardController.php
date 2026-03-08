<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $groupId = auth()->user()->student_group_id;

        // ── إحصاء إجمالي المحاضرات ────────────────────────
        $totalLecture = Schedule::forGroup($groupId)->where('type', 'lecture')->count();
        $totalLabs = Schedule::forGroup($groupId)->where('type', 'lab')->count();

        // ── محاضرات اليوم (حسب يوم الأسبوع الحالي) ────────
        $dayOfWeekMap = [
            'Saturday' => 'saturday',
            'Sunday' => 'sunday',
            'Monday' => 'monday',
            'Tuesday' => 'tuesday',
            'Wednesday' => 'wednesday',
            'Thursday' => 'thursday',
            'Friday' => 'friday',
        ];
        $todayEnglishDay = today()->format('l');
        $todayKey = $dayOfWeekMap[$todayEnglishDay] ?? 'monday';
        
        $todaySchedules = Schedule::with([
            'doctor',
            'subject',
            'hall'
        ])
            ->forGroup($groupId)
            ->forDay($todayKey)
            ->orderBy('start_time')
            ->get();

        // ── المحاضرات (3 محاضرات) ──────────────────────
        $upcomingSchedules = Schedule::with([
            'doctor',
            'subject',
            'hall'
        ])
            ->forGroup($groupId)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->take(3)
            ->get();

        // ── إحصائيات إضافية ────────────────────────────────
        // عدد المحاضرات في الأسبوع
        $weekSchedules = Schedule::forGroup($groupId)->count();

        // عدد المعامل
        $labCount = Schedule::forGroup($groupId)
            ->where('type', 'lab')
            ->count();

        // عدد المحاضرات
        $lectureCount = Schedule::forGroup($groupId)
            ->where('type', 'lecture')
            ->count();

        return view('student.dashboard', compact(
            'totalLecture',
            'totalLabs',
            'todaySchedules',
            'upcomingSchedules',
            'weekSchedules',
            'labCount',
            'lectureCount'
        ));
    }

    /**
     * Display the full schedule for the student
     *
     * @return \Illuminate\View\View
     */
    public function schedule()
    {
        $groupId = auth()->user()->student_group_id;
        $sectionId = auth()->user()->section_id;
        // ── جلب الجدول كامل مع العلاقات ────────────────────
        $schedules = Schedule::with([
            'doctor',
            'subject',
            'hall'
        ])
            ->forGroup($groupId)
            ->when($sectionId, function ($query) use ($sectionId) {
                $query->where(function ($q) use ($sectionId) {
                    $q->whereNull('section_id')
                      ->orWhere('section_id', $sectionId);
                });
            })
            ->orderByRaw(DB::raw("CASE day_of_week
                WHEN 'saturday' THEN 0
                WHEN 'sunday' THEN 1
                WHEN 'monday' THEN 2
                WHEN 'tuesday' THEN 3
                WHEN 'wednesday' THEN 4
                WHEN 'thursday' THEN 5
                WHEN 'friday' THEN 6
            END"))
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week_label');

        // ── إحصائيات الجدول ────────────────────────────────
        $totalUpcoming = Schedule::forGroup($groupId)->count();

        $nextLecture = Schedule::forGroup($groupId)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->first();

        return view('student.schedule', compact(
            'schedules',
            'totalUpcoming',
            'nextLecture'
        ));
    }

    /**
     * Get today's schedule as JSON (useful for AJAX)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function todayJson()
    {
        $groupId = auth()->user()->student_group_id;
        
        $dayOfWeekMap = [
            'Saturday' => 'saturday',
            'Sunday' => 'sunday',
            'Monday' => 'monday',
            'Tuesday' => 'tuesday',
            'Wednesday' => 'wednesday',
            'Thursday' => 'thursday',
            'Friday' => 'friday',
        ];
        $todayEnglishDay = today()->format('l');
        $todayKey = $dayOfWeekMap[$todayEnglishDay] ?? 'monday';

        $schedules = Schedule::with([
            'doctor',
            'subject',
            'hall'
        ])
            ->forGroup($groupId)
            ->forDay($todayKey)
            ->orderBy('start_time')
            ->get();

        return response()->json([
            'status' => 'success',
            'count' => $schedules->count(),
            'data' => $schedules
        ]);
    }

    /**
     * Get upcoming schedule as JSON (useful for AJAX)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upcomingJson()
    {
        $groupId = auth()->user()->student_group_id;

        $schedules = Schedule::with([
            'doctor',
            'subject',
            'hall'
        ])
            ->forGroup($groupId)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        return response()->json([
            'status' => 'success',
            'count' => $schedules->count(),
            'data' => $schedules
        ]);
    }

    /**
     * Get schedule statistics
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function statsJson()
    {
        $groupId = auth()->user()->student_group_id;

        $stats = [
            'total' => Schedule::forGroup($groupId)->count(),
            'week_count' => Schedule::forGroup($groupId)->count(),
            'lectures' => Schedule::forGroup($groupId)
                ->where('type', 'lecture')
                ->count(),
            'labs' => Schedule::forGroup($groupId)
                ->where('type', 'lab')
                ->count(),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $stats
        ]);
    }

    /**
     * Download schedule as PDF
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf()
    {
        $groupId = auth()->user()->student_group_id;

        $schedules = Schedule::with([
            'doctor',
            'subject',
            'hall'
        ])
            ->forGroup($groupId)
            ->orderByRaw(DB::raw("CASE day_of_week
                WHEN 'saturday' THEN 0
                WHEN 'sunday' THEN 1
                WHEN 'monday' THEN 2
                WHEN 'tuesday' THEN 3
                WHEN 'wednesday' THEN 4
                WHEN 'thursday' THEN 5
                WHEN 'friday' THEN 6
            END"))
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week_label');

        // You can use a PDF library like DomPDF here
        // For now, we'll just return the data
        // Example: return PDF::loadView('student.schedule-pdf', compact('schedules'))->download('schedule.pdf');

        return response()->json([
            'status' => 'success',
            'message' => 'PDF download functionality to be implemented'
        ]);
    }

    /**
     * Get schedule filtered by date range
     *
     * @param string $startDay
     * @param string $endDay
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterByDateRange($startDay, $endDay)
    {
        $groupId = auth()->user()->student_group_id;

        try {
            $validDays = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
            
            if (!in_array($startDay, $validDays) || !in_array($endDay, $validDays)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid day of week'
                ], 400);
            }

            $schedules = Schedule::with([
                'doctor',
                'subject',
                'hall'
            ])
                ->forGroup($groupId)
                ->whereIn('day_of_week', $validDays)
                ->orderByRaw(DB::raw("CASE day_of_week
                    WHEN 'saturday' THEN 0
                    WHEN 'sunday' THEN 1
                    WHEN 'monday' THEN 2
                    WHEN 'tuesday' THEN 3
                    WHEN 'wednesday' THEN 4
                    WHEN 'thursday' THEN 5
                    WHEN 'friday' THEN 6
                END"))
                ->orderBy('start_time')
                ->get()
                ->groupBy('day_of_week_label');

            return response()->json([
                'status' => 'success',
                'count' => $schedules->count(),
                'data' => $schedules
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid parameters'
            ], 400);
        }
    }

    /**
     * Mark schedule as completed/read
     *
     * @param int $scheduleId
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead($scheduleId)
    {
        $groupId = auth()->user()->student_group_id;

        $schedule = Schedule::find($scheduleId);

        if (!$schedule || $schedule->group_id != $groupId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Schedule not found'
            ], 404);
        }

        // You can store this in a separate table if needed
        // For now, this is a placeholder

        return response()->json([
            'status' => 'success',
            'message' => 'Schedule marked as read'
        ]);
    }
}