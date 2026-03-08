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
        Schema::table('schedules', function (Blueprint $table) {
            // Add section_id to distinguish between lecture and section assignments
            // Nullable because lectures don't require a section
            if (!Schema::hasColumn('schedules', 'section_id')) {
                $table->integer('section_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            if (Schema::hasColumn('schedules', 'section_id')) {
                $table->dropColumn('section_id');
            }
        });
    }
};
