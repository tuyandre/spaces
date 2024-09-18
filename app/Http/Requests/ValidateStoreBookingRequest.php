<?php

namespace App\Http\Requests;

use App\Models\Room;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ValidateStoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'room_id' => ['required', 'exists:rooms,id',
                // Check if the room is available for the selected dates
                function ($attribute, $value, $fail) {
                    // Step 1: Ensure the room itself is available
                    $room = Room::where('id', $value)
                        ->where('status', 'available') // Ensure room status is available
                        ->first();

                    if (!$room) {
                        $fail('The room is not available for booking due to its current status.');
                        return;
                    }

                    // Step 2: Check for overlapping bookings
                    if ($this->start_date && $this->end_date) {
                        $hasOverlappingBookings = $room->bookings()
                            ->where(function ($query) {
                                $query->where('start_date', '<=', $this->end_date)
                                    ->where('end_date', '>=', $this->start_date);
                            })
                            ->whereIn('status', ['confirmed', 'pending']) // Only consider active bookings
                            ->exists();

                        if ($hasOverlappingBookings) {
                            $fail('The room is already booked for the selected dates.');
                        }
                    }

                }
            ],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'purpose' => ['required', 'string'],
        ];
    }
}
