<?php

namespace App\Constants;

class Permission
{
    public const MANAGE_USERS = 'manage_users';
    public const MANAGE_ROOMS = 'manage_rooms';
    public const MANAGE_BUILDINGS = 'manage_buildings';
    public const MANAGE_BUILDING_TYPES = 'manage_building_types';
    public const MANAGE_ROOM_TYPES = 'manage_room_types';
    public const MANAGE_BOOKINGS = 'manage_bookings';
    public const MANAGE_ROLES = 'manage_roles';
    public const  VIEW_PERMISSIONS = 'view_permissions';
    public const MANAGE_MAINTENANCE = 'manage_maintenance';


    public static function all(): array
    {
        return [
            self::MANAGE_USERS,
            self::MANAGE_ROOMS,
            self::MANAGE_BUILDINGS,
            self::MANAGE_ROOM_TYPES,
            self::MANAGE_BOOKINGS,
            self::VIEW_PERMISSIONS,
            self::MANAGE_MAINTENANCE,
        ];
    }


}
