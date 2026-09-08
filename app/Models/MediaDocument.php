<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaDocument extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'media_id',
        'title',
        'pdf',
        'priority',
    ];

    public function getPdfUrlAttribute(): ?string
    {
        return $this->pdf ? asset('media-uploads/'.$this->pdf) : null;
    }
}
