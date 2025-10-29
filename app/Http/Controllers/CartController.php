<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index() {
        $customer = Auth::guard('customer')->user();
        $cart = $customer->cart;
        if (!$cart) {
            $cartItems = collect([]);
        } else {
            $cartItems = $cart->itemCart()->with('product')->get();
        }
        $total = $this->getCartTotal($cart);
        return view("cart.index",compact("cartItems", "total"));
    }
    public function add(Request $request, $id) {

        $request->validate(['quantity' => 'nullable|integer|min:1',]);
        $customer = Auth::guard('customer')->user();
        $product = Product::findOrFail($id);
        if(!$product->isInStock()) {
            return redirect()->back()->with("error", "Sản phẩm đã hết hàng");
        }
        $quantity = $request->input('quantity', 1);
        if($quantity > $product->stock) {
            return redirect()->back()->with('error', 'Sản phẩm vượt số lượng tồn kho');
        }
        $cart = $customer->cart;
        if(!$cart) {
            $cart = Cart::create([
                'customer_id' => $customer->id,
            ]);
        }
        $cartItem = CartItem::where('cart_id' ,$cart->id)->where('product_id', $product->id)->first();
        if($cartItem){
            $newQuantity = $cartItem->quantity + $quantity;
            if($newQuantity > $product->stock){
                return redirect()->back()->with('error', 'Sản phẩm vượt số lượng tồn kho');
            }
            $cartItem->update([
                'quantity' => $newQuantity,
            ]);
             return redirect()->back()->with('success', 'Đã cập nhật số lượng sản phẩm vào giỏ hàng!');
        }else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);

            return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng');
        }
    }
    private function getCartTotal($cart)
    {
        $total = 0;
        //dd($cart);
        if($cart) {
            $cartItems = $cart->itemCart;
             foreach ($cartItems as $item) {
                $total += $item['price'] * $item['quantity'];
            }
        }


        return $total;
    }
}
