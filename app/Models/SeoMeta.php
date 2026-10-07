<?php

namespace App\Models;

use App\Models\Concerns\TracksDeletedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeoMeta extends Model
{
    use SoftDeletes, TracksDeletedBy;

    protected $fillable = [
        'url_path',
        'page_name',
        'meta_title',
        'meta_description',
        'canonical',
        'hreflang',
        'og_tag',
        'twitter_card_tag',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /** Store url_path normalized, and auto-derive the admin-facing page name from it. */
    public function setUrlPathAttribute($value): void
    {
        $path = static::normalizePath($value);
        $this->attributes['url_path']  = $path;
        $this->attributes['page_name'] = static::deriveName($path);
    }

    /** Friendly page name from the slug: "/" => Home, "/about-us" => "About Us". */
    public static function deriveName(?string $path): string
    {
        $path = static::normalizePath($path);
        if ($path === '/') {
            return 'Home';
        }

        $segment = substr($path, (int) strrpos($path, '/') + 1);
        $name    = ucwords(trim(str_replace('-', ' ', $segment)));

        return $name !== '' ? $name : $path;
    }

    /** Turn any URL or path into a canonical lookup key. */
    public static function normalizePath(?string $url): string
    {
        $url  = trim((string) $url);
        $path = preg_replace('#^https?://[^/]+#i', '', $url);       // drop scheme + host
        $path = parse_url($path, PHP_URL_PATH) ?? $path;            // drop any query/fragment
        $path = '/'.ltrim((string) $path, '/');
        $path = rtrim($path, '/');

        return $path === '' ? '/' : $path;
    }

    /** The active SEO row for a given request path (or null). */
    public static function forPath(?string $path): ?self
    {
        return static::where('is_active', true)
            ->where('url_path', static::normalizePath($path))
            ->first();
    }
}
