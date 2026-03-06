<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DoctorApiController extends BaseApiController
{
    /**
     * List Doctors with pagination
     */
    public function index(Request $request): JsonResponse
    {
        $query = Doctor::with('user')
            ->withCount('schedules');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('email', 'like', "%$search%");
                });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $doctors = $query->paginate($request->get('per_page', 15));

        return $this->successPaginated(
            $doctors,
            'Doctors retrieved successfully'
        );
    }

    /**
     * Create Doctor
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'department' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            $doctor = DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'doctor',
                ]);

                $doctor = Doctor::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'department' => $request->department,
                    'phone' => $request->phone,
                ]);

                $user->update(['doctor_id' => $doctor->id]);

                return $doctor->load('user');
            });

            return $this->success(
                $doctor,
                'Doctor created successfully',
                201
            );
        } catch (\Exception $e) {
            return $this->error('Failed to create doctor', 500);
        }
    }

    /**
     * Get Single Doctor
     */
    public function show(Doctor $doctor): JsonResponse
    {
        return $this->success(
            $doctor->load(['user', 'schedules']),
            'Doctor retrieved successfully'
        );
    }

    /**
     * Update Doctor
     */
    public function update(Request $request, Doctor $doctor): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'department' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $doctor->user_id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            DB::transaction(function () use ($request, $doctor) {
                $doctor->update([
                    'name' => $request->name,
                    'department' => $request->department,
                    'phone' => $request->phone,
                ]);

                $userData = ['name' => $request->name, 'email' => $request->email];
                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }
                $doctor->user->update($userData);
            });

            return $this->success(
                $doctor->fresh()->load('user'),
                'Doctor updated successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to update doctor', 500);
        }
    }

    /**
     * Delete Doctor
     */
    public function destroy(Doctor $doctor): JsonResponse
    {
        try {
            DB::transaction(function () use ($doctor) {
                $user = $doctor->user;
                $doctor->delete();
                $user->delete();
            });

            return $this->success(null, 'Doctor deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete doctor', 500);
        }
    }

    /**
     * Bulk Delete
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array|min:1',
            'ids.*' => 'required|integer|exists:doctors,id',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            DB::transaction(function () use ($request) {
                $doctors = Doctor::whereIn('id', $request->ids)->get();
                
                foreach ($doctors as $doctor) {
                    $user = $doctor->user;
                    $doctor->delete();
                    $user->delete();
                }
            });

            return $this->success(null, 'Doctors deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete doctors', 500);
        }
    }
}
