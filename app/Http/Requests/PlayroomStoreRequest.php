<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayroomStoreRequest extends FormRequest
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
            'address' => ['required', 'string'],
            // 'phone' => ['required', 'string'],
            'email' => ['required', 'email'],
            // 'password' => ['required', 'password'],

            'phones' => ['sometimes', 'array'],
            'phones.*.number' => ['required', 'string', 'max:20'],
            'phones.*.label' => ['nullable', 'string', 'max:50'],

            'street' => ['required', 'string', 'max:255'],
            'municipality' => ['required', 'string', 'max:255'],
            'locality' => ['required', 'string', 'max:255'],
            'zip_code' => ['required', 'string', 'max:10'],
            'country' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
        ];
    }
}
