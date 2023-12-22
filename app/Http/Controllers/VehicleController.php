<?php

namespace App\Http\Controllers;

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
        $vehicles = Vehicle::all();

        return VehicleResource::collection($vehicles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VehicleRequest $request)
    {
        $vehicle = $this->vehicleService->createVehicle($request);
        $vehicleResource = new VehicleResource($vehicle);
        $vehicleResource->message = 'Vehicle created successfully';
        return $vehicleResource;
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        $vehicleResource->message = 'Vehicle updated successfully';

        return $vehicleResource;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vehicle = $this->vehicleService->findVehicle($id);

        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        $invoice = $this->vehicleService->deleteVehicle($vehicle);

        $vehicleResource = new VehicleResource($invoice);
        $vehicleResource->message = 'Vehicle deleted successfully';

        return $vehicleResource;
    }
}