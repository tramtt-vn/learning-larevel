<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive,draft,out_of_stock',
            'image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images.*' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm không được để trống',
            'price.required' => 'Giá sản phẩm không được để trống',
            'price.numeric' => 'Giá sản phẩm phải là số',
            'image.image' => 'File phải là ảnh',
            'stock.integer' => 'Số lượng sản phẩm phải là số',
            'stock.required' => 'Số lượng sản phẩm không được để trống',
            'image.max' => 'Ảnh không được vượt quá 2MB',
        ];
    }
}
