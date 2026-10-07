<?php
use App\Jobs\SendDueDateReminder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('app:process-overdue-borrowings')
    ->daily();

Schedule::job(new SendDueDateReminder)
    ->daily();