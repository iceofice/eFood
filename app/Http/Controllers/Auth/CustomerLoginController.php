<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerLoginRequest;

class CustomerLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:customer');
    }

    public function login(CustomerLoginRequest $request)
    {
        if (isset($request->validated()['email'])) {
            $credentials['email'] = $request->validated()['email'];
        } else {
            $credentials['phone'] = $request->validated()['phone'];
        }
        $credentials['password'] = $request->validated()['password'];

        if (Auth::guard('customer')->attempt($credentials, false)) {
            return redirect()->route('front.profile');
        }

        return redirect(route('front') . '/#profile-section')->withErrors(['login' => 'Invalid credentials'], 'login');
    }
}
