<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisclosureLink extends Model
{
    protected $fillable = [
        'disclosure_row_id',
        'name',
        'label',
        'url',
        'file',
        'sort_order',
    ];

    /** Resolved href: uploaded PDF wins, else the pasted URL. */
    public function getHrefAttribute(): ?string
    {
        if ($this->file) {
            return asset(Disclosure::DIR.'/'.$this->file);
        }

        return $this->url ?: null;
    }
}
