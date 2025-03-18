<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $title = "Trang chủ";
        $products = Product::with('category', 'mainImage', 'variants', 'images')->get();
        return view('index', compact('products', 'title'));
    }
}
