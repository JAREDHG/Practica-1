<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title' => 'required|string|min:5|max:200|unique:posts', // [cite: 189]
            'content' => 'required|string|min:50', // [cite: 190]
            'category_id' => 'required|exists:categories,id', // [cite: 191]
            'tags' => 'array|min:1|max:5', // [cite: 192, 193]
            'tags.*' => 'exists:tags,id', // [cite: 194]
            'published_at' => 'nullable|date|after:today', // [cite: 195]
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'El titulo es obligatorio', // [cite: 198, 199]
            'title.min' => 'El titulo debe tener al menos 5 caracteres', // [cite: 200, 201]
            'content.min' => 'El contenido debe tener al menos 50 caracteres', // [cite: 202, 203]
            'tags.min' => 'Debes seleccionar al menos 1 etiqueta', // [cite: 204]
        ];
    }
}