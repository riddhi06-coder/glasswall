<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeClienteleImage extends Model
{
    protected $table = 'home_clientele_images';

    protected $fillable = [
        'home_clientele_id',
        'image',
        'sort_order',
    ];

    public function clientele(): BelongsTo
    {
        return $this->belongsTo(HomeClientele::class, 'home_clientele_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('home/clienteleimages/'.$this->image) : null;
    }
}
