<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Table;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = Table::create([
            'name'  => 'A1',
            'min'   => 5,
            'max'   => 8
        ]);

        $customer = Customer::create([
            'name'  => 'Johny',
            'email' => 'john@gmail.com'
        ]);

        $menu = Menu::create([
            'name' => 'Fried Chicken',
            'slug' => 'fried-chicken',
            'price' => 5,
            'description' => 'Chicken fried with special sauce',
            'is_active' => 1
        ]);

        $order = Order::create([
            'customer_id' => $customer->id,
            'table_id'      => $table->id,
            'reserved_at'   => Carbon::now(),
            'status'        => 0,
            'user_id'       => 2
        ]);

        $order->menus()->attach($menu->id, ['qty' => 10, 'price' => $menu->price]);
    }
}
