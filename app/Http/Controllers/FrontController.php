<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use App\Datatables\CategoryDatatable;


class FrontController extends Controller
{

    public function index()
    {
        $menus = Menu::all();
        $categories = Category::all();
        return view('index', compact('menus'));
    }
}
