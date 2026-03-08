<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sections from 1 to 200 with Arabic names
        for ($i = 1; $i <= 200; $i++) {
            Section::create([
                'name' => $i,
                'description' => "القسم رقم " . $i,
            ]);
        }
    }
}
