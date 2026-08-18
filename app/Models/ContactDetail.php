<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactDetail extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'contact_details';

    protected $fillable = [
        'email_1',
        'email_2',
        'phone',
        'address',
        'map_url',
        'iframe_url',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
