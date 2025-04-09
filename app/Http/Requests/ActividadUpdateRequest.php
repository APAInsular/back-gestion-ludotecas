<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActividadUpdateRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'date' => ['required'],
            'hour' => ['required'],
            'description' => ['required', 'string'],
            'servicio_id' => ['required', 'integer', 'exists:servicios,id'],
        ];
    }
}
