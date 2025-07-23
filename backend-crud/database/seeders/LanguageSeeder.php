<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            "English",
            "Spanish",
            "French",
            "German",
            "Bengali",
            "Hindi",
            "Arabic",
        ];

        foreach ($languages as $language) {
            Language::create(["name" => $language]);
        }
    }
}
