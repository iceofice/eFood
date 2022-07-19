<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Http\Requests\OutDonationRequest;

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

    public function out(OutDonationRequest $request)
    {
        $donation = Donation::find(1);

        $donation->update([
            'amount' => $donation->amount - $request->amount
        ]);

        return redirect()->route('donations.index')
            ->with('success_message', 'Donation has been pulled out.');
    }
}
