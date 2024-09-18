<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

//bookings:mark-completed

Artisan::command('bookings:mark-completed', function () {
    $this->info('Bookings marked as completed.');
})->purpose('Mark bookings as completed if the end date has passed')
    ->dailyAt('00:01');
