<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {



        $products  = Product::with('category')->active()
        ->latest()
        ->limit(8)
        ->get();

        return view('front.home' , compact('products'));
    }
}