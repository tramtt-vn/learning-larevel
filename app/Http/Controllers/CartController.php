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
    public function remove($id) {
        $customer = Auth::guard('customer')->user();
        $cart = $customer->cart;
        if(!$cart) {
            return redirect('cart.index')->back()->with('error', 'Giỏ hàng không tồn tại');
        }
        CartItem::where('cart_id', $cart->id)->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Xóa sản phầm trong giỏ hàng');
    }
    public function update(Request $request,$id) {

        $customer = Auth::guard('customer')->user();
        $cart = $customer->cart;

        if(!$cart) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng không tồn tại!');
        }
        $cartItem = CartItem::where('cart_id', $cart->id)->where('id', $id)->firstOrFail();

        if($cartItem->product->stock < $request->quantity) {
            return redirect()->route('cart.index')->with('error', 'Sản phẩm trong kho không đủ');
        }
        //dd($request->quantity);
        $cartItem->update(['quantity' => $request->quantity]);
        return redirect()->back()->with('success', 'Đã cập nhật sản phầm trong giỏ hàng thành công');
    }
    public function clear() {

        $customer = Auth::guard('customer')->user();
        $cart = $customer->cart;

        if(!$cart) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng không tồn tại!');
        }
        if ($cart->itemCart()->count() === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng đã trống!');
        }
        $cart->itemCart()->delete();
        //dd($request->quantity);
        //$cart->cleanItem();
        return redirect()->back()->with('success', 'Đã xóa tất cả sản phầm trong giỏ hàng');
    }
}
