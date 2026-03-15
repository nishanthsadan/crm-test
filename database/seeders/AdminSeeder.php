<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $managerRole = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Create permissions
        $permissions = [
            'view leads', 'create leads', 'edit leads', 'delete leads',
            'view contacts', 'create contacts', 'edit contacts', 'delete contacts',
            'view accounts', 'create accounts', 'edit accounts', 'delete accounts',
            'view deals', 'create deals', 'edit deals', 'delete deals',
            'view activities', 'create activities', 'edit activities', 'delete activities',
            'view reports', 'export reports',
            'manage settings', 'manage users', 'manage modules',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign all permissions to admin
        $adminRole->syncPermissions(Permission::all());

        // Manager permissions
        $managerPermissions = Permission::whereNotIn('name', ['manage settings', 'manage users', 'manage modules'])->get();
        $managerRole->syncPermissions($managerPermissions);

        // User permissions
        $userRole->syncPermissions([
            'view leads', 'create leads', 'edit leads',
            'view contacts', 'create contacts', 'edit contacts',
            'view accounts', 'view deals', 'create deals', 'edit deals',
            'view activities', 'create activities', 'edit activities',
        ]);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@crm.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );
        $admin->assignRole($adminRole);

        // Create manager user
        $manager = User::firstOrCreate(
            ['email' => 'manager@crm.com'],
            [
                'name' => 'Manager User',
                'password' => bcrypt('password'),
                'role' => 'manager',
                'status' => 'active',
            ]
        );
        $manager->assignRole($managerRole);

        // Create regular user
        $user = User::firstOrCreate(
            ['email' => 'user@crm.com'],
            [
                'name' => 'Regular User',
                'password' => bcrypt('password'),
                'role' => 'user',
                'status' => 'active',
            ]
        );
        $user->assignRole($userRole);

        $this->command->info('Admin seeder completed!');
        $this->command->info('Admin: admin@crm.com / password');
        $this->command->info('Manager: manager@crm.com / password');
        $this->command->info('User: user@crm.com / password');
    }
}
