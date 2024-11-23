<?php

namespace App\Http\Requests;

use App\Constants\Status;
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
            'room_type_id' => ['required', 'exists:room_types,id'],
            'guests' => ['required', 'integer', 'min:1'],
            'room_id' => [
                'required', 'exists:rooms,id',
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
                            ->whereIn('status', [Status::Approved, Status::Pending]) // Consider only active bookings
                            ->exists(); // Check if any such booking exists

                        if ($hasOverlappingBookings) {
                            $fail('The room is already booked for the selected dates.');
                        }
                    }
                }
            ],
            'start_date' => ['required', 'date_format:Y-m-d\TH:i', 'after_or_equal:now'],
            'end_date' => ['required', 'date_format:Y-m-d\TH:i', 'after:start_date'],
            'is_guest_booking' => ['nullable', 'string'],
            'guest_name' => ['nullable','required_if:is_guest_booking,on', 'string'],
            'guest_email' => ['nullable','required_if:is_guest_booking,on', 'email'],
            'guest_phone' => ['nullable','required_if:is_guest_booking,on', 'string'],
            'purpose' => ['required', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'room_type_id.required' => 'Please select a room type.',
            'room_type-id.exists' => 'The selected room type does not exist.',
            'guests.required' => 'Please enter the number of guests.',
            'guests.integer' => 'Please enter a valid number of guests.',
            'guests.min' => 'The minimum number of guests is 1.',
            'room_id.required' => 'Please select a room.',
            'room_id.exists' => 'The selected room does not exist.',
            'room_id.unique' => 'The selected room is already booked for the selected dates.',
            'start_date.required' => 'Please enter the start date and time.',
            'start_date.date_format' => 'Please enter a valid date and time format (YYYY-MM-DD HH:MM).',
            'start_date.after_or_equal' => 'The start date and time must be a future date and time.',
            'end_date.required' => 'Please enter the end date and time.',
            'end_date.date_format' => 'Please enter a valid date and time format (YYYY-MM-DD HH:MM).',
            'end_date.after' => 'The end date and time must be after the start date and time.',
            'is_guest_booking.string' => 'Please enter a valid value for is_guest_booking.',
            'guest_name.required_if' => 'Please enter the guest name.',
            'guest_name.string' => 'Please enter a valid guest name.',
            'guest_email.required_if' => 'Please enter the guest email.',
            'guest_email.email' => 'Please enter a valid guest email.',
            'guest_phone.required_if' => 'Please enter the guest phone number.',
            'guest_phone.string' => 'Please enter a valid guest phone number.',
            'purpose.required' => 'Please enter the purpose of the booking.',
            'purpose.string' => 'Please enter a valid purpose of the booking.',
        ];
    }
}
