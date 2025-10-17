<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Auth\Events\Registered;
// use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function __construct()
    {

    }
    public function showLoginForm(){
        return view('auth.login');
    }
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if(Auth::attempt($credentials, $request->filled('remember'))){
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Đăng nhập thành công');
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
    public function register(RegisterRequest $request){
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        event(new Registered($user));
        Auth::login($user);
        $user->notify(new CustomVerifyEmail());
        return redirect()->route('dashboard')->with('success', "Đăng ký thành công");
    }
}
