<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // สร้าง roles ตามรูปที่ให้มา
        $roles = [
            'admin',
            'head_engineering',
            'assistant',
            'site_engineer',
            'supervisor',
            'foreman',
            'skill',
            'inspector',
            'head_operation',
            'store_keeper',
            'head_store_keeper',
            'immm',
            'viewer',
            'head_section',
            'head_department'
        ];

        // สร้าง roles
        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
                'guard_name' => 'web'
            ]);
        }
    }
}
