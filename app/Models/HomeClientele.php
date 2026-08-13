<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeClientele extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'home_clienteles';

    protected $fillable = [
        'product_section_heading',
        'work_section_heading',
        'project_section_heading',
        'clientele_section_heading',
        'clientele_section_desc',
        'collaboration_section_heading',
        'collaboration_section_title',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(HomeClienteleImage::class)->orderBy('sort_order')->orderBy('id');
    }
}
