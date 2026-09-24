<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DesignEngineeringImage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'design_engineering_id',
        'image',
        'sort_order',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('design-engg/'.$this->image) : null;
    }
}
