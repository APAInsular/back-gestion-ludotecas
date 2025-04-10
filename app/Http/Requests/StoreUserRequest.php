<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'            => 'required|string|max:255',
            'firstSurname'    => 'required|string|max:255',
            'secondSurname'   => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'phone'           => 'required|string',  // o 'required|numeric' si quisieras numérico
            'DNI'             => 'required|string|max:20|unique:users,DNI',
            'password'        => 'required|string|min:8',

            // Campos de address
            'municipality'    => 'required|string|max:100',
            'locality'        => 'required|string|max:100',
            'zip_code'        => 'required|string|max:10',

            // Campos de phone
            'primary_phone'   => 'required|string|max:20',
            'backup_phone'    => 'nullable|string|max:20'
        ];
    }
}
