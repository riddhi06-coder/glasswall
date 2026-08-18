<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactSocialLink extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'contact_social_links';

    /** Supported platforms → label + Font Awesome icon class. */
    public const PLATFORMS = [
        'facebook'  => ['label' => 'Facebook',      'icon' => 'fab fa-facebook-f'],
        'instagram' => ['label' => 'Instagram',     'icon' => 'fab fa-instagram'],
        'linkedin'  => ['label' => 'LinkedIn',      'icon' => 'fab fa-linkedin-in'],
        'twitter'   => ['label' => 'Twitter / X',   'icon' => 'fab fa-x-twitter'],
        'youtube'   => ['label' => 'YouTube',       'icon' => 'fab fa-youtube'],
        'whatsapp'  => ['label' => 'WhatsApp',      'icon' => 'fab fa-whatsapp'],
        'pinterest' => ['label' => 'Pinterest',     'icon' => 'fab fa-pinterest-p'],
        'telegram'  => ['label' => 'Telegram',      'icon' => 'fab fa-telegram-plane'],
    ];

    protected $fillable = [
        'contact_detail_id',
        'platform',
        'url',
        'sort_order',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function contactDetail(): BelongsTo
    {
        return $this->belongsTo(ContactDetail::class, 'contact_detail_id');
    }

    public function getIconClassAttribute(): string
    {
        return self::PLATFORMS[$this->platform]['icon'] ?? 'fas fa-link';
    }

    public function getPlatformLabelAttribute(): string
    {
        return self::PLATFORMS[$this->platform]['label'] ?? ucfirst($this->platform);
    }
}
