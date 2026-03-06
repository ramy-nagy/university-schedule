<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Hall;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HallApiController extends BaseApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Hall::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                ->orWhere('capacity', 'like', "%$search%");
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $halls = $query->paginate($request->get('per_page', 15));

        return $this->successPaginated($halls, 'Halls retrieved successfully');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:halls,name',
            'capacity' => 'required|integer|min:1|max:500',
            'type' => 'nullable|string|max:50',
            'building' => 'nullable|string|max:100',
            'floor' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            $hall = Hall::create($request->validated());
            return $this->success($hall, 'Hall created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create hall', 500);
        }
    }

    public function show(Hall $hall): JsonResponse
    {
        return $this->success($hall, 'Hall retrieved successfully');
    }

    public function update(Request $request, Hall $hall): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:halls,name,' . $hall->id,
            'capacity' => 'required|integer|min:1|max:500',
            'type' => 'nullable|string|max:50',
            'building' => 'nullable|string|max:100',
            'floor' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            $hall->update($request->validated());
            return $this->success($hall, 'Hall updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update hall', 500);
        }
    }

    public function destroy(Hall $hall): JsonResponse
    {
        try {
            $hall->delete();
            return $this->success(null, 'Hall deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete hall', 500);
        }
    }

    public function bulkDelete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array|min:1',
            'ids.*' => 'required|integer|exists:halls,id',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            Hall::whereIn('id', $request->ids)->delete();
            return $this->success(null, 'Halls deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete halls', 500);
        }
    }
}
