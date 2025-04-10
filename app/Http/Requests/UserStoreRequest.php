<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            // Campos básicos de user
            'name' => ['required', 'string', 'max:255'],
            'firstSurname' => ['required', 'string', 'max:255'],
            'secondSurname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'DNI' => ['required', 'string', 'max:20', 'unique:users,DNI'],
            'password' => ['required', 'string', 'min:8'],

            // Campos opcionales
            'email_verified_at' => ['nullable', 'date'],
            'remember_token' => ['nullable', 'string', 'max:100'],

            // Campos de address
            'municipality' => ['required', 'string', 'max:100'],
            'locality' => ['required', 'string', 'max:100'],
            'zip_code' => ['required', 'string', 'max:10'],

            // Campos de phones
            'phones' => ['required', 'array'], // O 'nullable', si no siempre mandas teléfonos
            'phones.*.phone' => ['required', 'string', 'max:20'],
            'phones.*.name' => ['required', 'string', 'max:255'],
            'phones.*.firstSurname' => ['required', 'string', 'max:255'],
            'phones.*.secondSurname' => ['nullable', 'string', 'max:255'],
            'phones.*.emergencyContact' => ['nullable', 'boolean'],
        ];
    }
}
