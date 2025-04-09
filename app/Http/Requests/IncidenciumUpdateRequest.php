<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncidenciumUpdateRequest extends FormRequest
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
            'descripcion' => ['required', 'string'],
            'fecha' => ['required'],
            'empleado_id' => ['required', 'integer', 'exists:empleados,id'],
        ];
    }
}
