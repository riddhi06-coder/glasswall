<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'product_categories';

    protected $fillable = [
        'name',
        'slug',
        'image',
        'short_description',
        'is_active',
        'priority',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'priority'  => 'integer',
    ];

    public function productListings(): HasMany
    {
        return $this->hasMany(ProductListing::class, 'product_category_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('product-categories/'.$this->image) : null;
    }
}
