<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CareerJob extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'career_jobs';

    protected $fillable = [
        'job_role',
        'slug',
        'description',
        'location',
        'employment_type',
        'experience',
        'qualification',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
