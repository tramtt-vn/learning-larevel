<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use function Termwind\renderUsing;

class ProductController extends Controller
{
    public function index() {
        $products = Product::where('stock', '>', 0)->get();
        return view("products.index", compact("products"));
    }
    public function show($id) {
        $product = Product::where('id',$id)->firstOrFail();
        return view("products.detail", compact('product'));
    }
}
