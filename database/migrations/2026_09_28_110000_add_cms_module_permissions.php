<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Adds a permission for every CMS section in the admin sidebar, so they can be
 * assigned per role. Slug prefix = the section's resource route name
 * (e.g. "banner-details.view"), grouped into cards by sidebar section (module).
 */
return new class extends Migration
{
    private const CRUD = ['view', 'create', 'edit', 'delete'];

    /** module => [slug prefix => [label, actions]] — in sidebar order. */
    private function catalog(): array
    {
        return [
            'Home' => [
                'banner-details'      => ['Banner Details', self::CRUD],
                'home-about-details'  => ['About Details', self::CRUD],
                'home-clientele'      => ['Clientele', self::CRUD],
                'home-blog-details'   => ['Blog Section Details', self::CRUD],
            ],
            'Overview' => [
                'manage-about-us'           => ['About Us', self::CRUD],
                'manage-board-of-directors' => ['Board of Directors', self::CRUD],
                'manage-innovation'         => ['Innovation', self::CRUD],
                'manage-esg'                => ['ESG', self::CRUD],
                'manage-media'              => ['Media', self::CRUD],
                'manage-awards-category'    => ['Awards Category', self::CRUD],
                'manage-awards-recognition' => ['Awards Listing', self::CRUD],
            ],
            'Products' => [
                'manage-product-category' => ['Product Category', self::CRUD],
                'manage-product-list'     => ['Product Listing', self::CRUD],
            ],
            'Projects' => [
                'manage-project-category' => ['Project Category', self::CRUD],
                'manage-project-listing'  => ['Project Listing', self::CRUD],
                'manage-project-details'  => ['Project Details', self::CRUD],
            ],
            'Infrastructure' => [
                'manage-design-engg'        => ['Design and Engineering', self::CRUD],
                'manage-facility'           => ['Facility', self::CRUD],
                'manage-project-management' => ['Project Management', self::CRUD],
            ],
            'Investors Relations' => [
                'manage-ipo'                  => ['IPO Documents', self::CRUD],
                'manage-ipo-drhp'             => ['DRHP Disclaimer', self::CRUD],
                'manage-corporate-governance' => ['Corporate Governance', self::CRUD],
                'manage-annual-report'        => ['Annual Reports', self::CRUD],
                'manage-investor-resource'    => ['Investor Resources', self::CRUD],
            ],
            'Careers' => [
                'manage-careers-details' => ['Careers Page Details', self::CRUD],
                'manage-jobs'            => ['Job Posting', self::CRUD],
            ],
            'Contact Details' => [
                'manage-contact-details' => ['Contact Details', self::CRUD],
            ],
            'Enquiries' => [
                'manage-contact-enquiries'   => ['Contact Enquiries', ['view', 'delete']],
                'manage-career-applications' => ['Career Applications', ['view', 'delete']],
            ],
            'Legal Pages' => [
                'manage-legal-pages' => ['Legal Pages', ['view', 'edit']],
            ],
        ];
    }

    private function slugs(): array
    {
        $slugs = [];
        foreach ($this->catalog() as $sections) {
            foreach ($sections as $prefix => [, $actions]) {
                foreach ($actions as $action) {
                    $slugs[] = "$prefix.$action";
                }
            }
        }

        return $slugs;
    }

    public function up(): void
    {
        $now = now();

        foreach ($this->catalog() as $module => $sections) {
            foreach ($sections as $prefix => [$label, $actions]) {
                foreach ($actions as $action) {
                    DB::table('permissions')->updateOrInsert(
                        ['slug' => "$prefix.$action"],
                        ['name' => ucfirst($action).' '.$label, 'module' => $module, 'deleted_at' => null, 'updated_at' => $now, 'created_at' => $now]
                    );
                }
            }
        }

        // Super Admin has every permission implicitly; also store them for transparency (as the seeder does).
        $superadminId = DB::table('roles')->where('slug', 'superadmin')->value('id');
        if ($superadminId) {
            $ids = DB::table('permissions')->whereIn('slug', $this->slugs())->pluck('id');
            foreach ($ids as $id) {
                DB::table('permission_role')->updateOrInsert(['permission_id' => $id, 'role_id' => $superadminId]);
            }
        }
    }

    public function down(): void
    {
        $ids = DB::table('permissions')->whereIn('slug', $this->slugs())->pluck('id');
        DB::table('permission_role')->whereIn('permission_id', $ids)->delete();
        DB::table('permissions')->whereIn('id', $ids)->delete();
    }
};
