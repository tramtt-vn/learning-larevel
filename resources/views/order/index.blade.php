@extends('layouts.app')

@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container">
    <h2>Danh sách đơn hàng</h2>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên khách hàng</th>
                <th>Phương thức thanh toán</th>
                <th>Tổng tiền</th>
                <th>Ngày tạo</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer->name ?? 'N/A' }}</td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ number_format($order->total_amount) }} đ</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $order->status }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Không có đơn hàng nào</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $orders->links() }}
</div>
@endsection
