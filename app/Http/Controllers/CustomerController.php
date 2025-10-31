<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class CustomerController extends Controller
{

    public function showLoginForm(){
        return view('customer.login');
    }
    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        ]);
        $credentials = $request->only('email','password');
        $remember = $request->filled('remember');
        if(Auth::guard('customer')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/products')->with(['success', 'Đăng nhập thành công']);
        }
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng',
        ])->withInput();
    }
    public function showRegisterForm() {
        return view('customer.register');
    }
    public function logout(Request $request) {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/customer/login')->with('status', 'Đăng xuất thành công');
    }
    public function register(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            // Thông tin bắt buộc
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => [
                'required',
                'confirmed',
                Password::min(6)
                    ->mixedCase()  // Chữ hoa và chữ thường
                    ->numbers()    // Có số
            ],

            // Thông tin liên hệ
            'phone' => 'nullable|string|max:15|regex:/^[0-9]{10,11}$/',
            'address' => 'nullable|string|max:500',

            // Thông tin giao hàng (không bắt buộc)
            'shipping_address' => 'nullable|string|max:500',
            'shipping_phone' => 'nullable|string|max:15|regex:/^[0-9]{10,11}$/',

            // Ghi chú
            'notes' => 'nullable|string|max:1000',
        ], [
            // Thông báo lỗi tiếng Việt
            'name.required' => 'Vui lòng nhập họ tên',
            'name.min' => 'Họ tên phải có ít nhất 2 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'phone.regex' => 'Số điện thoại không hợp lệ (10-11 số)',
            'shipping_phone.regex' => 'Số điện thoại giao hàng không hợp lệ',
        ]);

        // Tạo customer mới
        $customer = Customer::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'shipping_address' => $validated['shipping_address'] ?? null,
            'shipping_phone' => $validated['shipping_phone'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Tự động đăng nhập sau khi đăng ký
        Auth::guard('customer')->login($customer);

        // Redirect về trang products
        return redirect()->route('products.index')
            ->with('success', '✅ Đăng ký thành công! Chào mừng ' . $customer->name);
    }
}
