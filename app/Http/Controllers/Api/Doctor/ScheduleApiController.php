<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleApiController extends BaseApiController
{
    public function index(Request $request): JsonResponse
    {
        $doctor = auth()->user()->doctor;

        $query = $doctor->schedules()
            ->with(['subject', 'hall', 'studentGroup']);

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        } else {
            $query->where('date', '>=', today());
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $schedules = $query->orderBy('date')
            ->orderBy('start_time')
            ->paginate($request->get('per_page', 15));

        return $this->successPaginated($schedules, 'Doctor schedules retrieved successfully');
    }

    public function show(Schedule $schedule): JsonResponse
    {
        $doctor = auth()->user()->doctor;

        if ($schedule->doctor_id !== $doctor->id) {
            return $this->unauthorized('You are not authorized to view this schedule');
        }

        return $this->success(
            $schedule->load(['subject', 'hall', 'studentGroup']),
            'Schedule retrieved successfully'
        );
    }
}
