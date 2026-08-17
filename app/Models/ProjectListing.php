<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectListing extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'project_listings';

    protected $fillable = [
        'project_category_id',
        'name',
        'slug',
        'thumbnail',
        'location',
        'is_active',
        'show_on_home',
        'priority',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'show_on_home' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail ? asset('project/listings/'.$this->thumbnail) : null;
    }
}
