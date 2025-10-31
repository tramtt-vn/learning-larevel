@extends('layouts.app')

@section('title', 'List Users')
@section('content')


<div class="container">
    <h2 class="mb-4 text-center">Danh sách người dùng</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Sản phẩm</th>
                <th>Giá tiền</th>
                <th>số lượng</th>
                <th>tổng tiền</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @if($cartItems->count() > 0)
            @foreach ($cartItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                    <td>
                        <form action="{{ route('cart.update', $item->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="flex-d">
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" style="width: 60px;">
                                <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
                            </div>
                        </form>
                    </td>
                    <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</td>
                    <td>
                        <form action="{{ route('cart.remove', $item->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-primary w-100">xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5">Giỏ hàng không có sản phẩm nào</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="flex-d">
        <a href="{{ route('cart.index') }}">Quay về</a>
         @if($cartItems->count() > 0)
            <form action="{{ route('cart.clear') }}" method="post">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-primary w-100">xóa tất cả</button>
            </form>
        @endif
    </div>
</div>
@endsection
