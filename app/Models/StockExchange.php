<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockExchange extends Model
{
    use SoftDeletes, TracksDeletedBy;

    /** Upload directory under /public. */
    public const DIR = 'stock-exchange-uploads';

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'page_heading',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function assetUrl(?string $fileName): ?string
    {
        return $fileName ? asset(self::DIR.'/'.$fileName) : null;
    }

    public function getBannerImageUrlAttribute(): ?string
    {
        return $this->assetUrl($this->banner_image);
    }
}
