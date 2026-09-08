<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CareerApplication extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'job_role',
        'first_name',
        'last_name',
        'email',
        'contact_no',
        'message',
        'resume_path',
        'resume_name',
        'ip_address',
    ];

    public function getResumeUrlAttribute(): ?string
    {
        return $this->resume_path ? asset($this->resume_path) : null;
    }
}
