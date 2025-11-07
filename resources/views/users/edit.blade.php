@extends('layouts.admin')

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
    <form method="POST" action="{{ route('users.update') }}">
        @method('PUT')
        @csrf
        <ul>
            <li>
                <label>Tên:</label>
                <div>
                    <input type="text" name="name" class="form-control" placeholder="Nhập name" required value="{{ old('name', $profiles->name) }}">
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </li>
            <li>
                <label>Họ và tên đầy đủ:</label>
                <div>
                    <input type="text" name="fullname" class="form-control" placeholder="Nhập fullname" required value="{{ old('fullname', $profiles->fullname) }}">
                    @error('fullname')
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
                    <span style="font-size: 16px;">{{ $profiles->email }}</span>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </li>
            <li>
                <label>Số điện thoại:</label>
                <div>
                    <input type="text" name="phone" class="form-control" placeholder="Nhập sdt" required value="{{ old('phone', $profiles->phone) }}">
                    @error('phone')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </li>
            <li>
                <label>Địa chỉ:</label>
                <div>
                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $profiles->address) }}</textarea>
                    @error('address')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </li>
            <li>
                <label>Tuổi:</label>
                <div>
                    <input type="text" name="age" class="form-control" placeholder="Nhập tuổi" required value="{{ old('age', $profiles->age) }}">
                    @error('age')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </li>
            <li>
                <label>Ngày sinh:</label>
                <div>
                    <input type="date" name="birth_day" max="{{ date('Y-m-d') }}" class="form-control mw-400" placeholder="Nhập ngày sinh" required value="{{ old('birth_day', $profiles->birth_day) }}">
                    @error('birth_day')
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
