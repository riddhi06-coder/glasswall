<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpoDocument extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'ipo_documents';

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'title',
        'group',
        'subgroup',
        'is_group_header',
        'pdf',
        'is_active',
        'priority',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active'       => 'boolean',
        'is_group_header' => 'boolean',
        'priority'        => 'integer',
    ];

    public function getBannerImageUrlAttribute(): ?string
    {
        return $this->banner_image ? asset('ipo-docs/'.$this->banner_image) : null;
    }

    /** URL to the stored file (PDF or MP4). */
    public function getPdfUrlAttribute(): ?string
    {
        return $this->pdf ? asset('ipo-docs/'.$this->pdf) : null;
    }
}
