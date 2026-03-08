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
            // Drop the old integer section_id column
            if (Schema::hasColumn('users', 'section_id')) {
                $table->dropColumn('section_id');
            }
        });

        // Add new section_id as foreign key to sections table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('section_id')->nullable()->constrained('sections')->onDelete('set null');
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

        // Restore as integer
        Schema::table('users', function (Blueprint $table) {
            $table->integer('section_id')->nullable();
        });
    }
};
