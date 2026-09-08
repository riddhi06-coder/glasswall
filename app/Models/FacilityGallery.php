<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacilityGallery extends Model
{
    protected $table = 'facility_galleries';

    protected $fillable = [
        'facility_id',
        'image',
        'heading',
        'sort_order',
    ];

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('facility-uploads/'.$this->image) : null;
    }
}
