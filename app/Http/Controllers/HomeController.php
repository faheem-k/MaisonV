<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Get latest 8 products for home page
        $products = Product::latest()->take(8)->get();
        return view('home', compact('products'));
    }
}
