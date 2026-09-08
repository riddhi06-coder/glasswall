<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GovernanceDocument extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'governance_documents';

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'title',
        'group',
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
        return $this->banner_image ? asset('governance-docs/'.$this->banner_image) : null;
    }

    public function getPdfUrlAttribute(): ?string
    {
        return $this->pdf ? asset('governance-docs/'.$this->pdf) : null;
    }
}
