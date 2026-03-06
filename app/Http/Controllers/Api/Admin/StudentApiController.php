<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\User;
use App\Models\StudentGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentApiController extends BaseApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = User::where('role', 'student')
            ->with(['studentGroup' => function ($query) {
                $query->select('id', 'name', 'level');
            }]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        if ($request->filled('student_group_id')) {
            $query->where('student_group_id', $request->student_group_id);
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $students = $query->paginate($request->get('per_page', 15));

        return $this->successPaginated($students, 'Students retrieved successfully');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'student_group_id' => 'required|exists:student_groups,id',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            $student = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'student',
                'student_group_id' => $request->student_group_id,
                'phone' => $request->phone,
            ]);

            return $this->success(
                $student->load('studentGroup'),
                'Student created successfully',
                201
            );
        } catch (\Exception $e) {
            return $this->error('Failed to create student', 500);
        }
    }

    public function show(User $student): JsonResponse
    {
        if ($student->role !== 'student') {
            return $this->notFound('Student not found');
        }

        return $this->success(
            $student->load(['studentGroup', 'schedules']),
            'Student retrieved successfully'
        );
    }

    public function update(Request $request, User $student): JsonResponse
    {
        if ($student->role !== 'student') {
            return $this->notFound('Student not found');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'password' => 'nullable|string|min:8|confirmed',
            'student_group_id' => 'required|exists:student_groups,id',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            $data = $request->validated();
            
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $student->update($data);

            return $this->success(
                $student->fresh()->load('studentGroup'),
                'Student updated successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to update student', 500);
        }
    }

    public function destroy(User $student): JsonResponse
    {
        if ($student->role !== 'student') {
            return $this->notFound('Student not found');
        }

        try {
            $student->delete();
            return $this->success(null, 'Student deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete student', 500);
        }
    }

    public function bulkDelete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array|min:1',
            'ids.*' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            User::whereIn('id', $request->ids)
                ->where('role', 'student')
                ->delete();

            return $this->success(null, 'Students deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete students', 500);
        }
    }
}
