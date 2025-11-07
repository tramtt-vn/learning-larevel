
@extends('layouts.app')
@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="search-product">
        <label>Tìm kiếm:</label>
        <form class="form" action="{{ route('products.index') }}" method="GET">
            <input class="form-control" type="text" name="search" placeholder="Search..." />
            <button class="btn btn-search" type="submit">
                <svg class="icon " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
                </svg>
            </button>
        </form>
    </div>
    <ul class="list-product">
        @foreach ($products as $product)
            <li>
                <a href="{{ route('products.detail', $product->id) }}">
                    <img src="{{ ($product->image) ? asset("storage/".$product->image) : 'https://via.placeholder.com/80x80' }}">
                    <span class="name">{{ $product->name }}</span>
                    <span class="description">{{ $product->description }}</span>
                    <span class="code">Product code: {{ $product->code }}</span>
                    <label>{{ number_format($product->price) }} <span>VNĐ</span></label>
                </a>
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
                                {{ $product->isInStock() ? '🛒' : 'Hết hàng' }}
                            </button>

                        </div>
                    </form>
                @endauth
            </li>
        @endforeach
    </ul>
    <!-- Pagination -->
    <div class="row mt-3">
        <div class="pagination">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
