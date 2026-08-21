<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardDirector extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'board_directors';

    protected $fillable = [
        'banner_image',
        'banner_heading',
        'banner_description',
        'name',
        'designation',
        'image',
        'info',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function assetUrl(?string $fileName): ?string
    {
        return $fileName ? asset('board/'.$fileName) : null;
    }
}
