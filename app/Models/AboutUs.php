<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutUs extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'about_us';

    protected $fillable = [
        'banner_heading',
        'banner_video',
        'section_heading',
        'section_image',
        'description',
        'vision_section_heading',
        'vision_section_description',
        'vision_logo',
        'vision_heading',
        'vision_title',
        'vision_desc',
        'vision_image',
        'mission_logo',
        'mission_heading',
        'mission_title',
        'mission_desc',
        'mission_image',
        'core_title',
        'core_description',
        'core_image',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /** URL to any stored asset (images/video) for this record. */
    public function assetUrl(?string $fileName): ?string
    {
        return $fileName ? asset('about/'.$fileName) : null;
    }
}
