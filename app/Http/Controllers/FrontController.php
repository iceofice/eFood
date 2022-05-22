<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use App\Datatables\CategoryDatatable;


class FrontController extends Controller
{

    public function index()
    {
        $menus = Menu::with('categories')->get()->groupBy('categories.*.slug')->all();
        foreach ($menus as $key => $menu) {
            $menus[$key] = array_chunk($menu->all(), ceil(count($menu) / 2));
        }
        $categories = Category::all()->pluck('name', 'slug');
        $featured = Menu::where('featured', 1)->get()->take(3);

        return view('index', compact('menus', 'categories', 'featured'));
    }
}
