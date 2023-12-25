<?php

namespace App\Services;

use App\Enums\ReservationStatus;
use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class ReservationService
{
    public function createReservation(ReservationRequest $request)
    {
        $request->validated();

        return Reservation::create([
            'user_id' => $request->input('user_id') ?? auth()->id(),
            'vehicle_id' => $request->input('vehicle_id'),
            'date' => $request->input('date'),
            'status' => ReservationStatus::PENDING(),
            'additional_information' => $request->input('additional_information') ?? null,
        ]);
    }

    public function findReservation(int $id)
    {
        try {
            $user = Auth::user();
            return Reservation::where('user_id', $user->id)->with('user', 'vehicle')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function findReservationAdmin(int $id)
    {
        try {
            return Reservation::with('user', 'vehicle')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function updateReservation(ReservationRequest $request, $reservation)
    {
        $request->validated();

        $reservation->update($request->all());

        return $reservation;
    }

    public function deleteReservation(Reservation $reservation)
    {
        $reservation->status = ReservationStatus::CANCELLED();
        $reservation->save();

        $reservation->delete();

        return $reservation;
    }

    public function updateReservationStatus(Reservation $reservation, string $newStatus)
    {
        $reservation->status = $newStatus;
        if (strtoupper($newStatus) == ReservationStatus::CANCELLED() || strtoupper($newStatus) == ReservationStatus::COMPLETED()) {
            $reservation->deleted_at = now();
        }

        $reservation->save();

        return $reservation;
    }

}
