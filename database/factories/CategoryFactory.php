<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Category;


class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Programming',
                'Science',
                'Technology',
                'History',
                'Literature',
                'Business',
                'Mathematics',
                'Self Development',
                'Biography',
                'Fiction',
            ]),

            'description' => fake()->sentence(),
        ];
    }
}