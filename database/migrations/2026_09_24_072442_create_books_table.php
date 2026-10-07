<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->string('isbn')->unique();

            $table->foreignId('author_id')
                ->constrained('authors')
                ->restrictOnDelete();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            $table->text('description')->nullable();

            $table->unsignedInteger('quantity')->default(0);

            $table->unsignedInteger('available_quantity')->default(0);

            $table->string('cover_image')->nullable();

            $table->timestamps();

            $table->index('title');
            $table->index('author_id');
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};