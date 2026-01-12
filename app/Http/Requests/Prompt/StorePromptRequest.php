<?php

namespace App\Http\Requests\Prompt;

use App\Models\Prompt;
use Illuminate\Foundation\Http\FormRequest;

class StorePromptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Prompt::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:150',
            'contenido' => 'required|string',
            'descripcion' => 'nullable|string',
            'visibilidad' => 'in:privado,publico,enlace',
            'etiquetas' => 'array',
            'etiquetas.*' => 'exists:etiquetas,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es obligatorio',
            'titulo.max' => 'El título no puede exceder 150 caracteres',
            'contenido.required' => 'El contenido del prompt es obligatorio',
            'visibilidad.in' => 'La visibilidad debe ser: privado, publico o enlace',
        ];
    }
}
