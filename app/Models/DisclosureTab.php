<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisclosureTab extends Model
{
    protected $fillable = [
        'disclosure_row_id',
        'label',
        'content',
        'sort_order',
    ];
}
