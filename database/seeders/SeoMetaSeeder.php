<?php

namespace Database\Seeders;

use App\Models\SeoMeta;
use Illuminate\Database\Seeder;

class SeoMetaSeeder extends Seeder
{
    public function run(): void
    {
        $csv = database_path('seeders/data/seo_metas.csv');
        if (! is_file($csv)) {
            $this->command?->warn("SEO CSV not found at {$csv} — skipping.");
            return;
        }

        $rows   = array_map('str_getcsv', file($csv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
        $header = array_map('trim', array_shift($rows));
        $count  = 0;

        foreach ($rows as $row) {
            $data = array_combine($header, array_pad($row, count($header), ''));
            $path = SeoMeta::normalizePath($data['url_path'] ?? '');
            if ($path === '' || ($data['meta_title'] ?? '') === '') {
                continue;
            }

            // Preserve any admin-entered OG/Twitter/hreflang; only (re)seed name/title/description/canonical.
            SeoMeta::updateOrCreate(
                ['url_path' => $path],
                [
                    'page_name'        => SeoMeta::deriveName($path),
                    'meta_title'       => $data['meta_title'] ?? null,
                    'meta_description' => $data['meta_description'] ?? null,
                    // Canonical is NOT in the sheet — leave blank; the <head> falls back to the page's own URL.
                    'is_active'        => true,
                ]
            );
            $count++;
        }

        $this->command?->info("Seeded/updated {$count} SEO meta rows.");
    }
}
