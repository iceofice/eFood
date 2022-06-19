<?php

namespace App\Http\Controllers;

use View;
use App\Models\User;
use App\Models\Attendance;
use App\Models\AttendanceCode;
use App\Datatables\AttendanceDatatable;
use App\Http\Requests\CreateAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;

class AttendanceController extends Controller
{
    /**
     * Share the model name and route with the view
     */
    public function __construct()
    {
        $modelName = 'Attendance';
        $route = 'attendances';

        $users = User::where('id', '!=', 1)->pluck('name', 'id')->toArray();
        View::share(compact('modelName', 'route', 'users'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = Attendance::with('user')->get();
        $table = new AttendanceDatatable($attendances);

        return view('attendances.index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('attendances.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAttendanceRequest $request)
    {
        Attendance::create($request->validated());

        return redirect()->route('attendances.index')
            ->with('success_message', 'Attendance added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        $id = $attendance->id;
        return view('attendances.edit', compact('attendance', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        $attendance->update($request->validated());

        return redirect()->route('attendances.index')
            ->with('success_message', 'Attendance modified successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendances.index')
            ->with('success_message', 'Menu deleted successfully');
    }

    //TODO: Docs
    public function code()
    {
        $code = sprintf("%03s", AttendanceCode::first()->code);
        return view('attendances.code', compact('code'));
    }

    //TODO: Docs
    public function staff()
    {
        return view('attendances.staff');
    }

    //TODO: Docs
    public function clockin()
    {
        return view('attendances.staff');
    }
}
