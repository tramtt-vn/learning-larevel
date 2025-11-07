@extends('layouts.app')

@section('title', 'Profile')
@section('content')
<div class="card p-4 shadow-sm profile">
    <h3 class="text-center mb-4">Hồ sơ cá nhân </h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <ul>
        <li><label>Họ và tên:</label>{{ $profiles->name ?? 'Chưa cập nhật'}}</li>
        <li><label>Email:</label>{{ $profiles->email ?? 'Chưa cập nhật'}}</li>
        <li><label>Số điện thoại:</label>{{ $profiles->phone ?? 'Chưa cập nhật'}}</li>
        <li><label>Địa chỉ giao hàng 1:</label>{{ $profiles->address ?? 'Chưa cập nhật'}}</li>
        <li><label>Địa chỉ giao hàng 2:</label>{{ $profiles->shipping_address ?? 'Chưa cập nhật'}}</li>
        <li><label>Số điện thoại giao hàng:</label>{{ $profiles->shipping_phone ?? 'Chưa cập nhật' }}</li>
        <li>
            <div class="flex-d w-full">
                <a href="{{ route('customer.edit') }}" class="btn btn-primary">Chỉnh sửa thông tin</a>
            </div>
        </li>
    </ul>
</div>
<div class="card p-4 shadow-sm profile-order">
    @if($profiles)
        <h3 class="text-center mb-4">Đơn hàng của tôi</h3>
        <p>Chưa có đơn hàng nào</p>
    @else
        <p>Không tìm thấy thông tin</p>
    @endif
</div>
@endsection
