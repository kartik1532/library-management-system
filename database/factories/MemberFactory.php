<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    protected $model = Member::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->member(),

            'phone' => fake()->phoneNumber(),

            'address' => fake()->address(),

            'membership_number' => 'LIB-' . fake()->unique()->numerify('######'),

            'join_date' => fake()->dateTimeBetween(
                '-2 years',
                'now'
            )->format('Y-m-d'),

            'status' => 'active',
        ];
    }
}