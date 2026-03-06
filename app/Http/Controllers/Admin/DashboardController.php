<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hall;
use App\Models\Doctor;
use App\Models\Subject;
use App\Models\StudentGroup;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── إحصاءات عامة للكروت العلوية ─────────────────────
        $stats = [
            'halls'          => Hall::count(),
            'doctors'        => Doctor::count(),
            'subjects'       => Subject::count(),
            'student_groups' => StudentGroup::count(),
            'schedules'      => Schedule::count(),
            'upcoming'       => Schedule::count(),
        ];

        // ── آخر 5 جداول مضافة ────────────────────────────────
        $latestSchedules = Schedule::with(['doctor', 'subject', 'hall', 'studentGroup'])
            ->latest()
            ->take(5)
            ->get();

        // ── جداول اليوم (حسب يوم الأسبوع الحالي) ────────────
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
        
        $todaySchedules = Schedule::with(['doctor', 'subject', 'hall', 'studentGroup'])
            ->forDay($todayKey)
            ->orderBy('start_time')
            ->get();

        // ── جداول الأسبوع (جميع أيام الأسبوع) ────────────────
        $weekSchedules = Schedule::with(['doctor', 'subject', 'hall', 'studentGroup'])
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

        return view('admin.dashboard', compact(
            'stats',
            'latestSchedules',
            'todaySchedules',
            'weekSchedules'
        ));
    }
}