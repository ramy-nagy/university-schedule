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
        Schema::table('users', function (Blueprint $table) {
            // Add section_id column to students table
            // Allows students to be assigned to specific sections (for labs/practical sessions)
            // This is an integer field representing the section number, not a foreign key
            $table->integer('section_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeignIdFor('section_id');
            $table->dropColumn('section_id');
        });
    }
};
