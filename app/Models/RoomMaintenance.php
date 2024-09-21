<?php

namespace App\Models;

use App\Constants\Status;
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
    public function room(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    protected static function booted(): void
    {
        // When a maintenance is created, set the room status to "Under Maintenance"
        static::created(function ($maintenance) {
            $maintenance->room->update(['status' => Status::UnderMaintenance]);
        });

        // When maintenance is updated to 'completed', restore the room's original status
        static::updated(function ($maintenance) {
            if ($maintenance->status === Status::Completed) {
                $maintenance->room->update(['status' => Status::Available]); // Or another appropriate status
            }
        });
    }

    public function maintenanceType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MaintenanceType::class);
    }
}
