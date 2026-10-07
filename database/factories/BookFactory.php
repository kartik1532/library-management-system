<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 10);

        return [
            'title' => fake()->sentence(
                fake()->numberBetween(2, 6)
            ),

            'isbn' => fake()->unique()->numerify(
                '978#############'
            ),

            'author_id' => Author::factory(),

            'category_id' => Category::factory(),

            'description' => fake()->paragraph(),

            'quantity' => $quantity,

            'available_quantity' => $quantity,

            'cover_image' => null,
        ];
    }
}