<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'media';

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'video',
        'section_subtitle',
        'section_heading',
        'section_intro',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(MediaDocument::class, 'media_id')->orderBy('priority')->orderBy('id');
    }

    public function assetUrl(?string $fileName): ?string
    {
        return $fileName ? asset('media-uploads/'.$fileName) : null;
    }
}
