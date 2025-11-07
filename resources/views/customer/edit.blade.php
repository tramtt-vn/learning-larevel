@extends('layouts.app')

@section('title', 'Profile')
@section('content')
<div class="card p-4 shadow-sm profile-edit">
    <h3 class="text-center mb-4">Chỉnh sửa hồ sơ cá nhân </h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('customer.update') }}">
        @method('PUT')
        @csrf
        <ul>
            <li>
                <label>Họ và tên:</label>
                <div>
                    <input type="text" name="name" class="form-control" placeholder="Nhập name" required value="{{ old('name', $profiles->name) }}">
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </li>
            <li>
                <label>Mật khẩu mới:</label>
                <div>
                    <input type="password" name="password" class="form-control" placeholder="Nhập password mới" value="">
                    <span>Đổi mật khẩu (Để trống nếu không muốn đổi)</span>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </li>
            <li>
                <label>Mật khẩu xác nhận:</label>
                <div>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập password xác nhận" value="">
                </div>
            </li>
            <li>
                <label>Email:</label>
                <div>
                    <input type="email" name="email" class="form-control" placeholder="Nhập email" required value="{{ old('email', $profiles->email) }}">
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </li>
            <li>
                <label>Số điện thoại 1:</label>
                <div>
                    <input type="text" name="phone" class="form-control" placeholder="Nhập sdt" required value="{{ old('phone', $profiles->phone) }}">
                    @error('phone')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </li>
            <li>
                <label>Địa chỉ giao hàng 1:</label>
                <div>
                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $profiles->address) }}</textarea>
                    @error('address')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </li>
            <li>
                <label>Số điện thoại giao hàng 2:</label>
                <div>
                    <input type="text" name="shipping_phone" class="form-control" placeholder="Nhập sdt 2" required value="{{ old('shipping_phone', $profiles->shipping_phone) }}">
                    @error('shipping_phone')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </li>
            <li>
                <label>Địa chỉ giao hàng 2:</label>
                <div>
                    <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3">{{ old('shipping_address', $profiles->shipping_address) }}</textarea>
                    @error('shipping_address')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </li>
            <li>
                <div class="flex-d w-full">
                    <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
                </div>
            </li>
        </ul>
    </form>
</div>
@endsection
