<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Schedule;

class DashboardController extends Controller
{
 public function index()
    {
        $groupId = auth()->user()->student_group_id;

        // ── إحصاء إجمالي المحاضرات ────────────────────────
        $totalSchedules = Schedule::forGroup($groupId)->count();

        // ── محاضرات اليوم ──────────────────────────────────
        $todaySchedules = Schedule::with(['doctor', 'subject', 'hall'])
            ->forGroup($groupId)
            ->forDate(today())
            ->orderBy('start_time')
            ->get();

        // ── المحاضرات القادمة (3 محاضرات) ────────────────
        $upcomingSchedules = Schedule::with(['doctor', 'subject', 'hall'])
            ->forGroup($groupId)
            ->where('date', '>', today())
            ->orderBy('date')->orderBy('start_time')
            ->take(3)->get();

        return view('student.dashboard', compact(
            'totalSchedules',
            'todaySchedules',
            'upcomingSchedules'
        ));
    }

    public function schedule()
    {
        $groupId = auth()->user()->student_group_id;

        $schedules = Schedule::with(['doctor', 'subject', 'hall'])
            ->forGroup($groupId)
            ->orderBy('date')->orderBy('start_time')
            ->get()
            ->groupBy(fn($s) => $s->date->format('Y-m-d'));

        return view('student.schedule', compact('schedules'));
    }
}