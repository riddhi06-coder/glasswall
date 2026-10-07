<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsImage extends Model
{
    protected $fillable = [
        'about_us_id',
        'image',
        'sort_order',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('about/'.$this->image) : null;
    }
}
