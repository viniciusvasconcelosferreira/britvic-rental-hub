<?php

namespace App\Policies;

use App\Enums\UserType;
use App\Models\User;

class ReservationPolicy
{
    public function accessAdminReservation(User $user)
    {
        return strtoupper($user->type) == UserType::EMPLOYEE();
    }

    public function accessCustomerReservation(User $user)
    {
        return strtoupper($user->type) == UserType::CLIENT();
    }
}
