<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;

class DashboardApiController extends BaseApiController
{
    public function index(): JsonResponse
    {
        $doctor = auth()->user()->doctor;

        $stats = [
            'name' => $doctor->name,
            'department' => $doctor->department,
            'phone' => $doctor->phone,
            'total_schedules' => $doctor->schedules()->count(),
            'upcoming_schedules' => $doctor->upcomingSchedules()->count(),
            'subjects' => $doctor->subjects()
                ->with(['schedules' => function ($query) {
                    $query->where('date', '>=', today());
                }])
                ->get(),
            'next_class' => $doctor->upcomingSchedules()
                ->first(),
        ];

        return $this->success($stats, 'Doctor dashboard data retrieved successfully');
    }
}
