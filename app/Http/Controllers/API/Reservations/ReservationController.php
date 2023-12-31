<?php

namespace App\Http\Controllers\API\Reservations;


use App\Events\VehicleReserved;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\UpdateReservationStatusRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Vehicle;
use App\Services\ReservationService;

class ReservationController extends Controller
{

    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::where('user_id', auth()->user()->id)->with('user')->with('vehicle')->paginate(8);
        return ReservationResource::collection($reservations);
    }

    public function indexAll()
    {
        $reservations = Reservation::with('user')->with('vehicle')->orderBy('id', 'asc')->paginate(8);
        return ReservationResource::collection($reservations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationRequest $request)
    {
        $reservation = $this->reservationService->createReservation($request);
        event(new VehicleReserved(User::find($reservation->user_id), Vehicle::find($reservation->vehicle_id)));
        $reservationResource = new ReservationResource($reservation);
        return $reservationResource->additional([
            'message' => 'Reservation created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $reservation = $this->reservationService->findReservation($id);

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        return new ReservationResource($reservation);
    }

    public function showAll(int $id)
    {
        $reservation = $this->reservationService->findReservationAdmin($id);

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        return new ReservationResource($reservation);
    }

    public function showAvailability(int $vehicle, int $month, int $year)
    {
        $reservation = $this->reservationService->findAvailability($vehicle, $month, $year);

        return $reservation;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservationRequest $request, int $id)
    {
        $reservation = $this->reservationService->findReservation($id);

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $reservation = $this->reservationService->updateReservation($request, $reservation);

        $reservationResource = new ReservationResource($reservation);

        return $reservationResource->additional([
            'message' => 'Reservation updated successfully'
        ]);
    }

    public function updateAll(ReservationRequest $request, int $id)
    {
        $reservation = $this->reservationService->findReservationAdmin($id);

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $reservation = $this->reservationService->updateReservation($request, $reservation);

        $reservationResource = new ReservationResource($reservation);

        return $reservationResource->additional([
            'message' => 'Reservation updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $reservationExist = $this->reservationService->findReservation($id);

        if (!$reservationExist) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $reservation = $this->reservationService->deleteReservation($reservationExist);

        $reservationResource = new ReservationResource($reservation);

        return $reservationResource->additional([
            'message' => 'Reservation deleted successfully'
        ]);
    }

    public function updateStatus(UpdateReservationStatusRequest $request, int $id)
    {
        $reservationExist = $this->reservationService->findReservationAdmin($id);

        if (!$reservationExist) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $reservation = $this->reservationService->updateReservationStatus($reservationExist, $request->input('status'));

        $reservationResource = new ReservationResource($reservation);

        return $reservationResource->additional([
            'message' => 'Reservation status updated successfully'
        ]);
    }
}
