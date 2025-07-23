<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $discount_start_date = $this->faker->dateTimeBetween('-1 week', '+1 week');
        $discount_end_date = $this->faker->dateTimeBetween($discount_start_date, '+2 week');
        $discounted_price = $this->faker->randomFloat(2, 10, 2000);
        $based_price = $this->faker->randomFloat(2, $discounted_price, 2000);

        return [
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(3),
            'based_price' => $based_price,
            'discounted_price' => $discounted_price,
            'discount_start_date' => $discount_start_date,
            'discount_end_date' => $discount_end_date,
            'requirements' => $this->faker->randomElements([
                'Basic computer skills',
                'Internet connection',
                'Headphones',
                'Notebook',
                'Curiosity'
            ], rand(2, 4)),
            'goals' => $this->faker->randomElements([
                'Understand AI fundamentals',
                'Build a simple app',
                'Improve web skills',
                'Get certified',
                'Start freelancing'
            ], rand(2, 4)),
            'image_url' => 'https://picsum.dev/static/' . rand(1, 2000) . '/300/200',
        ];
    }
}
