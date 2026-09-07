<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacilityCounter extends Model
{
    protected $table = 'facility_counters';

    protected $fillable = [
        'facility_id',
        'count',
        'suffix',
        'label',
        'sort_order',
    ];

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }
}
