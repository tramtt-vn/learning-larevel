@extends('layouts.app')

@section('title', 'List Users')
@section('content')


<div class="container">
    <div class="dflex-head">
        <h2 class="mb-4 text-center">Danh sách giỏ hàng</h2>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Đăng xuất
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
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
        @foreach ($cartItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</td>
                <td>
                    <button type="submit" class="btn btn-primary w-100">Xóa</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
