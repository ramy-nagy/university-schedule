<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleApiController extends BaseApiController
{
    public function index(Request $request): JsonResponse
    {
        $student = auth()->user();
        $group = $student->studentGroup;

        if (!$group) {
            return $this->error('Student group not found', 404);
        }

        $query = $group->schedules()
            ->with(['doctor', 'subject', 'hall']);

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

        return $this->successPaginated($schedules, 'Student schedules retrieved successfully');
    }

    public function show(Schedule $schedule): JsonResponse
    {
        $student = auth()->user();
        $group = $student->studentGroup;

        if (!$group || $schedule->student_group_id !== $group->id) {
            return $this->unauthorized('You are not authorized to view this schedule');
        }

        return $this->success(
            $schedule->load(['doctor', 'subject', 'hall']),
            'Schedule retrieved successfully'
        );
    }
}
