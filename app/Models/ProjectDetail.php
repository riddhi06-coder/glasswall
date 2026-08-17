<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectDetail extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'project_details';

    protected $fillable = [
        'project_listing_id',
        'banner_image',
        'image',
        'client',
        'architect',
        'consultant',
        'project_area',
        'floors',
        'scope_of_work',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'scope_of_work' => 'array',
    ];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(ProjectListing::class, 'project_listing_id');
    }

    public function getBannerImageUrlAttribute(): ?string
    {
        return $this->banner_image ? asset('project/details/'.$this->banner_image) : null;
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('project/details/'.$this->image) : null;
    }
}
