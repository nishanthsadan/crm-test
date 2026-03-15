<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'Core', 'Auth', 'Dashboard', 'Leads', 'Contacts',
            'Accounts', 'Deals', 'Activities', 'Reports', 'Settings'
        ];

        foreach ($modules as $module) {
            DB::table('modules_status')->updateOrInsert(
                ['module_name' => $module],
                [
                    'is_enabled' => true,
                    'installed_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
