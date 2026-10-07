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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('book_id')
                ->constrained('books')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('member_id')
                ->constrained('members')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->dateTime('issued_at');

            $table->dateTime('due_at');

            $table->dateTime('returned_at')
                ->nullable();

            $table->enum('status', [
                'borrowed',
                'returned',
                'overdue',
            ])->default('borrowed');

            $table->timestamps();

            $table->index([
                'member_id',
                'status',
            ]);

            $table->index([
                'book_id',
                'status',
            ]);

            $table->index('due_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};