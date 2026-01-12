<?php

namespace App\Http\Requests\Prompt;

use Illuminate\Foundation\Http\FormRequest;

class CompartirPromptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $prompt = $this->route('prompt');

        return $this->user()->can('share', $prompt);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'nivel_acceso' => 'required|in:lector,comentador,editor',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'El email es obligatorio',
            'email.email' => 'Debe ser un email válido',
            'email.exists' => 'No existe un usuario con ese email',
            'nivel_acceso.required' => 'Debe seleccionar un nivel de acceso',
            'nivel_acceso.in' => 'El nivel debe ser: lector, comentador o editor',
        ];
    }
}
