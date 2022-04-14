<?php

namespace App\Http\Controllers;

use View;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Datatables\CategoryDatatable;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;

class CategoryController extends Controller
{
    /**
     * Share the model name and route with the view
     */
    public function __construct()
    {
        $modelName = 'Category';
        $route = 'categories';
        View::share(compact('modelName', 'route'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $table = new CategoryDatatable($categories);

        return view('crud.index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $validatedRequest = $request->validated();
        if ($request->image) {
            unset($validatedRequest['image']);
            $request->image->store('public');
            $validatedRequest['image'] = $request->image->hashName();
        }

        Category::create($validatedRequest);
        return redirect()->route('categories.index')
            ->with('success_message', 'Category added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $id = $category->id;
        return view('categories.edit', compact('category', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCategoryRequest  $request
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validatedRequest = $request->validated();
        if ($request->image) {
            unset($validatedRequest['image']);
            $request->image->store('public');
            $validatedRequest['image'] = $request->image->hashName();
        }

        $category->update($validatedRequest);
        return redirect()->route('categories.index')
            ->with('success_message', 'Category modified successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')
            ->with('success_message', 'Category deleted successfully');
    }

    /**
     * Generate a slug for the given category name.
     *
     * @param Request $request
     * @return Response an unique slug
     */
    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Category::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
