<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules() {
        return [
            'name' => 'required|string|max:50',
            'fullname' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:0|max:150',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }
    public function  messages()
    {
        return [
            'name.required' => 'Vui lòng nhập họ tên',
            'name.max' => 'Họ tên không được vượt quá 255 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ];
    }
}
