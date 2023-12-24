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
        return [
            "id" => $this->id,
            "model" => $this->model,
            "brand" => $this->brand,
            "year" => $this->year,
            "number_plate" => $this->number_plate,
            "user" => new UserResource($this->whenLoaded('user')),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }

    public function additional(array $data)
    {
        return parent::additional($data);
    }
}
