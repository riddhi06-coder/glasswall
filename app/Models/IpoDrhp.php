<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpoDrhp extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'ipo_drhps';

    protected $fillable = [
        'banner_image',
        'banner_image_2',
        'page1_heading',
        'page1_content',
        'page2_heading',
        'page2_content',
        'pdf',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function getPdfUrlAttribute(): ?string
    {
        return $this->pdf ? asset('ipo-docs/'.$this->pdf) : null;
    }

    public function getBannerImageUrlAttribute(): ?string
    {
        return $this->banner_image ? asset('ipo-docs/'.$this->banner_image) : null;
    }

    public function getBannerImage2UrlAttribute(): ?string
    {
        return $this->banner_image_2 ? asset('ipo-docs/'.$this->banner_image_2) : null;
    }
}
