<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = $this->message
            ? ['message' => $this->message]
            : [];

        $response['data'] = [
            'id' => $this->id,
            'model' => $this->model,
            'brand' => $this->brand,
            'year' => $this->year,
            'number_plate' => $this->number_plate
        ];

        return $response;
    }
}
