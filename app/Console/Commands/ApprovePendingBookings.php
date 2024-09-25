<?php

namespace App\Console\Commands;

use App\Constants\Status;
use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Carbon;

class ApprovePendingBookings extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'app:approve-pending-bookings';
    // The name and signature of the console command
    protected $signature = 'bookings:auto-approve {hours?}';

    // The console command description
    protected $description = 'Automatically approve pending bookings after a configurable number of hours.';

    // Execute the console command
    public function handle(): void
    {
        // Get the number of hours from the command argument or config
        $hours = $this->argument('hours') ?? config('bookings.auto_approval_hours', 2); // Default 2 hours

        // Calculate the time threshold
        $thresholdTime = Carbon::now()->subHours($hours);

        // Find pending bookings created before the threshold time
        $pendingBookings = Booking::where('status', Status::Pending)
            ->where('created_at', '<=', $thresholdTime)
            ->get();

        // Approve each pending booking
        foreach ($pendingBookings as $booking) {
            $booking->status = Status::Approved;
            $booking->reviewed_at = Carbon::now();
            $booking->approval_type = 'auto';
            $booking->save();

            $this->info("Booking ID {$booking->id} has been auto-approved.");
        }

        $this->info('Auto-approval of pending bookings completed.');
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<string, string>
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'hours'=>'How many hours after which pending bookings should be auto-approved?'
        ];
    }
}
