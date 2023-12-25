<?php

namespace App\Http\Requests;

use App\Enums\ReservationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReservationRequest extends FormRequest
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
            'date' => [
                'sometimes',
                'required',
                'date_format:Y-m-d',
                'after_or_equal:today',
                Rule::unique('reservations')->where(function ($query) {
                    $query
                        ->where('date', $this->input('date'))
                        ->where('vehicle_id', $this->input('vehicle_id'))
                        ->whereNotIn('status', [ReservationStatus::CANCELLED(), ReservationStatus::COMPLETED()]);
                })
            ],
            'vehicle_id' => 'sometimes|required|exists:vehicles,id',
            'additional_information' => 'string|max:191|nullable'
        ];
    }
}
