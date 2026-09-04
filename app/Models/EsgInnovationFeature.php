<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EsgInnovationFeature extends Model
{
    protected $table = 'esg_innovation_features';

    protected $fillable = ['esg_id', 'image', 'feature', 'description', 'sort_order'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('esg-uploads/'.$this->image) : null;
    }
}
