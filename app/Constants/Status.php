<?php

namespace App\Constants;

class Status
{
    const Draft = 'Draft';
    const Pending = 'Pending';
    const Submitted = 'Submitted';
    const Rejected = 'Rejected';
    const Approved = 'Approved';
    const Cancelled = 'Cancelled';

    const Available = 'Available';
    const Booked = 'Booked';
    const UnderMaintenance = 'Under Maintenance';

    public static function roomStatuses(): array
    {
        return [
            self::Available,
            self::Booked,
            self::UnderMaintenance,
        ];
    }


}
