<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached permissions before configuring roles.
        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        // 1. Create or find the Admin role.
        $role = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        // 2. Define application permissions.
        $permissionNames = [
            'view dashboard',
            'manage users',

            'view products',
            'create products',
            'edit products',
            'delete products',

            'create categories',

            'view suppliers',
            'create suppliers',
            'edit suppliers',
            'delete suppliers',

            'view stock',
            'stock in',
            'stock out',

            'view reports',
        ];

        // 3. Create missing permissions.
        foreach ($permissionNames as $permissionName) {
            Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);
        }

        // 4. Give Admin all permissions defined above.
        $permissions = Permission::whereIn(
            'name',
            $permissionNames
        )
            ->where('guard_name', 'web')
            ->get();

        $role->syncPermissions($permissions);

        // 5. Create or update the admin account.
        // Existing inactive admin will also become active.
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        // 6. Ensure the admin account has the Admin role.
        $admin->syncRoles([$role]);

        // 7. Clear permission cache after updates.
        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $this->command->info(
            'Admin account configured successfully.'
        );

        $this->command->info('Email: admin@gmail.com');
        $this->command->info('Password: password');
        $this->command->info('Account status: ACTIVE');
        $this->command->info(
            'Admin role and permissions assigned successfully.'
        );
    }
}
