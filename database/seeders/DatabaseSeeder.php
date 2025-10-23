<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo Products
        $products = Product::factory(20)->create();

        // 2. Tạo Customers
        $customers = Customer::factory(10)->create();

        // 3. Tạo Carts cho một số customers
        foreach ($customers->take(5) as $customer) {
            $cart = Cart::create([
                'customer_id' => $customer->id,
            ]);

            // Thêm 2-5 sản phẩm vào giỏ hàng
            $randomProducts = $products->random(rand(2, 5));
            foreach ($randomProducts as $product) {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => (string) rand(1, 5), // String như schema
                    'price' => $product->price,
                ]);
            }
        }

        // 4. Tạo Orders
        foreach ($customers->take(8) as $customer) {
            // Mỗi customer có 1-3 đơn hàng
            for ($i = 0; $i < rand(1, 3); $i++) {
                $orderProducts = $products->random(rand(1, 4));
                $totalAmount = 0;

                $order = Order::create([
                    'customer_id' => $customer->id,
                    'product_id' => $orderProducts->first()->id, // Giữ theo schema
                    'order_date' => now()->subDays(rand(0, 30)),
                    'total_amount' => 0, // Tính sau
                    'status' => fake()->randomElement(['pending', 'paid', 'shipped', 'completed', 'cancelled']),
                    'payment_method' => fake()->randomElement(['cash', 'transfer']),
                ]);

                // Tạo order items
                foreach ($orderProducts as $product) {
                    $quantity = rand(1, 3);
                    $price = $product->price;
                    $totalAmount += $price * $quantity;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => (string) $quantity, // String như schema
                        'price' => $price,
                    ]);
                }

                // Cập nhật total_amount
                $order->update(['total_amount' => $totalAmount]);
            }
        }
        echo "\n🎉 Hoàn thành! Kiểm tra database nhé.\n";
    }
}
