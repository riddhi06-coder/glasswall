<?php

use App\Models\DisclosureRow;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        foreach (DisclosureRow::withTrashed()->orderBy('id')->get() as $r) {
            if ($r->slug) { continue; }
            $base = Str::slug(strip_tags((string) $r->title)) ?: ('item-'.$r->id);
            $slug = $base; $i = 2;
            while (DisclosureRow::where('slug', $slug)->where('id', '!=', $r->id)->exists()) {
                $slug = $base.'-'.($i++);
            }
            $r->slug = $slug;
            $r->saveQuietly();
        }
    }

    public function down(): void
    {
        // no-op
    }
};
