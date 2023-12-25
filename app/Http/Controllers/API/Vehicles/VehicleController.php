<?php

namespace App\Http\Controllers\API\Vehicles;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use App\Services\VehicleService;

class VehicleController extends Controller
{
    protected $vehicleService;

    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::with('user')->paginate(8);
        return VehicleResource::collection($vehicles);
    }

    public function indexAll()
    {
        $vehicles = Vehicle::all(['id', 'model', 'brand', 'number_plate']);
        return VehicleResource::collection($vehicles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VehicleRequest $request)
    {
        $vehicle = $this->vehicleService->createVehicle($request);
        $vehicleResource = new VehicleResource($vehicle);
        return $vehicleResource->additional([
            'message' => 'Vehicle created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $vehicle = $this->vehicleService->findVehicle($id);

        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        return new VehicleResource($vehicle);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VehicleRequest $request, int $id)
    {
        $vehicle = $this->vehicleService->findVehicle($id);

        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        $vehicle = $this->vehicleService->updateVehicle($request, $vehicle);

        $vehicleResource = new VehicleResource($vehicle);

        return $vehicleResource->additional([
            'message' => 'Vehicle updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vehicleExist = $this->vehicleService->findVehicle($id);

        if (!$vehicleExist) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        $vehicle = $this->vehicleService->deleteVehicle($vehicleExist);

        $vehicleResource = new VehicleResource($vehicle);

        return $vehicleResource->additional([
            'message' => 'Vehicle deleted successfully'
        ]);
    }
}
