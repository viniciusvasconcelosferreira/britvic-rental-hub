<?php

namespace App\Http\Requests;

use App\Enums\ReservationStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationStatusRequest extends FormRequest
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
            'status' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $validStatuses = implode(', ', ReservationStatus::toArray());

                    if (!in_array(strtoupper($value), ReservationStatus::toArray())) {
                        $fail("The '{$value}' status is not valid. The available statuses are: {$validStatuses}.");
                    }
                },
            ],
        ];
    }
}
