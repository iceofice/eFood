<?php

namespace App\Http\Controllers;

use View;
use App\Models\Inventory;
use App\Datatables\InventoryDatatable;
use App\Http\Requests\CreateInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;

class InventoryController extends Controller
{
    /**
     * Share the model name and route with the view
     */
    public function __construct()
    {
        $modelName = 'Inventory Item';
        $route = 'inventories';
        View::share(compact('modelName', 'route'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = Inventory::all();
        $table = new InventoryDatatable($inventories);

        return view('crud.index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateInventoryRequest $request)
    {
        Inventory::create($request->validated());

        return redirect()->route('inventories.index')
            ->with('success_message', 'Inventory item added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        $id = $inventory->id;
        return view('inventories.edit', compact('id', 'inventory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInventoryRequest $request, Inventory $inventory)
    {
        $inventory->update($request->validated());
        return redirect()->route('inventories.index')
            ->with('success_message', 'Inventory item modified successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('inventories.index')
            ->with('success_message', 'Inventory item deleted successfully');
    }
}
