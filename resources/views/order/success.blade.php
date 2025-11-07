@extends('layouts.app')

@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                    <h2 class="mt-4">Đặt hàng thành công!</h2>
                    <p class="text-muted">Cảm ơn bạn đã đặt hàng.</p>

                    <div class="alert alert-info mt-4">
                        <strong>Mã đơn hàng:</strong> #COD{{ $order->id }}<br>
                        <strong>Ngày đặt:</strong> {{ $order->order_date->format('d/m/Y') }}<br>
                        <strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }}đ<br>
                        <strong>Phương thức thanh toán:</strong> {{ $order->payment_method }}
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary">
                            Xem chi tiết đơn hàng
                        </a>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                            Danh sách đơn hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
