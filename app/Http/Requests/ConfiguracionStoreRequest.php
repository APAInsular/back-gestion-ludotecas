<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfiguracionStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'idioma' => ['required', 'string'],
            'notificaciones' => ['required'],
            'usuario_id' => ['required', 'integer', 'exists:usuarios,id'],
        ];
    }
}
