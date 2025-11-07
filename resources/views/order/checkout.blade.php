@extends('layouts.app')

@section('title', 'List Users')
@section('content')
<div class="container">
    <h2 class="mb-4">Thanh toán đơn hàng</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="row">
            <!-- Danh sách sản phẩm -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Sản phẩm đã chọn</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->product->name }}</strong>
                                        </td>
                                        <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end">
                                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Tổng cộng:</th>
                                    <th class="text-end text-danger">
                                        {{ number_format($total, 0, ',', '.') }}đ
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Phương thức thanh toán -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Phương thức thanh toán</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input"
                                    type="radio"
                                    name="payment_method"
                                    id="cod"
                                    value="cod"
                                    checked>
                            <label class="form-check-label" for="cod">
                                <strong>Thanh toán khi nhận hàng (COD)</strong>
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input"
                                    type="radio"
                                    name="payment_method"
                                    id="bank_transfer"
                                    value="bank_transfer">
                            <label class="form-check-label" for="bank_transfer">
                                <strong>Chuyển khoản ngân hàng</strong>
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input"
                                    type="radio"
                                    name="payment_method"
                                    id="momo"
                                    value="momo">
                            <label class="form-check-label" for="momo">
                                <strong>Ví MoMo</strong>
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input"
                                    type="radio"
                                    name="payment_method"
                                    id="vnpay"
                                    value="vnpay">
                            <label class="form-check-label" for="vnpay">
                                <strong>VNPay</strong>
                            </label>
                        </div>

                        @error('payment_method')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-3 d-grid gap-2">
                    <button type="submit" class="btn btn-primary mw-400">
                        Đặt hàng
                    </button>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                        Quay lại giỏ hàng
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
