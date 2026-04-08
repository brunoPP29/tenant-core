<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('put') || $this->isMethod('patch');

        return [
            'user_id'   => 'nullable|exists:users,id',
            'title'     => 'required|string|max:255',
            'url'       => 'required|url',
            'icon'      => 'nullable|string|max:255',
            'order'     => 'nullable|integer',
            'module_id' => $isUpdate ? 'required' : 'nullable',
        ];
    }
}
