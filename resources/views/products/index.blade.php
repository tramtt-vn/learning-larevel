
@extends('layouts.app')
@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <ul class="list-product">
        @foreach ($products as $product)
            <li>
                <a href="{{ route('products.detail', $product->id) }}">
                    <img src="{{ asset("images/".$product->image) }}">
                    <span class="name">{{ $product->name }}</span>
                    <span class="description">{{ $product->description }}</span>
                    <label>{{ number_format($product->price) }} <span>VNĐ</span></label>
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
