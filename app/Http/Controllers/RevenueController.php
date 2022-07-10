<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Payment;

class RevenueController extends Controller
{
    /**
     * Display the revenue.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

        $yearLabel = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ];

        for ($i = 0; $i < 7; $i++) {
            $weekData[] = Payment::whereDate('paid_at', Carbon::now()->addHours(8)->startOfWeek()->addDays($i))
                ->get()
                ->sum(fn ($value) => $value->discount_total);
        }

        for ($i = 0; $i < Carbon::now()->addHours(8)->daysInMonth; $i++) {
            $monthData[] = Payment::whereDate('paid_at', Carbon::now()->addHours(8)->startOfMonth()->addDays($i))
                ->get()
                ->sum(fn ($value) => $value->discount_total);
        }

        for ($i = 0; $i < 12; $i++) {
            $yearData[] = Payment::whereMonth('paid_at', $i + 1)
                ->get()
                ->sum(fn ($value) => $value->discount_total);
        }

        return view('revenue.index', compact('monthLabel', 'weekLabel', 'yearLabel', 'weekData', 'monthData', 'yearData'));
    }
}
