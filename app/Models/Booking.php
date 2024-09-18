<?php

namespace App\Models;

use App\Traits\HasEncodedId;
use App\Traits\HasStatusColor;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

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
class Booking extends Model
{
    use HasStatusColor, HasEncodedId,HasFactory;

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
}
