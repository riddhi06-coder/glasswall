<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectManagementPointer extends Model
{
    protected $table = 'project_management_pointers';

    protected $fillable = [
        'project_management_id',
        'pointer',
        'image',
        'sort_order',
    ];

    public function projectManagement(): BelongsTo
    {
        return $this->belongsTo(ProjectManagement::class, 'project_management_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('project-mgmt/'.$this->image) : null;
    }
}
