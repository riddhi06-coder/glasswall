<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LegalPage extends Model
{
    use SoftDeletes, TracksDeletedBy;

    /** Upload directory under /public (distinct from any route path). */
    public const DIR = 'legal-uploads';

    protected $fillable = [
        'slug',
        'heading',
        'banner_image',
        'content',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function getBannerImageUrlAttribute(): ?string
    {
        return $this->banner_image ? asset(self::DIR.'/'.$this->banner_image) : null;
    }
}
