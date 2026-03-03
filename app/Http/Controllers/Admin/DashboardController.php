<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hall;
use App\Models\Doctor;
use App\Models\Subject;
use App\Models\StudentGroup;
use App\Models\Schedule;

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
            'upcoming'       => Schedule::where('date', '>=', today())->count(),
        ];

        // ── آخر 5 جداول مضافة ────────────────────────────────
        $latestSchedules = Schedule::with(['doctor', 'subject', 'hall', 'studentGroup'])
            ->latest()
            ->take(5)
            ->get();

        // ── جداول اليوم ───────────────────────────────────────
        $todaySchedules = Schedule::with(['doctor', 'subject', 'hall', 'studentGroup'])
            ->where('date', today())
            ->orderBy('start_time')
            ->get();

        // ── جداول الأسبوع القادم (7 أيام) ────────────────────
        $weekSchedules = Schedule::with(['doctor', 'subject', 'hall', 'studentGroup'])
            ->whereBetween('date', [today(), today()->addDays(7)])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn($s) => $s->date->format('Y-m-d'));

        return view('admin.dashboard', compact(
            'stats',
            'latestSchedules',
            'todaySchedules',
            'weekSchedules'
        ));
    }
}