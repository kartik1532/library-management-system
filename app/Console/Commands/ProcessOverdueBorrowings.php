<?php

namespace App\Console\Commands;

use App\Models\Borrowing;
use App\Services\FineService;
use Illuminate\Console\Command;

class ProcessOverdueBorrowings extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:process-overdue-borrowings';

    /**
     * The console command description.
     */
    protected $description = 'Mark overdue borrowings and create or update fines';

    /**
     * Execute the console command.
     */
    public function handle(FineService $fineService): int
    {
        $this->info('Processing overdue borrowings...');

        /*
         * Find borrowed records whose due date has passed.
         */
        $borrowedBorrowings = Borrowing::query()
            ->where('status', 'borrowed')
            ->whereNotNull('due_at')
            ->where('due_at', '<', now())
            ->get();

        $newlyOverdue = 0;

        foreach ($borrowedBorrowings as $borrowing) {
            $borrowing->update([
                'status' => 'overdue',
            ]);

            $fineService->createOrUpdateFine($borrowing);

            $newlyOverdue++;

            $this->line(
                "Borrowing #{$borrowing->id} marked as overdue."
            );
        }

        /*
         * Update fines for borrowings that were already overdue.
         *
         * This allows the fine amount to increase as additional
         * overdue days pass.
         */
        $existingOverdueBorrowings = Borrowing::query()
            ->where('status', 'overdue')
            ->whereNotNull('due_at')
            ->get();

        $updatedFines = 0;

        foreach ($existingOverdueBorrowings as $borrowing) {
            $fine = $fineService->createOrUpdateFine($borrowing);

            if ($fine) {
                $updatedFines++;

                $this->line(
                    "Fine processed for borrowing #{$borrowing->id}: {$fine->amount}"
                );
            }
        }

        $this->newLine();

        $this->info(
            "Newly overdue borrowings: {$newlyOverdue}"
        );

        $this->info(
            "Fines processed: {$updatedFines}"
        );

        $this->info('Overdue processing completed successfully.');

        return self::SUCCESS;
    }
}