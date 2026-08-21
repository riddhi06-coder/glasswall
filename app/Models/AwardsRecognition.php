<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AwardsRecognition extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'awards_recognitions';

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'awards_category_id',
        'title',
        'subject',
        'year',
        'thumbnail_image',
        'main_image',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(AwardsCategory::class, 'awards_category_id');
    }

    public function assetUrl(?string $fileName): ?string
    {
        return $fileName ? asset('awards-uploads/'.$fileName) : null;
    }
}
