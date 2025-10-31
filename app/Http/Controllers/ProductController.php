<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use function Termwind\renderUsing;

class ProductController extends Controller
{
    public function index(Request $request) {
        $query = Product::where('stock', '>', 0);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $products = $query->where(function($q) use ($search) {
                $q->where('code', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%");
            });
        }
        $products = $query->get();
        return view("products.index", compact("products"));
    }
    public function show($id) {
        $product = Product::where('id',$id)->firstOrFail();
        return view("products.detail", compact('product'));
    }
}
