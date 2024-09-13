<?php

namespace App\Models;

use App\Traits\HasEncodedId;
use App\Traits\HasStatusColor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Building extends Model
{
    use HasEncodedId,HasStatusColor;

    protected $appends = ['status_color'];
    public function buildingType(): BelongsTo
    {
        return $this->belongsTo(BuildingType::class);
    }
}
