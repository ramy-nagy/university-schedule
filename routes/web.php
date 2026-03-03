<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin;
use App\Http\Controllers\Doctor;
use App\Http\Controllers\Student;

Route::view('/', 'welcome')->name('home');

Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('admin.dashboard')->middleware(['auth', 'role:admin']);

// ── Admin Routes ──────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('halls',          Admin\HallController::class);
        Route::resource('doctors',        Admin\DoctorController::class);
        Route::resource('subjects',       Admin\SubjectController::class);
        Route::resource('student-groups', Admin\StudentGroupController::class);
        Route::resource('schedules',      Admin\ScheduleController::class);
        Route::resource('students',        Admin\StudentController::class); // ✅ جديد
    });

// ── Doctor Routes ─────────────────────────────────────────
Route::middleware(['auth', 'role:doctor'])
    ->prefix('doctor')
    ->name('doctor.')
    ->group(function () {
        Route::get('/dashboard', [Doctor\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/schedule',  [Doctor\DashboardController::class, 'schedule'])->name('schedule');
    });

// ── Student Routes ────────────────────────────────────────
Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', [Student\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/schedule',  [Student\DashboardController::class, 'schedule'])->name('schedule');
    });

require __DIR__.'/settings.php';
