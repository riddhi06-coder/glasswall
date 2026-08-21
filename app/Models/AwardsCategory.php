<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AwardsCategory extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'awards_categories';

    protected $fillable = [
        'name',
        'slug',
        'image',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('awards-categories/'.$this->image) : null;
    }
}
