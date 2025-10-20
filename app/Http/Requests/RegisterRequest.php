<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest {
    public function authorize() {
        return true;
    }
    public function rules() {
        return [
            'name' => 'required|string|max:50',
            'fullname' => 'nullable|string|max:100',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:0|max:150',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
    public function  messages()
    {
        return [
            'name.required' => 'Vui lòng nhập họ tên',
            'name.max' => 'Họ tên không được vượt quá 255 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'email.max' => 'Email không được vượt quá 255 ký tự',
        ];
    }
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
?>
