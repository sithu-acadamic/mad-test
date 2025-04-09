<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = ''; //Product::orderByRaw('ISNULL(product_index), product_index ASC')->limit(3)->get();
        return view('welcome');
    }
}
