<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10,2);
            $table->string('image');
            $table->integer('stock');
            $table->timestamps();
        });
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 10)->nullable();
            $table->string('address')->nullable();
            $table->string('password');
            $table->timestamps();
        });
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('quantity', 10)->nullable();
            $table->decimal('price', 10,2);
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->dateTime('order_date')->nullable();
            $table->decimal('total_amount', 11,2);
            $table->enum('status', ['pending','paid','shipped','completed','cancelled']);
            $table->enum('payment_method',['cash','transfer']);
            $table->timestamps();
        });
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('quantity', 10)->nullable();
            $table->decimal('price', 10,2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_items');
    }
};
