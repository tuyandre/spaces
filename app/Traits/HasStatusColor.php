<?php

namespace App\Traits;

use App\Constants\Status;

trait HasStatusColor
{
    public function getStatusColorAttribute(): string
    {
        $status = strtolower($this->status);

        return match ($status) {
            strtolower(Status::UnderMaintenance),
            strtolower(Status::Draft) => 'warning',

            strtolower(Status::Submitted) => 'info',

            strtolower(Status::Available),
            'active',
            strtolower(Status::Approved) => 'success',

            strtolower(Status::Rejected),
            strtolower(Status::Cancelled),
            'inactive',
            strtolower(Status::Booked) => 'danger',

            default => 'secondary',
        };
    }


}
