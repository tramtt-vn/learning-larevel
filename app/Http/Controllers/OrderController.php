<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {

        $customer = Auth::guard('customer')->user();
        $cartId = Cart::where('customer_id', $customer->id)->first();

        if (empty($cartId->id)) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi đặt hàng.');
        }
        $cartItems = CartItem::where('cart_id', $cartId->id)->get();

        $total = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        return view('order.checkout', compact('cartItems', 'total'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $orders = Order::where('customer_id', $customer->id)->paginate(10);
        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cod,bank_transfer,momo,vnpay',
        ],[
            'payment_method' => 'Vui lòng chọn phương thức thanh toán',
        ]);
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return redirect()->route('login')
                ->with('error', 'Vui lòng đăng nhập để đặt hàng.');
        }
        $cart = Cart::where('customer_id', $customer->id)->first();

        if (!$cart) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi đặt hàng.');
        }
        DB::beginTransaction();
        try {
            $cartItems = CartItem::where('cart_id', $cart->id)->get();
            if ($cartItems->isEmpty()) {
                DB::rollBack();
                return redirect()->route('cart.index')
                    ->with('error', 'Giỏ hàng trống.');
            }
            $total_amount = $cartItems->sum(function($item) {
                return $item->price * $item->quantity;
            });
            dump($total_amount);
            $order = Order::create([
                'customer_id' => $customer->id,
                'order_date' => Carbon::now(),
                'total_amount' => $total_amount,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
            ]);
            foreach($cartItems as $item){
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
                $product = $item->product;        // Lấy Product model từ relationship cartitem
                if ($product) {
                    $product->stock -= $item->quantity;
                    $product->save();
                }  // Giảm số lượng
            }
            Cart::where('customer_id', $customer->id)->delete();
            CartItem::where('cart_id', $cart->id)->delete();

            DB::commit();

            return redirect()->route('orders.success', $order->id);

        } catch(Exception $e){
             Log::error('Order Creation Error: ' . $e->getMessage());
            Log::error('Stack Trace: ' . $e->getTraceAsString());

            // Hiển thị lỗi chi tiết (CHỈ dùng khi development)
            return back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    public function success($orderId)
    {

        $order = Order::with('itemOrder.product')->findOrFail($orderId);

        // Kiểm tra order có phải của user hiện tại không
        if ($order->customer_id !== Auth::id()) {
            abort(403);
        }

        return view('order.success', compact('order'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
