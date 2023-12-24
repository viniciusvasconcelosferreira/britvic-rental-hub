<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
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
            'model' => 'sometimes|required',
            'brand' => 'sometimes|required',
            'year' => 'sometimes|required|integer|date_format:Y|digits:4|min:2000',
            'number_plate' => 'sometimes|required',
        ];
    }
}
