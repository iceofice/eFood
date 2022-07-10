<?php

namespace App\Http\Controllers;

use Auth;
use View;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;
use App\Models\AttendanceCode;
use App\Http\Requests\ClockinRequest;
use App\Http\Requests\ClockoutRequest;
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
            ->with('success_message', 'Attendance deleted successfully');
    }

    //TODO: Docs
    public function code()
    {
        $code = AttendanceCode::first()->attendanceCode;
        return view('attendances.code', compact('code'));
    }

    //TODO: Docs
    public function staff()
    {
        return view('attendances.staff');
    }

    //TODO: Docs
    public function clockin(ClockinRequest $request)
    {
        $att = Attendance::where('user_id', Auth()->user()->id)->whereNull('clock_out')->exists();

        if ($att) {
            return redirect()->route('attendances.staff')
                ->with('error_message', 'Please Check Out First!');
        }

        Attendance::create([
            'user_id' => Auth::user()->id,
            'clock_in' => Carbon::now()->addHours(8),
            'clock_out' => null,
        ]);

        return redirect()->route('attendances.staff')
            ->with('success_message', 'Clock In successful');
    }

    //TODO: Docs
    public function clockout(ClockoutRequest $request)
    {
        $att = Attendance::where('user_id', Auth()->user()->id)->whereNull('clock_out')->first();

        if (is_null($att)) {
            return redirect()->route('attendances.staff')
                ->with('error_message', 'Please Check In First!');
        }

        $att->update([
            'clock_out' => Carbon::now()->addHours(8),
        ]);

        return redirect()->route('attendances.staff')
            ->with('success_message', 'Clock Out successful');
    }

    //TODO: Docs
    public function details(User $user)
    {
        $monthLabel = range(1, Carbon::now()->addHours(8)->daysInMonth);
        $weekLabel = [
            'Mon',
            'Tue',
            'Wed',
            'Thu',
            'Fri',
            'Sat',
            'Sun'
        ];

        for ($i = 0; $i < 7; $i++) {
            $weekData[] = $user->attendances()
                ->whereDate('clock_in', Carbon::now()->addHours(8)->startOfWeek()->addDays($i))
                ->get()
                ->sum(fn ($value) => Carbon::parse($value->clock_in)->diffInHours(Carbon::parse($value->clock_out)));
        }

        for ($i = 0; $i < Carbon::now()->addHours(8)->daysInMonth; $i++) {
            $monthData[] = $user->attendances()
                ->whereDate('clock_in', Carbon::now()->addHours(8)->startOfMonth()->addDays($i))
                ->get()
                ->sum(fn ($value) => Carbon::parse($value->clock_in)->diffInHours(Carbon::parse($value->clock_out)));
        }

        return view('attendances.details', compact('user', 'monthLabel', 'weekLabel', 'weekData', 'monthData'));
    }
}
