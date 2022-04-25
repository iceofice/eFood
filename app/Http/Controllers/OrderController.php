<?php

namespace App\Http\Controllers;

use View;
use App\Models\Menu;
use App\Models\Order;
use App\Datatables\OrderDatatable;
use App\Datatables\MenuOrderDatatable;
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
        $orders = Order::with('customer')->get();
        $table = new OrderDatatable($orders);

        return view('crud.index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $validatedRequest = $request->validated();

        if (isset($validatedRequest['password'])) {
            $validatedRequest['password'] = bcrypt($validatedRequest['password']);
        }

        $order->update($validatedRequest);
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
        $order->menus()->detach($menuId);

        return redirect()->route('orders.edit', $order)
            ->with('success_message', 'Item removed from the order successfully');
    }
}
