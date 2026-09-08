<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnnualReport extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'annual_reports';

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'title',
        'pdf',
        'is_active',
        'priority',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'priority'  => 'integer',
    ];

    public function getBannerImageUrlAttribute(): ?string
    {
        return $this->banner_image ? asset('annual-reports/'.$this->banner_image) : null;
    }

    public function getPdfUrlAttribute(): ?string
    {
        return $this->pdf ? asset('annual-reports/'.$this->pdf) : null;
    }
}
