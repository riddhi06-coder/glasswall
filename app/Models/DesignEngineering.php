<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DesignEngineering extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'design_engineerings';

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'section_heading',
        'description',
        'features_heading',
        'features_image',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function features(): HasMany
    {
        return $this->hasMany(DesignEngineeringFeature::class, 'design_engineering_id')->orderBy('sort_order');
    }

    /** URL to any stored image for this record. */
    public function assetUrl(?string $fileName): ?string
    {
        return $fileName ? asset('design-engg/'.$fileName) : null;
    }
}
