<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        // Generate a random end date that is in the past or future
        $endDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $startDate = $this->faker->dateTimeBetween('-2 months', $endDate);

        // Generate a random status
        $statuses = ['confirmed', 'completed', 'cancelled'];
        $status = $this->faker->randomElement($statuses);

        return [
            'room_id' => \App\Models\Room::factory(), // Assuming you have a Room factory
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $status,
            'purpose' => $this->faker->word,
            'user_id' => \App\Models\User::factory(), // Assuming you have a User factory
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
