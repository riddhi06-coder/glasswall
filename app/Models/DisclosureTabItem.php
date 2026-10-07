<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisclosureTabItem extends Model
{
    protected $fillable = [
        'disclosure_tab_id',
        'title',
        'url',
        'file',
        'sort_order',
    ];

    /** Resolved href: uploaded file wins, else the pasted URL. */
    public function getHrefAttribute(): ?string
    {
        if ($this->file) {
            return asset(Disclosure::DIR.'/'.$this->file);
        }

        return $this->url ?: null;
    }
}
