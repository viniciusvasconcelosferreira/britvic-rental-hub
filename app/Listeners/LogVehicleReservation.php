<?php

namespace App\Listeners;

use App\Events\VehicleReserved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogVehicleReservation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(VehicleReserved $event): void
    {
        $userId = $event->user->id;
        $vehicleId = $event->vehicle->id;

        Log::info("Vehicle reserved - User ID: $userId, Vehicle ID: $vehicleId");
    }
}
