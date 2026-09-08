<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvestorResource extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $table = 'investor_resources';

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'name',
        'designation',
        'phone',
        'email',
        'company_name',
        'address',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function assetUrl(?string $fileName): ?string
    {
        return $fileName ? asset('investor-uploads/'.$fileName) : null;
    }
}
