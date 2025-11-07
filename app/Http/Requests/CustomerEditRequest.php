<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;

class CustomerEditRequest extends FormRequest
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
            // Thông tin bắt buộc
            'name' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:customers,email,'. $customerId,
            'password' => [
                'nullable',
                'confirmed'
            ],

            // Thông tin liên hệ
            'phone' => 'required|max:15|regex:/^[0-9]{10,11}$/',
            'address' => 'required|max:500',

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
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'phone.regex' => 'Số điện thoại không hợp lệ (10-11 số)',
            'phone.required' => 'Số điện thoại không được để trống',
            'shipping_phone.regex' => 'Số điện thoại giao hàng không hợp lệ',
        ];
    }
}
