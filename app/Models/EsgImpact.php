<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EsgImpact extends Model
{
    protected $table = 'esg_impacts';

    protected $fillable = ['esg_id', 'image', 'year', 'impact', 'description', 'sort_order'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('esg-uploads/'.$this->image) : null;
    }
}
