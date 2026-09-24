<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacilityTestingImage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'facility_id',
        'block',
        'image',
        'caption',
        'sort_order',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('facility-uploads/'.$this->image) : null;
    }
}
