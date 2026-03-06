<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Carbon\Carbon;

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
        $totalSchedules = Schedule::forGroup($groupId)->count();

        // ── محاضرات اليوم ──────────────────────────────────
        $todaySchedules = Schedule::with([
            'doctor',
            'subject',
            'hall'
        ])
            ->forGroup($groupId)
            ->forDate(today())
            ->orderBy('start_time')
            ->get();

        // ── المحاضرات القادمة (3 محاضرات) ────────────────
        $upcomingSchedules = Schedule::with([
            'doctor',
            'subject',
            'hall'
        ])
            ->forGroup($groupId)
            ->where('date', '>', today())
            ->orderBy('date')
            ->orderBy('start_time')
            ->take(3)
            ->get();

        // ── إحصائيات إضافية ────────────────────────────────
        // عدد المحاضرات هذا الأسبوع
        $weekSchedules = Schedule::forGroup($groupId)
            ->whereBetween('date', [
                today()->startOfWeek(),
                today()->endOfWeek()
            ])
            ->count();

        // عدد المعامل
        $labCount = Schedule::forGroup($groupId)
            ->where('type', 'lab')
            ->count();

        // عدد المحاضرات
        $lectureCount = Schedule::forGroup($groupId)
            ->where('type', 'lecture')
            ->count();

        return view('student.dashboard', compact(
            'totalSchedules',
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

        // ── جلب الجدول كامل مع العلاقات ────────────────────
        $schedules = Schedule::with([
            'doctor',
            'subject',
            'hall'
        ])
            ->forGroup($groupId)
            ->where('date', '>=', today())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($schedule) {
                return $schedule->date->format('Y-m-d');
            });

        // ── إحصائيات الجدول ────────────────────────────────
        $totalUpcoming = Schedule::forGroup($groupId)
            ->where('date', '>=', today())
            ->count();

        $nextLecture = Schedule::forGroup($groupId)
            ->where('date', '>=', today())
            ->orderBy('date')
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

        $schedules = Schedule::with([
            'doctor',
            'subject',
            'hall'
        ])
            ->forGroup($groupId)
            ->forDate(today())
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
            ->where('date', '>', today())
            ->orderBy('date')
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
            'this_week' => Schedule::forGroup($groupId)
                ->whereBetween('date', [
                    today()->startOfWeek(),
                    today()->endOfWeek()
                ])
                ->count(),
            'lectures' => Schedule::forGroup($groupId)
                ->where('type', 'lecture')
                ->count(),
            'labs' => Schedule::forGroup($groupId)
                ->where('type', 'lab')
                ->count(),
            'this_month' => Schedule::forGroup($groupId)
                ->whereBetween('date', [
                    today()->startOfMonth(),
                    today()->endOfMonth()
                ])
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
            ->where('date', '>=', today())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($schedule) {
                return $schedule->date->format('Y-m-d');
            });

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
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterByDateRange($startDate, $endDate)
    {
        $groupId = auth()->user()->student_group_id;

        try {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);

            $schedules = Schedule::with([
                'doctor',
                'subject',
                'hall'
            ])
                ->forGroup($groupId)
                ->whereBetween('date', [$start, $end])
                ->orderBy('date')
                ->orderBy('start_time')
                ->get()
                ->groupBy(function ($schedule) {
                    return $schedule->date->format('Y-m-d');
                });

            return response()->json([
                'status' => 'success',
                'count' => $schedules->count(),
                'data' => $schedules
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid date range'
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