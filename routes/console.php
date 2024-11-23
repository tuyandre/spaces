<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;


// Run the auto-approve bookings command every hour
//$schedule->command('bookings:auto-approve')->hourly();

Artisan::command('bookings:auto-approve {hours?}', function () {
    $this->info('Auto-approve bookings command executed.');
})->purpose('Auto-approve bookings if the end date has passed')
    ->hourly();
