<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserJsonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return match ($this->method()) {
            'POST', 'PUT' => [
                'first_name' => ['required', 'min:2'],
                'last_name' => ['required', 'min:3'],
                'email' => ['bail', 'required', 'email', 'unique:users,email'],
                'password' => ['required', 'string'],
                'town' => ['sometimes', 'string', 'min:2', 'max:50'],
            ],
            'PATCH' => [
                'first_name' => ['sometimes', 'min:2'],
                'last_name' => ['sometimes', 'min:3'],
                'email' => ['bail', 'email', 'unique:users,email'],
                'password' => ['sometimes', 'min:5'],
                'town' => ['sometimes', 'string', 'min:2', 'max:50'],
            ],
            default => []
        };
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute Is required'
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'Email address',
            'first_name' => 'First name',
            'last_name' => 'Last name',
        ];
    }
}
