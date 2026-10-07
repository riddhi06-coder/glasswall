<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $map = [
        'manage-stock-exchange'      => ['Stock Exchange Page', ['view', 'edit']],
        'manage-stock-exchange-tabs' => ['Stock Exchange Tabs', ['view', 'create', 'edit', 'delete']],
    ];

    public function up(): void
    {
        $now = now();
        $slugs = [];
        foreach ($this->map as $prefix => [$label, $actions]) {
            foreach ($actions as $action) {
                DB::table('permissions')->updateOrInsert(
                    ['slug' => "$prefix.$action"],
                    ['name' => ucfirst($action).' '.$label, 'module' => 'Stock Exchange', 'deleted_at' => null, 'updated_at' => $now, 'created_at' => $now]
                );
                $slugs[] = "$prefix.$action";
            }
        }
        $superadminId = DB::table('roles')->where('slug', 'superadmin')->value('id');
        if ($superadminId) {
            foreach (DB::table('permissions')->whereIn('slug', $slugs)->pluck('id') as $id) {
                DB::table('permission_role')->updateOrInsert(['permission_id' => $id, 'role_id' => $superadminId]);
            }
        }
    }

    public function down(): void
    {
        $slugs = ['manage-stock-exchange.view','manage-stock-exchange.edit','manage-stock-exchange-tabs.view','manage-stock-exchange-tabs.create','manage-stock-exchange-tabs.edit','manage-stock-exchange-tabs.delete'];
        $ids = DB::table('permissions')->whereIn('slug', $slugs)->pluck('id');
        DB::table('permission_role')->whereIn('permission_id', $ids)->delete();
        DB::table('permissions')->whereIn('id', $ids)->delete();
    }
};
