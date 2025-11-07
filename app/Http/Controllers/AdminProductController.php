<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index(Request $request) {
        $query = Product::where('stock', '>', 0);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('code', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%");
            });
        }
        if ($request->filled('status')) {
            $status = $request->status;
            if (in_array($status, ['active', 'inactive', 'draft','out_of_stock'])) {
                $query->where('status', $status);
            }

        }
        $products = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $activeCount = Product::where('status', 'active')->count();
        $outOfStockCount = Product::where('stock', 0)->count();

        return view("admin.products.index", compact('products','activeCount','outOfStockCount'));
    }
    public function create()
    {
        $products = Product::all();
        return view('admin.products.create', compact('products'));
    }
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        // Xử lý upload ảnh chính
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/products', 'public');
        }
        $data['code']  = 'COD' . strtoupper(Str::random(9));

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Thêm sản phẩm thành công!');
    }

     public function edit($id)
    {
        $products = Product::findOrFail($id);
        return view('admin.products.edit', compact('products'));
    }
    public function update(ProductUpdateRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('images/products', 'public');
        }
        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được xóa thành công!');
    }

}
