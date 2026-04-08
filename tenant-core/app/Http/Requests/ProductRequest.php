<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('put') || $this->isMethod('patch');

        return [
            'user_id'     => 'nullable|exists:users,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'nullable|numeric|min:0',
            'image'       => ($isUpdate ? 'nullable' : 'nullable') . '|image|mimes:jpeg,png,jpg,webp|max:5120',
            'module_id'   => $isUpdate ? 'required' : 'nullable',
        ];
    }
}
