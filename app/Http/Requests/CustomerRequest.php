<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $customerId = auth()->guard('customer')->id();
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email',
            'password' => 'required|min:6|confirmed', // ← BẮT BUỘC
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',

            // Thông tin giao hàng (không bắt buộc)
            'shipping_address' => 'nullable|max:500',
            'shipping_phone' => 'nullable|max:15|regex:/^[0-9]{10,11}$/',

            // Ghi chú
            'notes' => 'nullable|string|max:1000',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập họ tên',
            'name.min' => 'Họ tên phải có ít nhất 2 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.max' => 'Email phải nhỏ hơn 255 ký tự',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'phone.regex' => 'Số điện thoại không hợp lệ (10-11 số)',
            'shipping_phone.regex' => 'Số điện thoại giao hàng không hợp lệ',
        ];
    }
}
