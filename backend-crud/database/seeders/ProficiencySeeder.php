<?php

namespace Database\Seeders;

use App\Models\Proficiency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProficiencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            "Beginner",
            "Intermediate",
            "Professional",
            "Master",
            "Everyone",
        ];

        foreach ($levels as $level) {
            Proficiency::create(["level" => $level]);
        }
    }
}
