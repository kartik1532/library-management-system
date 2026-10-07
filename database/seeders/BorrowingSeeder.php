<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BorrowingSeeder extends Seeder
{
    /**
     * Seed sample borrowing records.
     */
    public function run(): void
    {
        $books = Book::query()
            ->where('quantity', '>', 0)
            ->get();

        $members = Member::query()
            ->where('status', 'active')
            ->get();

        if ($books->isEmpty() || $members->isEmpty()) {
            return;
        }

        DB::transaction(function () use (
            $books,
            $members
        ) {
            $borrowedBooks = $books->take(3);

            foreach ($borrowedBooks as $index => $book) {
                if ($book->available_quantity < 1) {
                    continue;
                }

                $issuedAt = now()->subDays(
                    10 + $index
                );

                $dueAt = $issuedAt->copy()
                    ->addDays(7);

                $borrowing = Borrowing::create([
                    'book_id' => $book->id,

                    'member_id' => $members[$index % $members->count()]->id,

                    'issued_at' => $issuedAt,

                    'due_at' => $dueAt,

                    'returned_at' => null,

                    'status' => 'overdue',
                ]);

                $book->decrement(
                    'available_quantity'
                );

                Fine::create([
                    'borrowing_id' => $borrowing->id,

                    'amount' => 30.00,

                    'status' => 'unpaid',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Returned example
            |--------------------------------------------------------------------------
            */

            $returnedBook = $books->get(3);

            if (
                $returnedBook &&
                $returnedBook->available_quantity < $returnedBook->quantity
            ) {
                Borrowing::create([
                    'book_id' => $returnedBook->id,

                    'member_id' => $members[0]->id,

                    'issued_at' => now()->subDays(30),

                    'due_at' => now()->subDays(16),

                    'returned_at' => now()->subDays(15),

                    'status' => 'returned',
                ]);
            }
        });
    }
}