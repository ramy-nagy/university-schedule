<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectApiController extends BaseApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Subject::with('doctor');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                ->orWhere('code', 'like', "%$search%");
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $subjects = $query->paginate($request->get('per_page', 15));

        return $this->successPaginated($subjects, 'Subjects retrieved successfully');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50|unique:subjects,code',
            'doctor_id' => 'required|exists:doctors,id',
            'credits' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            $subject = Subject::create($request->validated());
            return $this->success($subject->load('doctor'), 'Subject created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create subject', 500);
        }
    }

    public function show(Subject $subject): JsonResponse
    {
        return $this->success($subject->load(['doctor', 'schedules']), 'Subject retrieved successfully');
    }

    public function update(Request $request, Subject $subject): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50|unique:subjects,code,' . $subject->id,
            'doctor_id' => 'required|exists:doctors,id',
            'credits' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            $subject->update($request->validated());
            return $this->success($subject->fresh()->load('doctor'), 'Subject updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update subject', 500);
        }
    }

    public function destroy(Subject $subject): JsonResponse
    {
        try {
            $subject->delete();
            return $this->success(null, 'Subject deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete subject', 500);
        }
    }

    public function bulkDelete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array|min:1',
            'ids.*' => 'required|integer|exists:subjects,id',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            Subject::whereIn('id', $request->ids)->delete();
            return $this->success(null, 'Subjects deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete subjects', 500);
        }
    }
}
