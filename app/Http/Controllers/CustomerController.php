<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('status', 'Đăng xuất thành công');
    }
    public function showRegisterForm() {
        return view('auth.register');
    }
    // public function register(RegisterRequest $request){
    //     $data = $request->validated();
    //     $data['password'] = Hash::make($data['password']);
    //     $data['verification_token'] = Str::random(64);
    //     $user = User::create($data);
    //     event(new Registered($user));
    //     return redirect()->route('auth.verify-email', compact('user'))
    //     ->with('success', 'Đăng ký thành công. Vui lòng kiểm tra email để xác thực.')->with(['email'=>  $user->email, 'id' => $user->id,'resend' => "resend"]);
    // }
}
