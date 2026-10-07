<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
         * Create authors.
         */
        $authors = Author::factory()
            ->count(5)
            ->create();

        /*
         * Create categories.
         */
        $categories = Category::factory()
            ->count(5)
            ->create();

        /*
         * Create books using existing authors
         * and categories.
         */
        Book::factory()
            ->count(20)
            ->recycle($authors)
            ->recycle($categories)
            ->create();
    }
}