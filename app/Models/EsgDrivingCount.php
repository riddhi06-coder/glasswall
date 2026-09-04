<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EsgDrivingCount extends Model
{
    protected $table = 'esg_driving_counts';

    protected $fillable = ['esg_id', 'image', 'count', 'feature', 'sort_order'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('esg-uploads/'.$this->image) : null;
    }
}
