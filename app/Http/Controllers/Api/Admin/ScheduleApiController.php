<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleApiController extends BaseApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Schedule::with(['doctor', 'subject', 'hall', 'studentGroup']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('subject', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })->orWhereHas('doctor', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        $sortBy = $request->get('sort_by', 'date');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $schedules = $query->paginate($request->get('per_page', 15));

        return $this->successPaginated($schedules, 'Schedules retrieved successfully');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
            'subject_id' => 'required|exists:subjects,id',
            'hall_id' => 'required|exists:halls,id',
            'student_group_id' => 'required|exists:student_groups,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'type' => 'required|in:lecture,lab',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        // Check for conflicts
        $conflict = $this->checkScheduleConflict($request);
        if ($conflict) {
            return $this->error('Schedule conflict detected: ' . $conflict, 409);
        }

        try {
            $schedule = Schedule::create($request->validated());
            return $this->success(
                $schedule->load(['doctor', 'subject', 'hall', 'studentGroup']),
                'Schedule created successfully',
                201
            );
        } catch (\Exception $e) {
            return $this->error('Failed to create schedule', 500);
        }
    }

    public function show(Schedule $schedule): JsonResponse
    {
        return $this->success(
            $schedule->load(['doctor', 'subject', 'hall', 'studentGroup']),
            'Schedule retrieved successfully'
        );
    }

    public function update(Request $request, Schedule $schedule): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
            'subject_id' => 'required|exists:subjects,id',
            'hall_id' => 'required|exists:halls,id',
            'student_group_id' => 'required|exists:student_groups,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'type' => 'required|in:lecture,lab',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        // Check for conflicts (excluding current schedule)
        $conflict = $this->checkScheduleConflict($request, $schedule->id);
        if ($conflict) {
            return $this->error('Schedule conflict detected: ' . $conflict, 409);
        }

        try {
            $schedule->update($request->validated());
            return $this->success(
                $schedule->fresh()->load(['doctor', 'subject', 'hall', 'studentGroup']),
                'Schedule updated successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to update schedule', 500);
        }
    }

    public function destroy(Schedule $schedule): JsonResponse
    {
        try {
            $schedule->delete();
            return $this->success(null, 'Schedule deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete schedule', 500);
        }
    }

    public function checkConflicts(Request $request): JsonResponse
    {
        $conflict = $this->checkScheduleConflict($request);
        
        return $this->success([
            'has_conflict' => (bool)$conflict,
            'conflict_message' => $conflict,
        ]);
    }

    public function bulkDelete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array|min:1',
            'ids.*' => 'required|integer|exists:schedules,id',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            Schedule::whereIn('id', $request->ids)->delete();
            return $this->success(null, 'Schedules deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete schedules', 500);
        }
    }

    /**
     * Check for schedule conflicts
     */
    private function checkScheduleConflict(Request $request, $excludeId = null): ?string
    {
        $query = Schedule::where('date', $request->date)
            ->where('hall_id', $request->hall_id)
            ->whereBetween('start_time', [
                $request->start_time . ':00',
                $request->end_time . ':00'
            ]);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if ($query->exists()) {
            return 'Hall conflict: The hall is already booked at this time';
        }

        // Check doctor conflict
        $query = Schedule::where('date', $request->date)
            ->where('doctor_id', $request->doctor_id)
            ->whereBetween('start_time', [
                $request->start_time . ':00',
                $request->end_time . ':00'
            ]);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if ($query->exists()) {
            return 'Doctor conflict: The doctor has another class at this time';
        }

        // Check student group conflict
        $query = Schedule::where('date', $request->date)
            ->where('student_group_id', $request->student_group_id)
            ->whereBetween('start_time', [
                $request->start_time . ':00',
                $request->end_time . ':00'
            ]);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if ($query->exists()) {
            return 'Student group conflict: The group has another class at this time';
        }

        return null;
    }
}
