<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CareerDetail extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'career_details';

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'section_heading',
        'section_image',
        'description',
        'job_section_heading',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /** URL to any stored image for this record. */
    public function assetUrl(?string $fileName): ?string
    {
        return $fileName ? asset('careers-uploads/'.$fileName) : null;
    }
}
