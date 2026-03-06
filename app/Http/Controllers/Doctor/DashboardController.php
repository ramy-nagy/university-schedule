<?php


namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
 public function index()
    {
        $doctorId = auth()->user()->doctor_id;

        // ── إحصاءات سريعة ─────────────────────────────────
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
        
        $todayCount    = Schedule::forDoctor($doctorId)->forDay($todayKey)->count();
        $weekCount     = Schedule::forDoctor($doctorId)->count();
        $totalCount    = Schedule::forDoctor($doctorId)->count();
        $subjectsCount = auth()->user()->doctor->subjects()->count();

        // ── جدول اليوم (تايم لاين) ────────────────────────
        $todaySchedules = Schedule::with(['subject', 'hall', 'studentGroup'])
            ->forDoctor($doctorId)
            ->forDay($todayKey)
            ->orderBy('start_time')
            ->get();

        // ── المحاضرات (5 محاضرات) ────────────────────────
        $upcomingSchedules = Schedule::with(['subject', 'hall', 'studentGroup'])
            ->forDoctor($doctorId)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
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

        $doctor = auth()->user()->doctor;

        return view('doctor.schedule', compact('schedules', 'doctor'));
    }
}