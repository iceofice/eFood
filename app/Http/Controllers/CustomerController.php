<?php

namespace App\Http\Controllers;

use View;
use App\Models\Customer;
use App\Datatables\CustomerDatatable;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends Controller
{
    /**
     * Share the model name and route with the view
     */
    public function __construct()
    {
        $modelName = 'Customer';
        $route = 'customers';
        View::share(compact('modelName', 'route'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        $table = new CustomerDatatable($customers);

        return view('crud.index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCustomerRequest $request)
    {
        Customer::create($request->validated());

        return redirect()->route('customers.index')
            ->with('success_message', 'Customer added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $id = $customer->id;
        return view('customers.edit', compact('customer', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCustomerRequest  $request
     * @param  Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $validatedRequest = $request->validated();

        if (isset($validatedRequest['password'])) {
            $validatedRequest['password'] = bcrypt($validatedRequest['password']);
        }

        $customer->update($validatedRequest);
        return redirect()->route('customers.index')
            ->with('success_message', 'Customer modified successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')
            ->with('success_message', 'Customer deleted successfully');
    }
}
