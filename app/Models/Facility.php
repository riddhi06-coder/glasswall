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
        return $fileName ? asset('facility/'.$fileName) : null;
    }
}
