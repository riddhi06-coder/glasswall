<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Innovation extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'innovations';

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'heading',
        'image',
        'feature',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function assetUrl(?string $fileName): ?string
    {
        return $fileName ? asset('innovations/'.$fileName) : null;
    }
}
