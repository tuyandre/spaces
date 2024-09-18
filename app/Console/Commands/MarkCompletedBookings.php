<?php

namespace App\Console\Commands;

use App\Constants\Status;
use App\Models\Booking;
use Illuminate\Console\Command;

class MarkCompletedBookings extends Command
{
    protected $signature = 'bookings:mark-completed';
    protected $description = 'Mark bookings as completed if the end date has passed';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        Booking::where('end_date', '<', now())
            ->where(\DB::raw("LOWER(status)"), '=', strtolower(Status::Confirmed)) // Only mark confirmed bookings
            ->update(['status' => Status::Completed]);

        $this->info('Bookings marked as completed.');
    }
}
