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
            'email.unique' => 'Email đã được sử dụng',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
        ];
    }
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
?>
