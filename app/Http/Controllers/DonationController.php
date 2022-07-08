<?php

namespace App\Http\Controllers;

use App\Models\Donation;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $donationAmount = Donation::find(1)->amount;
        return view('donations.index', compact('donationAmount'));
    }
}
