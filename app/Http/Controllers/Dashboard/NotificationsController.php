<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $user  = Auth::user();
     $notifications =    $user->notifications;

     return view('dashboard.notifications.index' , compact('notifications'));


    }
}
