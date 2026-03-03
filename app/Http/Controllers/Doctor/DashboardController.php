<?php


namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Schedule;

class DashboardController extends Controller
{
 public function index()
    {
        $doctorId = auth()->user()->doctor_id;

        // ── إحصاءات سريعة ─────────────────────────────────
        $todayCount    = Schedule::forDoctor($doctorId)->forDate(today())->count();
        $weekCount     = Schedule::forDoctor($doctorId)
                            ->whereBetween('date', [today(), today()->addDays(7)])->count();
        $totalCount    = Schedule::forDoctor($doctorId)->count();
        $subjectsCount = auth()->user()->doctor->subjects()->count();

        // ── جدول اليوم (تايم لاين) ────────────────────────
        $todaySchedules = Schedule::with(['subject', 'hall', 'studentGroup'])
            ->forDoctor($doctorId)
            ->forDate(today())
            ->orderBy('start_time')
            ->get();

        // ── المحاضرات القادمة (5 محاضرات) ────────────────
        $upcomingSchedules = Schedule::with(['subject', 'hall', 'studentGroup'])
            ->forDoctor($doctorId)
            ->where('date', '>', today())
            ->orderBy('date')->orderBy('start_time')
            ->take(5)->get();

        return view('doctor.dashboard', compact(
            'todayCount', 'weekCount', 'totalCount', 'subjectsCount',
            'todaySchedules', 'upcomingSchedules'
        ));
    }

    public function schedule()
    {
        $doctorId = auth()->user()->doctor_id;

        $schedules = Schedule::with(['subject', 'hall', 'studentGroup'])
            ->forDoctor($doctorId)
            ->orderBy('date')->orderBy('start_time')
            ->get()
            ->groupBy(fn($s) => $s->date->format('Y-m-d'));

        $doctor = auth()->user()->doctor;

        return view('doctor.schedule', compact('schedules', 'doctor'));
    }
}