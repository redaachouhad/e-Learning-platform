<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Language;
use App\Models\Pricing;
use App\Models\Proficiency;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();
        $languages = Language::all();
        $proficiencies = Proficiency::all();
        $pricingTypes = Pricing::all();
        Course::factory()->count(500)->make()->each(function ($course) use ($users, $categories, $languages, $pricingTypes, $proficiencies) {
            $course->user_id = $users->random()->id;
            $course->category_id = $categories->random()->id;
            $course->language_id = $languages->random()->id;
            $course->pricing_id = $pricingTypes->random()->id;
            $course->proficiency_id = $proficiencies->random()->id;
            $course->save();
        });
    }
}
