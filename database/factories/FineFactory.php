<?php

namespace Database\Factories;

use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fine>
 */
class FineFactory extends Factory
{
    protected $model = Fine::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'borrowing_id' => Borrowing::factory(),

            'amount' => fake()->randomFloat(
                2,
                10,
                500
            ),

            'paid_at' => null,

            'status' => 'unpaid',
        ];
    }
}