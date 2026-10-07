<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DisclosureTab extends Model
{
    protected $fillable = [
        'disclosure_row_id',
        'label',
        'content',
        'sort_order',
    ];

    public function tabItems(): HasMany
    {
        return $this->hasMany(DisclosureTabItem::class)->orderBy('sort_order')->orderBy('id');
    }
}
