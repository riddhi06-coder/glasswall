<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeAbout extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'home_abouts';

    protected $fillable = [
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function milestones(): HasMany
    {
        return $this->hasMany(HomeAboutMilestone::class)->orderBy('sort_order')->orderBy('id');
    }
}
