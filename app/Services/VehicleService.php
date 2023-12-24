<?php

namespace App\Services;

use App\Http\Requests\VehicleRequest;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VehicleService
{
    public function createVehicle(VehicleRequest $request)
    {
        $request->validated();

        return Vehicle::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'year' => $request->input('year'),
            'number_plate' => $request->input('number_plate'),
            'user_id' => auth()->id(),
        ]);
    }

    public function findVehicle($id)
    {
        try {
            return Vehicle::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function updateVehicle(VehicleRequest $request, Vehicle $vehicle)
    {
        $request->validated();

        $vehicle->update($request->all());

        return $vehicle;
    }

    public function deleteVehicle(Vehicle $vehicle)
    {
        $vehicle->delete();

        return $vehicle;
    }
}
