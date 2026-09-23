<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'facilities';

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'about_heading',
        'about_description',
        'counter_image',
        'process_heading',
        'process_description',
        'testing_heading',
        'testing_content',
        'testing_image1',
        'testing_image2',
        'testing2_content',
        'testing2_image1',
        'testing2_image2',
        'nabl_heading',
        'nabl_image',
        'precision_heading',
        'precision_content',
        'mockup_caption',
        'mockup_image1',
        'mockup_image2',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function features(): HasMany
    {
        return $this->hasMany(FacilityFeature::class, 'facility_id')->orderBy('sort_order');
    }

    public function counters(): HasMany
    {
        return $this->hasMany(FacilityCounter::class, 'facility_id')->orderBy('sort_order');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(FacilityGallery::class, 'facility_id')->orderBy('sort_order');
    }

    public function strengths(): HasMany
    {
        return $this->hasMany(FacilityStrength::class, 'facility_id')->orderBy('sort_order');
    }

    /** URL to any stored image for this record. */
    public function assetUrl(?string $fileName): ?string
    {
        return $fileName ? asset('facility-uploads/'.$fileName) : null;
    }
}
