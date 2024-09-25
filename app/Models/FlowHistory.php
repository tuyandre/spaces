<?php

namespace App\Models;

use App\Traits\HasStatusColor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlowHistory extends Model
{
    use HasStatusColor;
    public function flowable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function doneBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'done_by_id','id');
    }
}
