<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EsgWasteFeature extends Model
{
    protected $table = 'esg_waste_features';

    protected $fillable = ['esg_id', 'image', 'feature', 'description', 'sort_order'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('esg-uploads/'.$this->image) : null;
    }
}
