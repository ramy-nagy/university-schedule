<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;

class DashboardApiController extends BaseApiController
{
    public function index(): JsonResponse
    {
        $student = auth()->user();
        $group = $student->studentGroup;

        $stats = [
            'name' => $student->name,
            'email' => $student->email,
            'group_name' => $group?->name,
            'group_level' => $group?->level,
            'total_schedules' => $group?->schedules()->count() ?? 0,
            'upcoming_schedules' => $group?->schedules()
                ->where('date', '>=', today())
                ->count() ?? 0,
            'next_class' => $group?->schedules()
                ->with(['doctor', 'subject', 'hall'])
                ->where('date', '>=', today())
                ->orderBy('date')
                ->orderBy('start_time')
                ->first(),
        ];

        return $this->success($stats, 'Student dashboard data retrieved successfully');
    }
}
