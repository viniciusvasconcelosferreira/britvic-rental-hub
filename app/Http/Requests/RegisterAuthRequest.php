<?php

namespace App\Http\Requests;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $this->resolve('user')->id ?? null,
            'password' => 'sometimes|required|string|min:6',
            'cpf' => 'sometimes|required|string|size:11|cpf|unique:users,cpf,' . $this->resolve('user')->id ?? null,
            'type' => Rule::in(UserType::toValues()),
        ];
    }

    public function messages()
    {
        return [
            'type.in' => 'The type field must be one of the allowed values: ' . implode(', ', UserType::toValues()),
        ];
    }

    public function resolve()
    {
        if ($this->route('user')) {
            return User::find((int)$this->route('user'));
        }

        return new User();
    }
}
