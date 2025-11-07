@extends('layouts.app')
@section('content')

<div class="login-box">
    <h3 class="text-center mb-4">Đăng nhập cho khách hàng:</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('customer.login.submit') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control"
                   placeholder="Nhập email" required value="{{ old('email') }}">
            @error('email')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu:</label>
            <input type="password" name="password" id="password" class="form-control"
                   placeholder="Nhập mật khẩu" required>
            @error('password')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="remember" id="remember" class="form-check-input">
            <label for="remember" class="form-check-label">Ghi nhớ đăng nhập</label>
        </div>

        <button type="submit" class="btn btn-primary mw-400">Đăng nhập</button>
    </form>

    <div class="text-center mt-3">
        <a href="{{ route('customer.register') }}">Chưa có tài khoản? Đăng ký</a>
    </div>
</div>
@endsection
