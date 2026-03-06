<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Doctor;
use App\Models\Hall;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\StudentGroup;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DashboardApiController extends BaseApiController
{
    public function index(): JsonResponse
    {
        $stats = [
            'doctors' => Doctor::count(),
            'halls' => Hall::count(),
            'subjects' => Subject::count(),
            'student_groups' => StudentGroup::count(),
            'schedules' => Schedule::count(),
            'students' => User::where('role', 'student')->count(),
            'upcoming_schedules' => Schedule::where('date', '>=', today())
                ->with(['doctor', 'subject', 'hall', 'studentGroup'])
                ->orderBy('date')
                ->limit(5)
                ->get(),
            'recent_schedules' => Schedule::with(['doctor', 'subject', 'hall', 'studentGroup'])
                ->latest()
                ->limit(10)
                ->get(),
        ];

        return $this->success($stats, 'Dashboard data retrieved successfully');
    }
}
