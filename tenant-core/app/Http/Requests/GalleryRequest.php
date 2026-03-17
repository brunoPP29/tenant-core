<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ajuste conforme sua política de acesso
    }

    public function rules(): array
    {
        return [
            'user_id'     => 'required|exists:users,id',
            'photo'       => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // Máx 5MB
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'alt_text'    => 'nullable|string|max:255',
        ];
    }
}
