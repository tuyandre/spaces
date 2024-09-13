<?php

namespace App\Models;

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
    use HasFactory;
}
