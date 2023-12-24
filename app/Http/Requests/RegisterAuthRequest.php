<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAuthRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email',
            'password' => 'sometimes|required|string|min:6',
            'cpf' => 'sometimes|required|string|size:11|cpf|unique:users,cpf',
            'groups' => ['string', 'regex:/^(employee,client|employee|client)$/']
        ];
    }

    public function messages()
    {
        return [
            'groups.regex' => 'The groups field must be a valid string with the values "employee", "client" or "employee,client".',
        ];
    }
}
