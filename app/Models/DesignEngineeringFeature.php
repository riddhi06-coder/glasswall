<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DesignEngineeringFeature extends Model
{
    protected $table = 'design_engineering_features';

    protected $fillable = [
        'design_engineering_id',
        'feature',
        'description',
        'sort_order',
    ];

    public function designEngineering(): BelongsTo
    {
        return $this->belongsTo(DesignEngineering::class, 'design_engineering_id');
    }
}
