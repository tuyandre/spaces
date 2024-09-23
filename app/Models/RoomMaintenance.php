<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\HasEncodedId;
use App\Traits\HasStatusColor;
use App\Traits\HasStatusIcon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $room_id
 * @property string $maintenance_date
 * @property string $description
 * @property string $maintenance_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereMaintenanceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereMaintenanceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomMaintenance whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RoomMaintenance extends Model
{
    use HasStatusColor, HasEncodedId, HasStatusIcon;

    protected $appends = ['status_color', 'status_icon'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function room(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Room::class);
    }


    public function maintenanceType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MaintenanceType::class);
    }

    // let's reconstruct statuses according to dates
    public function getStatusAttribute(): string
    {
        $now = now();
        $start = $this->start_date;
        $end = $this->end_date;

        if ($now->isBefore($start)) {
            return Status::Scheduled;
        }

        if ($now->isAfter($start) && $now->isBefore($end)) {
            return Status::InProgress;
        }

        if ($now->isAfter($end)) {
            return Status::Completed;
        }

        return Status::Unknown;
    }

}
