<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactDetail extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'contact_details';

    protected $fillable = [
        'banner_heading',
        'banner_image',
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

    public function socialLinks(): HasMany
    {
        return $this->hasMany(ContactSocialLink::class, 'contact_detail_id')->orderBy('sort_order')->orderBy('id');
    }

    public function getBannerImageUrlAttribute(): ?string
    {
        return $this->banner_image ? asset('contact/'.$this->banner_image) : null;
    }
}
