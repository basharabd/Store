<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;
use Symfony\Component\Intl\Locales;




class ProfileController extends Controller
{

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function edit()
    {
        $user = Auth::user();
        $countries = Countries::getNames('en');
        $languages = Languages::getNames('en');
        $locales = Locales::getNames('en');




        return view('dashboard.profile.edit' , compact('user' , 'countries' , 'languages', 'locales'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'gender' => ['in:male,female'],
            'country' => ['required', 'string', 'size:2'],
        ]);

        $user = $request->user();

        $user->profile->fill( $request->all() )->save();

        return redirect()->route('profiles.edit')
            ->with('success', 'Profile updated!');


    }
}
