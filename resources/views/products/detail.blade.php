
@extends('layouts.app')
<style>
.product-detail {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 3rem;
    max-width: 1080px;
    margin: auto;
}

.product-image-large {
    width: 100%;
    height: 500px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 8rem;
    overflow: hidden;
}

.product-image-large img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-details-content {
    display: flex;
    flex-direction: column;
}
</style>
@section('content')
<div class="product-detail">
    <!-- Product Image -->
    <div class="product-image-large">
        @if($product->image && file_exists(public_path('images/' . $product->image)))
            <img src="{{ asset("images/".$product->image) }}" alt="{{ $product->name }}">
        @else
            📦
        @endif
    </div>

    <!-- Product Info -->
    <div class="product-details-content">
        <div class="breadcrumb">
            <a href="{{ route('products.index') }}">Sản phẩm</a> / {{ $product->name }}
        </div>

        <h1 class="product-title">{{ $product->name }}</h1>

        <!-- Price -->
        <div class="product-price-section">
            <span class="price-large">{{ number_format($product->price, 0, ',', '.') }}đ</span>
        </div>

        <!-- Description -->
        <div class="product-description">
            <h3>Mô tả sản phẩm</h3>
            <p>{{ $product->description }}</p>
        </div>

        <!-- Stock Info -->
        <div class="product-stock-info {{ $product->isInStock() ? '' : 'out-of-stock' }}">
            @if($product->isInStock())
                ✓ Còn {{ $product->stock }} sản phẩm
            @else
                ✗ Sản phẩm tạm hết hàng
            @endif
        </div>
        @auth('customer')
            <!-- Add to Cart Form -->
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <div class="add-to-cart-section">
                    <div class="quantity-input">
                        <button type="button" onclick="decreaseQuantity()" {{ !$product->isInStock() ? 'disabled' : '' }}>-</button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" readonly {{ !$product->isInStock() ? 'disabled' : '' }}>
                        <button type="button" onclick="increaseQuantity()" {{ !$product->isInStock() ? 'disabled' : '' }}>+</button>
                    </div>

                    <button type="submit" class="btn-add-to-cart" {{ !$product->isInStock() ? 'disabled' : '' }}>
                        {{ $product->isInStock() ? '🛒 Thêm vào giỏ hàng' : 'Hết hàng' }}
                    </button>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                </div>
            </form>
        @else
            <div class="add-to-cart-section">
                <a href="{{ route('customer.login') }}" class="btn-login">
                    Đăng nhập để mua hàng
                </a>
            </div>
        @endauth
    </div>
</div>

@endsection
 <script>
        const maxStock = {{ $product->stock }};

        function increaseQuantity() {
            const input = document.getElementById('quantity');
            const currentValue = parseInt(input.value);
            if (currentValue < maxStock) {
                input.value = currentValue + 1;
            }
        }

        function decreaseQuantity() {
            const input = document.getElementById('quantity');
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }
    </script>
