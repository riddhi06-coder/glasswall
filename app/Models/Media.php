<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'media';

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'video',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function assetUrl(?string $fileName): ?string
    {
        return $fileName ? asset('media-uploads/'.$fileName) : null;
    }
}
