<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Esg extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'esgs';

    protected $fillable = [
        'banner_heading', 'banner_image',
        'director_image', 'director_heading', 'director_desc', 'director_name', 'director_position',
        'innovation_heading', 'innovation_bg_image',
        'dev_heading', 'dev_image', 'dev_desc',
        'driving_heading', 'driving_bg_image',
        'impact_heading',
        'stakeholder_heading', 'stakeholder_image', 'stakeholder_desc',
        'waste_heading', 'waste_desc',
        'env_heading', 'env_short_desc', 'env_specification_desc',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function innovationFeatures(): HasMany
    {
        return $this->hasMany(EsgInnovationFeature::class)->orderBy('sort_order')->orderBy('id');
    }

    public function drivingCounts(): HasMany
    {
        return $this->hasMany(EsgDrivingCount::class)->orderBy('sort_order')->orderBy('id');
    }

    public function impacts(): HasMany
    {
        return $this->hasMany(EsgImpact::class)->orderBy('sort_order')->orderBy('id');
    }

    public function wasteFeatures(): HasMany
    {
        return $this->hasMany(EsgWasteFeature::class)->orderBy('sort_order')->orderBy('id');
    }

    public function assetUrl(?string $fileName): ?string
    {
        return $fileName ? asset('esg-uploads/'.$fileName) : null;
    }
}
