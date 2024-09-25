<?php

namespace App\Models;

use App\Constants\Permission;
use App\Constants\Status;
use App\Traits\HasEncodedId;
use App\Traits\HasStatusColor;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

/**
 *
 *
 * @property int $id
 * @property int $room_id
 * @property int $user_id
 * @property string $start_date
 * @property string $end_date
 * @property string|null $purpose
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Booking newModelQuery()
 * @method static Builder|Booking newQuery()
 * @method static Builder|Booking query()
 * @method static Builder|Booking whereCreatedAt($value)
 * @method static Builder|Booking whereEndDate($value)
 * @method static Builder|Booking whereId($value)
 * @method static Builder|Booking wherePurpose($value)
 * @method static Builder|Booking whereRoomId($value)
 * @method static Builder|Booking whereStartDate($value)
 * @method static Builder|Booking whereStatus($value)
 * @method static Builder|Booking whereUpdatedAt($value)
 * @method static Builder|Booking whereUserId($value)
 * @mixin Eloquent
 */
class Booking extends Model implements Auditable
{
    use HasStatusColor, HasEncodedId, HasFactory, \OwenIt\Auditing\Auditable;

    protected $appends = ['status_color'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    // getter for status
    public function getStatusAttribute($value): string
    {
        return ucfirst($value);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($booking) {
            // Generate booking code after the booking has been created
            $booking->booking_code = Booking::generateBookingCode($booking);
            $booking->save();
        });
    }

    public static function generateBookingCode($booking): string
    {
        // Combine the booking ID and room ID to form part of the booking code
        $code = $booking->id . $booking->room_id;

        // Pad the code to a length of 10 and prefix with "BKG"
        // Ensure the code is unique
        return 'BKG' . str_pad($code, 5, '0', STR_PAD_LEFT);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function flow(): MorphMany
    {
        return $this->morphMany(FlowHistory::class, 'flowable', 'model_type','model_id');
    }


    public function canBeCanceled(): bool
    {
        $bookingStatus = strtolower($this->status);
        $pendingStatus = strtolower(Status::Pending);
        if ($bookingStatus != $pendingStatus)
            return false;
        // the logged-in user is the owner of the booking or have the permission to cancel bookings
        return auth()->user()->id == $this->user_id || auth()->user()->can(Permission::CancelBooking);
    }

    public function canBeReviewed()
    {
        $bookingStatus = strtolower($this->status);
        $pendingStatus = strtolower(Status::Pending);
        if ($bookingStatus != $pendingStatus)
            return false;
        // the logged-in user  have the permission to review bookings
        return auth()->user()->can(Permission::ReviewBooking);
    }

}
