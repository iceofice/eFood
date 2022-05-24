<?php

namespace App\Http\Controllers;

use View;
use App\Models\Table;
use App\Datatables\TableDatatable;
use App\Http\Requests\CreateTableRequest;
use App\Http\Requests\UpdateTableRequest;

class TableController extends Controller
{
    /**
     * Share the model name and route with the view
     */
    public function __construct()
    {
        $modelName = 'Table';
        $route = 'tables';
        View::share(compact('modelName', 'route'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = Table::all();
        $table = new TableDatatable($tables);

        return view('crud.index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tables.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTableRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTableRequest $request)
    {
        Table::create($request->validated());
        return redirect()->route('tables.index')
            ->with('success_message', 'Table added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Table $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        $id = $table->id;
        return view('tables.edit', compact('table', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTableRequest  $request
     * @param  Table $table
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTableRequest $request, Table $table)
    {
        $table->update($request->validated());
        return redirect()->route('tables.index')
            ->with('success_message', 'Table modified successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Table $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        $table->delete();
        return redirect()->route('tables.index')
            ->with('success_message', 'Table deleted successfully');
    }
}
