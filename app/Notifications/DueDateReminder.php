<?php

namespace App\Notifications;

use App\Models\Borrowing;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DueDateReminder extends Notification
{
    use Queueable;

    /**
     * The borrowing associated with this notification.
     */
    public function __construct(
        public Borrowing $borrowing
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'due_date_reminder',

            'borrowing_id' => $this->borrowing->id,

            'book_id' => $this->borrowing->book_id,

            'book_title' => $this->borrowing->book->title,

            'due_at' => $this->borrowing->due_at?->toDateTimeString(),

            'message' => 'Your borrowed book is due soon: '
                . $this->borrowing->book->title,
        ];
    }
}