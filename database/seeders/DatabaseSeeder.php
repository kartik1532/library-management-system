<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
         * Create or update admin user.
         */
        User::firstOrCreate(
            ['email' => 'admin@library.test'],
            [
                'name' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        /*
         * Create demo authors only if none exist.
         */
        if (Author::count() === 0) {
            $authors = Author::factory()
                ->count(5)
                ->create();
        } else {
            $authors = Author::all();
        }

        /*
         * Create demo categories only if none exist.
         */
        if (Category::count() === 0) {
            $categories = Category::factory()
                ->count(5)
                ->create();
        } else {
            $categories = Category::all();
        }

        /*
         * Create demo books only if none exist.
         */
        if (Book::count() === 0) {
            Book::factory()
                ->count(20)
                ->recycle($authors)
                ->recycle($categories)
                ->create();
        }
    }
}