
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
                    <img src="{{ asset("images/".$product->image) }}">
                    <span class="name">{{ $product->name }}</span>
                    <span class="description">{{ $product->description }}</span>
                    <span class="code">Product code: {{ $product->code }}</span>
                    <label>{{ number_format($product->price) }} <span>VNĐ</span></label>
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
