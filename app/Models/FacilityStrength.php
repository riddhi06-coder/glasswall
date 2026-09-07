<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacilityStrength extends Model
{
    protected $table = 'facility_strengths';

    protected $fillable = [
        'facility_id',
        'title',
        'description',
        'sort_order',
    ];

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }
}
