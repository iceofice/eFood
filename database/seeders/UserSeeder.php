<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'prasetiorenaldy@gmail.com',
            'password' => bcrypt('123'),
        ]);

        User::create([
            'name' => 'Waiter 1',
            'email' => 'w1@gmail.com',
            'password' => bcrypt('123'),
        ]);

        User::create([
            'name' => 'Waiter 2',
            'email' => 'w2@gmail.com',
            'password' => bcrypt('123'),
        ]);
    }
}
