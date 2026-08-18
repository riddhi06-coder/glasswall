<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectCategory extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'project_categories';

    public function listings(): HasMany
    {
        return $this->hasMany(ProjectListing::class, 'project_category_id');
    }

    /** Alias used by the route's scoped binding (/{category}/{project:slug}). */
    public function projects(): HasMany
    {
        return $this->hasMany(ProjectListing::class, 'project_category_id');
    }

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'priority',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail ? asset('project/categories/'.$this->thumbnail) : null;
    }
}
