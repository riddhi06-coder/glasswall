<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockExchangeItem extends Model
{
    protected $fillable = [
        'stock_exchange_tab_id',
        'number',
        'title',
        'url',
        'file',
        'sort_order',
    ];

    /** Resolved href: uploaded PDF wins, else the pasted URL. */
    public function getHrefAttribute(): ?string
    {
        if ($this->file) {
            return asset(StockExchange::DIR.'/'.$this->file);
        }

        return $this->url ?: null;
    }
}
