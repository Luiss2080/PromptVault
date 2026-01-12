<?php

namespace App\Http\Requests\Prompt;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $prompt = $this->route('prompt');

        return $this->user()->can('update', $prompt);
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
            'mensaje_cambio' => 'nullable|string|max:255',
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
            'mensaje_cambio.max' => 'El mensaje de cambio no puede exceder 255 caracteres',
        ];
    }
}
