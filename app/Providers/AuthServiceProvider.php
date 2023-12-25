<?php

namespace App\Providers;

use App\Policies\ReservationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('access-admin-reservation', [ReservationPolicy::class, 'accessAdminReservation']);
        Gate::define('access-customer-reservation', [ReservationPolicy::class, 'accessCustomerReservation']);
    }
}
