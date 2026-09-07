<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectManagement extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'project_managements';

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function pointers(): HasMany
    {
        return $this->hasMany(ProjectManagementPointer::class, 'project_management_id')->orderBy('sort_order');
    }

    /** URL to any stored image for this record. */
    public function assetUrl(?string $fileName): ?string
    {
        return $fileName ? asset('project-mgmt/'.$fileName) : null;
    }
}
