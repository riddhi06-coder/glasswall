<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DisclosureRow extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'number',
        'title',
        'type',
        'year',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function links(): HasMany
    {
        return $this->hasMany(DisclosureLink::class)->orderBy('sort_order')->orderBy('id');
    }

    public function tabs(): HasMany
    {
        return $this->hasMany(DisclosureTab::class)->orderBy('sort_order')->orderBy('id');
    }
}
