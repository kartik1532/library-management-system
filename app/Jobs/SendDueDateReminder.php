<?php

namespace App\Jobs;

use App\Models\Borrowing;
use App\Notifications\DueDateReminder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendDueDateReminder implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $now = now();

        $reminderLimit = now()->addDay();

        $borrowings = Borrowing::query()
            ->with([
                'book',
                'member.user',
            ])
            ->where('status', 'borrowed')
            ->whereNotNull('due_at')
            ->where('due_at', '>', $now)
            ->where('due_at', '<=', $reminderLimit)
            ->get();

        foreach ($borrowings as $borrowing) {
            $user = $borrowing->member?->user;

            if (!$user) {
                continue;
            }

            $alreadyNotified = $user->notifications()
                ->where('type', DueDateReminder::class)
                ->where(
                    'data->borrowing_id',
                    $borrowing->id
                )
                ->exists();

            if ($alreadyNotified) {
                continue;
            }

            $user->notify(
                new DueDateReminder($borrowing)
            );
        }
    }
}