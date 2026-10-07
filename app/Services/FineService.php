<?php

namespace App\Services;

use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\Support\Facades\DB;

class FineService
{
    /**
     * Fine charged per overdue day.
     */
    private const DAILY_FINE = 10;

    /**
     * Create or update the fine for an overdue borrowing.
     *
     * Returns the Fine model when a fine is required.
     * Returns null when the borrowing is not overdue.
     */
    public function createOrUpdateFine(Borrowing $borrowing): ?Fine
    {
        if (!$borrowing->due_at) {
            return null;
        }

        /*
         * A returned book can still have a fine if it was
         * returned after its due date.
         *
         * Therefore, calculate the overdue period using:
         *
         * returned_at when available
         * otherwise the current time.
         */
        $endDate = $borrowing->returned_at ?? now();

        if ($endDate->lessThanOrEqualTo($borrowing->due_at)) {
            return null;
        }

        /*
         * Calculate the number of overdue days.
         *
         * Using ceil() means even part of an overdue day
         * counts as one full overdue day.
         */
        $overdueDays = (int) ceil(
            $borrowing->due_at->diffInSeconds($endDate) / 86400
        );

        if ($overdueDays <= 0) {
            return null;
        }

        $amount = $overdueDays * self::DAILY_FINE;

        return DB::transaction(function () use (
            $borrowing,
            $amount
        ) {
            /*
             * Lock the fine row when it already exists.
             * This helps prevent duplicate/update conflicts.
             */
            $fine = Fine::query()
                ->where('borrowing_id', $borrowing->id)
                ->lockForUpdate()
                ->first();

            /*
             * No fine exists yet.
             */
            if (!$fine) {
                return Fine::create([
                    'borrowing_id' => $borrowing->id,
                    'amount' => $amount,
                    'status' => 'unpaid',
                    'paid_at' => null,
                ]);
            }

            /*
             * Never change a fine that has already been paid.
             */
            if ($fine->status === 'paid') {
                return $fine;
            }

            /*
             * Update the unpaid fine if the overdue amount
             * has increased.
             */
            if ((float) $fine->amount !== (float) $amount) {
                $fine->update([
                    'amount' => $amount,
                ]);
            }

            return $fine->fresh();
        });
    }

    /**
     * Return the daily fine rate.
     */
    public function dailyFine(): int
    {
        return self::DAILY_FINE;
    }
}