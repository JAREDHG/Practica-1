<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostWithAttachmentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:5|max:200',
            'content' => 'required|string|min:50',
            'category_id' => 'required|exists:categories,id',
            'attachments' => 'array|max:5', // Máximo 5 archivos por post
            'attachments.*' => 'file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx' // Límite de 5MB y extensiones seguras
        ];
    }

    public function messages(): array
    {
        return [
            'attachments.max' => 'No puedes subir más de 5 archivos',
            'attachments.*.max' => 'Cada archivo no debe superar 5MB',
            'attachments.*.mimes' => 'Solo se aceptan JPG, PNG, PDF, DOC, DOCX',
        ];
    }
}