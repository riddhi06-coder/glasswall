<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeBanner extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'home_banners';

    protected $fillable = [
        'banner_heading',
        'banner_title',
        'banner_media',   // filename only
        'media_type',     // image | video
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /** Public URL for the stored media file. */
    public function getBannerMediaUrlAttribute(): ?string
    {
        return $this->banner_media
            ? asset('home/bannerimagevideo/'.$this->banner_media)
            : null;
    }

    public function isImage(): bool
    {
        return $this->media_type === 'image';
    }

    public function isVideo(): bool
    {
        return $this->media_type === 'video';
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
