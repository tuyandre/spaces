<?php

namespace App\Models;

use App\Constants\Permission;
use App\Constants\Status;
use App\Traits\HasStatusColor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class AppointmentBooking extends Model
{
    use HasStatusColor;
    protected $appends = ['status_color'];
    protected $casts = [
        'date' => 'datetime'
    ];

    public function getStatusAttribute(): string
    {
        return ucfirst($this->attributes['status']);
    }


    public function flow(): MorphMany
    {
        return $this->morphMany(FlowHistory::class, 'flowable', 'model_type', 'model_id');
    }

    public function canBeReviewed()
    {
        return $this->status == Status::Pending && auth()->user()->can(Permission::ReviewBookingAppointments);
    }
}
