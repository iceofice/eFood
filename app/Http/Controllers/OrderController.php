<?php

namespace App\Http\Controllers;

use Auth;
use View;
use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Order;
use App\Datatables\OrderDatatable;
use App\Datatables\MenuOrderDatatable;
use App\Http\Requests\CheckTimeRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\AddMenuToOrderRequest;
use App\Http\Requests\UpdateMenuToOrderRequest;

class OrderController extends Controller
{
    /**
     * Share the model name and route with the view
     */
    public function __construct()
    {
        $modelName = 'Order';
        $route = 'orders';

        View::share(compact('modelName', 'route'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['customer', 'table'])
            ->when(Auth::user()->hasRole('Waiter'), function ($query) {
                return $query->where('user_id', Auth::user()->id)->orWhereNull('user_id');
            })
            ->when(Auth::user()->hasRole('Kitchen Staff'), function ($query) {
                return $query->where('status', '<>', 5);
            })
            ->get();
        $userNotifications = Auth::user()->unreadNotifications->pluck('data.message', 'data.orderID');
        $table = new OrderDatatable($orders, $userNotifications);

        return view('crud.index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Order::class);
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request)
    {
        $this->authorize('create', Order::class);
        $order = Order::create($request->validated());

        return redirect()->route('orders.edit', $order)
            ->with('success_message', 'Order added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $this->authorize('handle', $order);
        $userNotifications = Auth::user()->unreadNotifications->where('data.orderID', $order->id)->first();

        if ($userNotifications) {
            $userNotifications->markAsRead();
        }

        $id = $order->id;

        $order->load('menus');
        $orderMenus = $order->menus;

        $menus = Menu::whereDoesntHave('orders', function ($query) use ($id) {
            $query->where('id', $id);
        })->pluck('name', 'id')->toArray();

        $table = new MenuOrderDatatable($orderMenus);
        return view('orders.edit', compact('order', 'id', 'table', 'menus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateOrderRequest  $request
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $this->authorize('handle', $order);

        $validatedRequest = $request->validated();

        if (isset($validatedRequest['password'])) {
            $validatedRequest['password'] = bcrypt($validatedRequest['password']);
        }

        $order->update($validatedRequest);

        $userNotifications = Auth::user()->unreadNotifications->where('data.orderID', $order->id)->first();

        if ($userNotifications) {
            $userNotifications->markAsRead();
        }

        return redirect()->route('orders.index')
            ->with('success_message', 'Order modified successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $this->authorize('handle', $order);

        // Remove all the menus from the order before deleting
        $order->menus()->detach();

        $order->delete();
        return redirect()->route('orders.index')
            ->with('success_message', 'Order deleted successfully');
    }

    /**
     * Add a menu to the order
     *
     * @param AddMenuToOrderRequest $request
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function addMenu(AddMenuToOrderRequest $request, Order $order)
    {
        $this->authorize('create', Order::class);
        $this->authorize('handle', $order);

        $menuPrice = Menu::find($request->menu_id, ['price'])->price;
        $order->menus()->attach($request->menu_id, ['qty' => $request->qty, 'price' => $menuPrice]);

        return redirect()->route('orders.edit', $order)
            ->with('success_message', 'New item added to the order successfully');
    }

    /**
     * Update a menu in the order
     *
     * @param UpdateMenuToOrderRequest $request
     * @param Order $order
     * @param integer $menuId
     * @return \Illuminate\Http\Response
     */
    public function updateMenu(UpdateMenuToOrderRequest $request, Order $order, int $menuId)
    {
        $this->authorize('create', Order::class);
        $this->authorize('handle', $order);

        $order->menus()->updateExistingPivot($menuId, ['qty' => $request->qty]);

        return redirect()->route('orders.edit', $order)
            ->with('success_message', 'Item updated successfully');
    }

    /**
     * Remove a menu from the order
     *
     * @param Order $order
     * @param integer $menuId
     * @return \Illuminate\Http\Response
     */
    public function removeMenu(Order $order, int $menuId)
    {
        $this->authorize('create', Order::class);
        $this->authorize('handle', $order);

        $order->menus()->detach($menuId);

        return redirect()->route('orders.edit', $order)
            ->with('success_message', 'Item removed from the order successfully');
    }

    /**
     * Check if the order is open
     *
     * @param CheckTimeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function checkTime(CheckTimeRequest $request)
    {
        $orders = Order::where([
            ['table_id', $request->table],
            ['status', '<>', 5],
        ])->when($request->id, function ($query) use ($request) {
            return $query->where('id', '<>', $request->id);
        })
            ->whereDate('reserved_at', Carbon::parse($request->time))
            ->get();

        //TODO: Option page to set operating hours
        for ($i = 9; $i <= 23; $i++) {
            $times[$i . ':00'] = $i . ':00';
            $times[$i . ':30'] = $i . ':30';
        }

        foreach ($orders as $order) {
            unset($times[Carbon::parse($order->reserved_at)->subHour()->format('G:i')]);
            unset($times[Carbon::parse($order->reserved_at)->subMinutes(30)->format('G:i')]);
            unset($times[Carbon::parse($order->reserved_at)->format('G:i')]);
            unset($times[Carbon::parse($order->reserved_at)->addMinutes(30)->format('G:i')]);
            unset($times[Carbon::parse($order->reserved_at)->addHour()->format('G:i')]);
        }

        return $times;
    }
}
