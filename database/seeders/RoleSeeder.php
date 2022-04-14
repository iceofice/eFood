<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermissions();
        $this->createRoles();
    }

    private function createPermissions()
    {
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage menus']);
        Permission::create(['name' => 'update menus']);
    }

    private function createRoles()
    {
        // Super Admin
        $superAdmin = Role::create(['name' => 'Super Admin']);
        User::find(1)->assignRole($superAdmin);

        // Admin
        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo([
            'manage users',
            'manage menus',
            'update menus',
        ]);

        // Cashier
        $cashier = Role::create(['name' => 'Cashier']);

        // Kitchen Staff
        $kitchenStaff = Role::create(['name' => 'Kitchen Staff']);
        $kitchenStaff->givePermissionTo([
            'manage menus',
        ]);

        // Waiter
        $waiter = Role::create(['name' => 'Waiter']);
    }
}
