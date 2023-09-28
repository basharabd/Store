<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TowFactorAuthenticationController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        return view('front.auth.two_factor_auth' , compact('user'));
    }
}