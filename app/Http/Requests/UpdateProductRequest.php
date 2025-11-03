<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'slug' => ['nullable','string','max:255', Rule::unique('products','slug')->ignore($this->route('product'))],
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'thumbnail' => 'nullable|image|max:2048',
            'short_description' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ];
    }
}
