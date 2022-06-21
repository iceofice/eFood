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
        Permission::create(['name' => 'manage customers']);
        Permission::create(['name' => 'manage orders']);
        Permission::create(['name' => 'manage orders details']);
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
            'manage customers',
            'manage orders',
        ]);

        // Cashier
        $cashier = Role::create(['name' => 'Cashier']);

        // Kitchen Staff
        $kitchenStaff = Role::create(['name' => 'Kitchen Staff']);
        $kitchenStaff->givePermissionTo([
            'manage menus',
            'manage orders',
        ]);
        User::find(4)->assignRole($kitchenStaff);

        // Waiter
        $waiter = Role::create(['name' => 'Waiter']);
        User::find(2)->assignRole($waiter);
        User::find(3)->assignRole($waiter);
        $waiter->givePermissionTo([
            'manage customers',
            'manage orders',
            'manage orders details'
        ]);
    }
}
