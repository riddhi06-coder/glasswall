<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** Adds CRUD permissions for the SEO Manager module and grants them to Super Admin. */
return new class extends Migration
{
    private array $slugs = ['manage-seo.view', 'manage-seo.create', 'manage-seo.edit', 'manage-seo.delete'];

    public function up(): void
    {
        $now = now();
        foreach (['view', 'create', 'edit', 'delete'] as $action) {
            DB::table('permissions')->updateOrInsert(
                ['slug' => "manage-seo.$action"],
                ['name' => ucfirst($action).' SEO Manager', 'module' => 'SEO', 'deleted_at' => null, 'updated_at' => $now, 'created_at' => $now]
            );
        }

        $superadminId = DB::table('roles')->where('slug', 'superadmin')->value('id');
        if ($superadminId) {
            $ids = DB::table('permissions')->whereIn('slug', $this->slugs)->pluck('id');
            foreach ($ids as $id) {
                DB::table('permission_role')->updateOrInsert(['permission_id' => $id, 'role_id' => $superadminId]);
            }
        }
    }

    public function down(): void
    {
        $ids = DB::table('permissions')->whereIn('slug', $this->slugs)->pluck('id');
        DB::table('permission_role')->whereIn('permission_id', $ids)->delete();
        DB::table('permissions')->whereIn('id', $ids)->delete();
    }
};
