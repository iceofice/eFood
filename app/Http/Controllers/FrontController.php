<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Table;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Support\Arr;
use App\Http\Requests\ReserveRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AddCustomerRequest;
use App\Http\Requests\CheckTableRequest;
use App\Http\Requests\RegisterCustomerRequest;
use Illuminate\Http\Request;

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

        $customerID = $customer->id;
        return view('order', compact('customerID'));
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
        $order = Order::create($request->validated());
        $customer = $order->customer->name;

        return view('thankyou', compact('customer', 'order'));
    }

    //TODO:DOCS
    public function profile()
    {
        $orders = Order::with('menus')
            ->where('customer_id', Auth::user()->id)
            ->orderBy('reserved_at', 'desc')
            ->get();
        return view('profile', compact('orders'));
    }

    //TODO:DOCS
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('front');
    }

    //TODO:DOCS
    public function register(RegisterCustomerRequest $request)
    {
        $validatedRequest = $request->validated();
        $validatedRequest['password'] = bcrypt($validatedRequest['password']);

        if (isset($request->validated()['email'])) {
            $customer = Customer::where('email', $request->validated()['email'])->first();
        } else {
            $customer = Customer::where('phone', $request->validated()['phone'])->first();
        }

        if (is_null($customer)) {
            Customer::create($validatedRequest);
        } else if ($customer->password) {
            return redirect(route('front') . '/#profile-section')
                ->with('error_message', 'You are already registered!');
        } else {
            $customer->update($validatedRequest);
        }

        return redirect(route('front') . '/#profile-section')
            ->with('success_message', 'You are registered successfully');
    }

    //TODO:DOCS
    public function book()
    {
        $customerID = Auth()->guard('customer')->user()->id;
        return view('order', compact('customerID'));
    }

    //TODO:DOCS
    public function order(Request $request)
    {
        $menus = Menu::with('categories')->get()->groupBy('categories.*.slug')->all();
        $uncategorized = Menu::doesntHave('categories')->get();
        $categories = Category::all()->pluck('name', 'slug');

        if (!$uncategorized->isEmpty()) {
            $menus['uncategorized'] = $uncategorized;
            $categories['uncategorized'] = 'Others';
        }

        foreach ($menus as $key => $menu) {
            $menus[$key] = array_chunk($menu->all(), ceil(count($menu) / 2));
        }

        $order = Order::find(request()->orderID);
        $items = $order->menus;

        return view('front.order', compact('menus', 'categories', 'order', 'items'));
    }

    //TODO: DOCS
    public function addOrderItem()
    {
        $order = Order::find(request()->orderID);
        $menu = Menu::find(request()->menuID);

        $order->menus()->syncWithoutDetaching([request()->menuID => ['qty' => request()->qty, 'price' => $menu->price, 'note' => request()->note]]);

        return response()->json(['success' => true]);
    }

    //TODO: DOCS
    public function removeOrderItem()
    {
        $order = Order::find(request()->orderID);
        $menu = Menu::find(request()->menuID);
        $order->menus()->detach($menu);
        return response()->json(['success' => true]);
    }

    public function finishOrder()
    {
        $order = Order::find(request()->orderID);
        $customer = $order->customer->name;

        return view('thankyou', compact('customer', 'order'));
    }
}
