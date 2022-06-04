<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Table;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Requests\ReserveRequest;
use App\Http\Requests\AddCustomerRequest;

class FrontController extends Controller
{
    public function index()
    {
        $menus = Menu::with('categories')->get()->groupBy('categories.*.slug')->all();
        $uncategorized = Menu::doesntHave('categories')->get();
        $categories = Category::all()->pluck('name', 'slug');
        $featured = Menu::where('featured', 1)->get()->take(3);

        if (!$uncategorized->isEmpty()) {
            $menus['uncategorized'] = $uncategorized;
            $categories['uncategorized'] = 'Others';
        }

        foreach ($menus as $key => $menu) {
            $menus[$key] = array_chunk($menu->all(), ceil(count($menu) / 2));
        }

        return view('index', compact('menus', 'categories', 'featured'));
    }

    /**
     * Get or create a new customer
     * 
     * @param  AddCustomerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function findCustomer(AddCustomerRequest $request)
    {
        if (isset($request->validated()['email'])) {
            $customer = Customer::where('email', $request->validated()['email'])->first();
        } else {
            $customer = Customer::where('phone', $request->validated()['phone'])->first();
        }

        if (is_null($customer)) {
            $customer = Customer::create($request->validated());
        } else {
            $customer->update([
                'name' => $request->validated()['name'],
            ]);
        }
        return view('order', compact('customer'));
    }


    /**
     * Check what time is available for the order
     *
     * @param CheckTableRequest $request
     * @return \Illuminate\Http\Response
     */
    public function checkTable(CheckTableRequest $request)
    {
        $availableTable = Table::where([
            ['min', '<=', $request->pax],
            ['max', '>=', $request->pax],
        ])->pluck('id');

        if ($availableTable->isEmpty()) {
            return response()->json(['error' => true, 'message' => 'No available tables for the number of people']);
        }

        $orders = Order::whereIn('table_id', $availableTable)
            ->where('status', '<>', 5,)
            ->whereDate('reserved_at', $request->time)
            ->get(['reserved_at', 'table_id'])
            ->groupBy('table_id')
            ->toArray();

        for ($i = 9; $i <= 23; $i++) {
            $times[$i . ':00'] = [];
            $times[$i . ':30'] = [];
        }

        foreach ($orders as $table_id => $order) {
            foreach ($order as $record) {
                $recordTime = Carbon::parse($record['reserved_at']);
                $times[$recordTime->copy()->subHour()->format('G:i')][] = $table_id;
                $times[$recordTime->copy()->subMinutes(30)->format('G:i')][] = $table_id;
                $times[$recordTime->copy()->format('G:i')][] = $table_id;
                $times[$recordTime->copy()->addMinutes(30)->format('G:i')][] = $table_id;
                $times[$recordTime->copy()->addHour()->format('G:i')][] = $table_id;
            }
            $orders[$table_id] = $order;
        }

        $times = Arr::where($times, function ($value, $key) use ($availableTable) {
            return count($value) < count($availableTable);
        });

        $times = array_map(function ($value) use ($availableTable) {
            return array_diff($availableTable->toArray(), $value);
        }, $times);

        if (count($times) == 0) {
            return response()->json(['error' => true, 'message' => "No available tables for the time"]);
        }
        return response()->json(['error' => false, 'data' => $times]);
    }

    /**
     * Create a new order for the customer
     *
     * @param ReserveRequest $request
     * @return \Illuminate\Http\Response
     */
    public function reserve(ReserveRequest $request)
    {
        Order::create($request->validated());
        return view('thankyou');
    }
}
