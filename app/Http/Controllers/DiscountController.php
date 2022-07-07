<?php

namespace App\Http\Controllers;

use View;
use App\Models\Discount;
use App\Datatables\DiscountDatatable;
use App\Http\Requests\CreateDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;

class DiscountController extends Controller
{
    /**
     * Share the model name and route with the view
     */
    public function __construct()
    {
        $modelName = 'Discount';
        $route = 'discounts';
        View::share(compact('modelName', 'route'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discount::all();
        $table = new DiscountDatatable($discounts);

        return view('crud.index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateDiscountRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDiscountRequest $request)
    {
        Discount::create($request->validated());
        return redirect()->route('discounts.index')
            ->with('success_message', 'Discount added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Discount $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        $id = $discount->id;
        return view('discounts.edit', compact('discount', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateDiscountRequest $request
     * @param  Discount $discount
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDiscountRequest $request, Discount $discount)
    {
        $discount->update($request->validated());

        return redirect()->route('discounts.index')
            ->with('success_message', 'Discount modified successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('discounts.index')
            ->with('success_message', 'Discount deleted successfully');
    }
}
