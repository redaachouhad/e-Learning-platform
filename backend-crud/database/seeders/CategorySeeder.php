<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [
            'Development',
            'Design',
            'Artificial Intelligence',
            'Data Science',
            'Business',
            'Marketing',
            'Languages',
            'Office Tools',
            'Cybersecurity',
            'Project Management',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
