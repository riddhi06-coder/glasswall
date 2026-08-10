<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // ---------- Permissions (system / user-management only) ----------
            $permissionData = [
                // Dashboard
                ['name' => 'View Dashboard',     'slug' => 'dashboard.view',     'module' => 'Dashboard'],
                // Roles
                ['name' => 'View Roles',         'slug' => 'roles.view',         'module' => 'User'],
                ['name' => 'Create Roles',       'slug' => 'roles.create',       'module' => 'User'],
                ['name' => 'Edit Roles',         'slug' => 'roles.edit',         'module' => 'User'],
                ['name' => 'Delete Roles',       'slug' => 'roles.delete',       'module' => 'User'],
                // Users
                ['name' => 'View Users',         'slug' => 'users.view',         'module' => 'User'],
                ['name' => 'Create Users',       'slug' => 'users.create',       'module' => 'User'],
                ['name' => 'Edit Users',         'slug' => 'users.edit',         'module' => 'User'],
                ['name' => 'Delete Users',       'slug' => 'users.delete',       'module' => 'User'],
                // Permissions
                ['name' => 'View Permissions',   'slug' => 'permissions.view',   'module' => 'User'],
                ['name' => 'Assign Permissions', 'slug' => 'permissions.assign', 'module' => 'User'],
            ];

            foreach ($permissionData as $perm) {
                Permission::updateOrCreate(['slug' => $perm['slug']], $perm);
            }

            // ---------- Roles ----------
            $superadmin = Role::updateOrCreate(
                ['slug' => Role::SUPERADMIN_SLUG],
                ['name' => 'Super Admin', 'description' => 'Full access to everything', 'is_protected' => true, 'is_active' => true]
            );

            $admin = Role::updateOrCreate(
                ['slug' => 'admin'],
                ['name' => 'Admin', 'description' => 'Administrative access', 'is_protected' => false, 'is_active' => true]
            );

            $user = Role::updateOrCreate(
                ['slug' => 'user'],
                ['name' => 'User', 'description' => 'Standard user', 'is_protected' => false, 'is_active' => true]
            );

            // Super Admin -> all permissions (also implicit via hasPermission(); stored for transparency).
            $superadmin->permissions()->sync(Permission::pluck('id'));

            // Admin -> read access by default; adjustable in the Permissions UI.
            $admin->permissions()->sync(Permission::whereIn('slug', [
                'dashboard.view',
                'roles.view',
                'users.view',
                'users.create', 'users.edit',
                'permissions.view',
            ])->pluck('id'));

            // Standard user -> dashboard only.
            $user->permissions()->sync(Permission::whereIn('slug', ['dashboard.view'])->pluck('id'));

            // ---------- Elevate the first existing user to Super Admin ----------
            $firstUser = User::orderBy('id')->first();
            if ($firstUser && ! $firstUser->role_id) {
                $firstUser->role_id = $superadmin->id;
                $firstUser->save();
            }
        });
    }
}
