<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        // ══════════════════════════════════════════════════════════
        // FILE: database/migrations/xxxx_create_halls_table.php
        // ══════════════════════════════════════════════════════════
        Schema::create('halls', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // e.g. "مدرج 6أ"
            $table->string('type');             // 'lecture_hall' | 'lab'
            $table->text('description')->nullable();
            $table->integer('capacity')->default(0);
            $table->timestamps();
        });

        // ══════════════════════════════════════════════════════════
        // FILE: database/migrations/xxxx_create_doctors_table.php
        // ══════════════════════════════════════════════════════════
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('department')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });

        // ══════════════════════════════════════════════════════════
        // FILE: database/migrations/xxxx_create_subjects_table.php
        // ══════════════════════════════════════════════════════════
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();    // e.g. "CS101"
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // ══════════════════════════════════════════════════════════
        // FILE: database/migrations/xxxx_create_student_groups_table.php
        // ══════════════════════════════════════════════════════════
        Schema::create('student_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // e.g. "المجموعة الأولى"
            $table->string('study_days');        // e.g. "السبت,الاثنين"
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // ══════════════════════════════════════════════════════════
        // FILE: database/migrations/xxxx_create_schedules_table.php
        // KEY TABLE: conflict detection happens here
        // ══════════════════════════════════════════════════════════
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('hall_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_group_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('type')->default('lecture'); // 'lecture' | 'lab'
            $table->timestamps();

            // Indexes for fast conflict checking
            $table->index(['hall_id', 'date', 'start_time', 'end_time']);
            $table->index(['doctor_id', 'date', 'start_time', 'end_time']);
            $table->index(['student_group_id', 'date', 'start_time', 'end_time']);
        });

        // ══════════════════════════════════════════════════════════
        // FILE: database/migrations/xxxx_add_role_to_users_table.php
        // ══════════════════════════════════════════════════════════
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'doctor', 'student'])->default('student');
            $table->foreignId('student_group_id')->nullable()->constrained();
            $table->foreignId('doctor_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halls');
    }
};
