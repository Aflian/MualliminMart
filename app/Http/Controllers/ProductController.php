<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $getProduct = Product::all();

        return view('katalog',compact('getProduct'));

    }
}
