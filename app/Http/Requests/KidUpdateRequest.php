<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KidUpdateRequest extends FormRequest
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
            'birthdate' => ['required', 'date'],
            'playroom_id' => ['required', 'integer', 'exists:playrooms,id'],
            'tutor_id' => ['required', 'integer', 'exists:tutors,id'],
        ];
    }
}
