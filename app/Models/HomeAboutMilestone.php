<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeAboutMilestone extends Model
{
    protected $table = 'home_about_milestones';

    protected $fillable = [
        'home_about_id',
        'icon',
        'count',
        'milestone',
        'sort_order',
    ];

    public function about(): BelongsTo
    {
        return $this->belongsTo(HomeAbout::class, 'home_about_id');
    }

    /** Public URL for the stored icon file. */
    public function getIconUrlAttribute(): ?string
    {
        return $this->icon ? asset('home/aboutmilestones/'.$this->icon) : null;
    }
}
