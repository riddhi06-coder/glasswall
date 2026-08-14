<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeBlog extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'home_blogs';

    protected $fillable = [
        'section_heading',
        'api_link',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
