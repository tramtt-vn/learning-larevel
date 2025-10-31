@extends('layouts.app')

@section('title', 'Customer Register')
@section('content')
<div class="card p-4 shadow-sm register-block">
    <h3 class="text-center mb-4">Đăng ký tài khoản cho khác hàng</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customer.register') }}" method="POST" id="registerForm">
        @csrf
        <div class="form-grid">
            <!-- Họ tên -->
            <div class="form-group">
                <label for="name">
                    Họ và tên <span class="required">*</span>
                </label>
                <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Nguyễn Văn A">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">
                    Email <span class="required">*</span>
                </label>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="example@email.com">
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Mật khẩu -->
            <div class="form-group">
                <label for="password">
                    Mật khẩu <span class="required">*</span>
                </label>
                <input class="form-control" type="password" id="password" name="password" required placeholder="Tối thiểu 6 ký tự"
                >
                <div class="password-strength">
                    <div class="strength-bar">
                        <div class="strength-bar-fill" id="strengthBar"></div>
                    </div>
                    <span id="strengthText"></span>
                </div>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                <span class="helper-text">Mật khẩu phải có chữ hoa, chữ thường và số</span>
            </div>

            <!-- Xác nhận mật khẩu -->
            <div class="form-group">
                <label for="password_confirmation">
                    Xác nhận mật khẩu <span class="required">*</span>
                </label>
                <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required placeholder="Nhập lại mật khẩu">
            </div>

            <!-- Section: Thông tin liên hệ -->
            <div class="section-title">Thông tin liên hệ</div>

            <!-- Số điện thoại -->
            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input class="form-control"
                    type="tel"
                    id="phone"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="0901234567"
                    maxlength="11"
                >
                @error('phone')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                <span class="helper-text">10-11 chữ số</span>
            </div>

            <!-- Địa chỉ -->
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input class="form-control"
                    type="text"
                    id="address"
                    name="address"
                    value="{{ old('address') }}"
                    placeholder="Số nhà, tên đường, quận/huyện, tỉnh/thành"
                >
                @error('address')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Section: Thông tin giao hàng (không bắt buộc) -->
            <div class="section-title">Thông tin giao hàng (nếu khác địa chỉ trên)</div>

            <!-- Địa chỉ giao hàng -->
            <div class="form-group">
                <label for="shipping_address">Địa chỉ giao hàng</label>
                <input class="form-control"
                    type="text"
                    id="shipping_address"
                    name="shipping_address"
                    value="{{ old('shipping_address') }}"
                    placeholder="Để trống nếu giống địa chỉ trên"
                >
                @error('shipping_address')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- SĐT giao hàng -->
            <div class="form-group">
                <label for="shipping_phone">SĐT người nhận</label>
                <input class="form-control"
                    type="tel"
                    id="shipping_phone"
                    name="shipping_phone"
                    value="{{ old('shipping_phone') }}"
                    placeholder="Để trống nếu giống SĐT trên"
                    maxlength="11"
                >
                @error('shipping_phone')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Ghi chú -->
            <div class="form-group form-group-full">
                <label for="notes">Ghi chú</label>
                <textarea class="form-control"
                    id="notes"
                    name="notes"
                    placeholder="Ghi chú về đơn hàng, thời gian giao hàng..."
                >{{ old('notes') }}</textarea>
                @error('notes')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Đồng ý điều khoản -->
            <div class="form-group-full">
                <div class="checkbox-group">
                    <input
                        type="checkbox"
                        id="terms"
                        name="terms"
                        required
                    >
                    <label for="terms">
                        Tôi đồng ý với <a href="#" style="color: #667eea;">Điều khoản sử dụng</a> và
                        <a href="#" style="color: #667eea;">Chính sách bảo mật</a>
                        <span class="required">*</span>
                    </label>
                </div>
            </div>

            <!-- Submit button -->
            <div class="flex-d">
                <button type="submit" class="btn btn-primary btn-lg">
                     Đăng ký ngay
                </button>
            </div>
        </div>
    </form>

    <div class="register-footer">
        Đã có tài khoản? <a href="{{ route('customer.login') }}">Đăng nhập ngay</a>
    </div>
</div>
@endsection
