<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Borrowing>
 */
class BorrowingFactory extends Factory
{
    protected $model = Borrowing::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $issuedAt = fake()->dateTimeBetween(
            '-3 months',
            '-10 days'
        );

        $dueAt = (clone $issuedAt);

        $dueAt->modify('+14 days');

        return [
            'book_id' => Book::factory(),

            'member_id' => Member::factory(),

            'issued_at' => $issuedAt,

            'due_at' => $dueAt,

            'returned_at' => null,

            'status' => 'borrowed',
        ];
    }
}