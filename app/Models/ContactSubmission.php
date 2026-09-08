<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactSubmission extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'company',
        'phone',
        'message',
        'ip_address',
    ];
}
