<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
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
            /* ────────────  USUARIO  ──────────── */
            'name' => ['required', 'string', 'max:255'],
            'firstSurname' => ['required', 'string', 'max:255'],
            'secondSurname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'DNI' => ['required', 'string', 'max:20', 'unique:users,DNI'],
            'password' => ['required', 'string', 'min:8'],

            /* ────────────  EMPLOYEE  ──────────── */
            'position' => ['required', 'string', 'max:100'],
            'salary' => ['required', 'numeric', 'min:0'],
            'bank_account' => ['nullable', 'string', 'max:34'], // IBAN, 34 caracteres

            /* ────────────  ADDRESS (1 : 1)  ──────────── */
            'address' => ['sometimes', 'array'],
            'address.street' => ['required_with:address', 'string', 'max:255'],
            'address.municipality' => ['nullable', 'string', 'max:100'],
            'address.locality' => ['nullable', 'string', 'max:100'],
            'address.zip_code' => ['nullable', 'string', 'max:10'],
            'address.country' => ['nullable', 'string', 'max:100'],
            'address.province' => ['nullable', 'string', 'max:100'],

            /* ────────────  PHONES (1 : N)  ──────────── */

            'phones' => ['required', 'array'], // O 'nullable', si no siempre mandas teléfonos
            'phones.*.phone' => ['required', 'string', 'max:20'],
            'phones.*.name' => ['required', 'string', 'max:255'],
            'phones.*.firstSurname' => ['required', 'string', 'max:255'],
            'phones.*.secondSurname' => ['nullable', 'string', 'max:255'],
            'phones.*.emergencyContact' => ['nullable', 'boolean'],
        ];
    }
}
