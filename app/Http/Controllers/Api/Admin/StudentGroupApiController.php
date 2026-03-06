<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\StudentGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentGroupApiController extends BaseApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = StudentGroup::withCount('students');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                ->orWhere('level', 'like', "%$search%");
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $groups = $query->paginate($request->get('per_page', 15));

        return $this->successPaginated($groups, 'Student groups retrieved successfully');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:student_groups,name',
            'level' => 'required|integer|min:1|max:5',
            'capacity' => 'nullable|integer|min:1|max:200',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            $group = StudentGroup::create($request->validated());
            return $this->success($group, 'Student group created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create student group', 500);
        }
    }

    public function show(StudentGroup $studentGroup): JsonResponse
    {
        return $this->success($studentGroup->load('students'), 'Student group retrieved successfully');
    }

    public function update(Request $request, StudentGroup $studentGroup): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:student_groups,name,' . $studentGroup->id,
            'level' => 'required|integer|min:1|max:5',
            'capacity' => 'nullable|integer|min:1|max:200',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            $studentGroup->update($request->validated());
            return $this->success($studentGroup, 'Student group updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update student group', 500);
        }
    }

    public function destroy(StudentGroup $studentGroup): JsonResponse
    {
        try {
            $studentGroup->delete();
            return $this->success(null, 'Student group deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete student group', 500);
        }
    }

    public function bulkDelete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array|min:1',
            'ids.*' => 'required|integer|exists:student_groups,id',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            StudentGroup::whereIn('id', $request->ids)->delete();
            return $this->success(null, 'Student groups deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete student groups', 500);
        }
    }
}
