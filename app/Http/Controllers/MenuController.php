<?php

namespace App\Http\Controllers;

use View;
use Request;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Inventory;
use App\Services\ImageService;
use App\Datatables\MenuDatatable;
use App\Http\Requests\CheckSlugRequest;
use App\Http\Requests\CreateMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Datatables\InventoryMenuDatatable;
use App\Http\Requests\AddInventoryToMenuRequest;
use App\Http\Requests\UpdateInventoryToMenuRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;

class MenuController extends Controller
{
    /**
     * Share the model name and route with the view
     */
    public function __construct()
    {
        $modelName = 'Menu';
        $route = 'menus';

        $categories = Category::pluck('name', 'id')->toArray();
        View::share(compact('modelName', 'route', 'categories'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::with('categories')->get();
        $table = new MenuDatatable($menus);

        return view('crud.index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inventories = Inventory::pluck('name', 'id')->toArray();
        return view('menus.create', compact('inventories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMenuRequest $request)
    {
        $validatedRequest = $request->validated();
        if ($request->image) {
            $validatedRequest['image'] = (new ImageService())->prepareImage($request->image);
        }

        $menu = Menu::create($validatedRequest);
        $menu->categories()->sync($request->categories);

        return redirect()->route('menus.edit', $menu)
            ->with('success_message', 'Menu added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $id = $menu->id;

        $inventories = Inventory::whereDoesntHave('menus', function ($query) use ($id) {
            $query->where('id', $id);
        })->pluck('name', 'id')->toArray();

        $menu->load('inventories');
        $menuInventories = $menu->inventories;

        $table = new InventoryMenuDatatable($menuInventories);

        return view('menus.edit', compact('menu', 'id', 'table', 'inventories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateMenuRequest  $request
     * @param  Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $validatedRequest = $request->validated();
        if ($request->image) {
            $validatedRequest['image'] = (new ImageService())->prepareImage($request->image);
        }

        $menu->update($validatedRequest);
        $menu->categories()->sync($request->categories);
        $menu->inventories()->sync($request->inventories);


        return redirect()->route('menus.index')
            ->with('success_message', 'Menu modified successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        // Prevent deletion of the menu that belongs to orders
        if ($menu->orders->count() > 0) {
            return redirect()->route('menus.index')
                ->with('error_message', 'Menu cannot be deleted because it has orders');
        }

        $menu->delete();
        return redirect()->route('menus.index')
            ->with('success_message', 'Menu deleted successfully');
    }

    /**
     * Generate a slug for the given menu name.
     *
     * @param Request $request
     * @return Response an unique slug
     */
    public function checkSlug(CheckSlugRequest $request)
    {
        $slug = SlugService::createSlug(Menu::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }

    //TODO: DOCS
    public function addInventory(AddInventoryToMenuRequest $request, Menu $menu)
    {
        $menu->inventories()->attach($request->inventory_id, ['qty' => $request->qty]);

        return redirect()->route('menus.edit', $menu)
            ->with('success_message', 'New item added to the menu successfully');
    }
    //TODO: DOCS
    public function updateInventory(UpdateInventoryToMenuRequest $request, Menu $menu, int $inventoryId)
    {
        $menu->inventories()->updateExistingPivot($inventoryId, ['qty' => $request->qty]);

        return redirect()->route('menus.edit', $menu)
            ->with('success_message', 'Item updated successfully');
    }

    //TODO: DOCS
    public function removeInventory(Menu $menu, int $inventoryId)
    {
        $menu->inventories()->detach($inventoryId);

        return redirect()->route('menus.edit', $menu)
            ->with('success_message', 'Item removed from the menu successfully');
    }
}
