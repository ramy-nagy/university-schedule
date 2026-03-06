<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

Route::middleware(['auth:sanctum'])->group(function () {
    
    // ── Admin APIs ──────────────────────────────────────────
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // ── Doctors APIs
        Route::apiResource('doctors', Api\Admin\DoctorApiController::class);
        Route::post('doctors/bulk-delete', [Api\Admin\DoctorApiController::class, 'bulkDelete']);
        
        // ── Halls APIs
        Route::apiResource('halls', Api\Admin\HallApiController::class);
        Route::post('halls/bulk-delete', [Api\Admin\HallApiController::class, 'bulkDelete']);
        
        // ── Subjects APIs
        Route::apiResource('subjects', Api\Admin\SubjectApiController::class);
        Route::post('subjects/bulk-delete', [Api\Admin\SubjectApiController::class, 'bulkDelete']);
        
        // ── Student Groups APIs
        Route::apiResource('student-groups', Api\Admin\StudentGroupApiController::class);
        Route::post('student-groups/bulk-delete', [Api\Admin\StudentGroupApiController::class, 'bulkDelete']);
        
        // ── Schedules APIs
        Route::apiResource('schedules', Api\Admin\ScheduleApiController::class);
        Route::get('schedules/conflicts/check', [Api\Admin\ScheduleApiController::class, 'checkConflicts']);
        Route::post('schedules/bulk-delete', [Api\Admin\ScheduleApiController::class, 'bulkDelete']);
        
        // ── Students APIs
        Route::apiResource('students', Api\Admin\StudentApiController::class);
        Route::post('students/bulk-delete', [Api\Admin\StudentApiController::class, 'bulkDelete']);
        
        // ── Dashboard APIs
        Route::get('dashboard', [Api\Admin\DashboardApiController::class, 'index']);
    });
    
    // ── Doctor APIs ─────────────────────────────────────────
    Route::middleware('role:doctor')->prefix('doctor')->name('doctor.')->group(function () {
        Route::get('dashboard', [Api\Doctor\DashboardApiController::class, 'index']);
        Route::get('schedules', [Api\Doctor\ScheduleApiController::class, 'index']);
        Route::get('schedules/{schedule}', [Api\Doctor\ScheduleApiController::class, 'show']);
    });
    
    // ── Student APIs ────────────────────────────────────────
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('dashboard', [Api\Student\DashboardApiController::class, 'index']);
        Route::get('schedules', [Api\Student\ScheduleApiController::class, 'index']);
        Route::get('schedules/{schedule}', [Api\Student\ScheduleApiController::class, 'show']);
    });
});
