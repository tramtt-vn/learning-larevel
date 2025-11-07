<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerEditRequest;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
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
    public function register(CustomerRequest $request)
    {
        // Validate input
        $validated = $request->validate();

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
    public function index()
    {
        $customers = Customer::paginate(20);
        return view('admin.customers.index', compact('customers'));
    }

    // Xóa customer
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customers.index')
            ->with('success', 'Đã xóa customer thành công');
    }
    public function profile(){
        $profiles = Auth::guard('customer')->user();
        return view("customer.profile", compact('profiles'));
    }
    public function edit(){
        $profiles = Auth::guard('customer')->user();
        return view("customer.edit", compact('profiles'));
    }
    public function update(CustomerEditRequest $request) {
        // Bước 1: Lấy dữ liệu đã được validate
        // CustomerEditRequest đã kiểm tra:
        $validated = $request->validated();
        // Đảm bảo user chỉ update chính profile của mình
        $customers = Auth::guard('customer')->user();
        DB::table('customers')
            ->where('id', $customers->id)
            ->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'shipping_phone' => $validated['shipping_phone'] ?? null,
                'shipping_address' => $validated['shipping_address'] ?? null,
            ]);
        // $customers->name = $validated['name'];
        // $customers->email = $validated['email'];
        // $customers->phone = $validated['phone'] ?? $customers->phone;
        // $customers->address = $validated['address'] ?? $customers->address;
        // $customers->shipping_phone = $validated['shipping_phone'] ?? null;
        // $customers->shipping_address = $validated['shipping_address'] ?? null;
        if($request->filled('password')) {
            //Tự động thêm salt ngẫu nhiên mã hóa
            $customers->password = Hash::make($validated['password']);
        }
        //Lưu vào database
        $customers->save();
        return redirect()->route('customer.profile')->with('success', 'Cập nhật thông tin thành công!');
    }
}

