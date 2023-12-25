<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statusOptions = ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled'];
        $status = $this->faker->randomElement($statusOptions);

        $date = $this->faker->dateTimeBetween(
            $status === 'cancelled' || $status === 'completed' ? '-1 month' : 'now',
            $status === 'cancelled' || $status === 'completed' ? 'now' : '+30 days'
        );

        $deletedAt = $status === 'cancelled' || $status === 'completed' ? now() : null;

        return [
            'user_id' => User::factory(),
            'vehicle_id' => Vehicle::factory(),
            'date' => $date,
            'status' => $status,
            'additional_information' => $this->faker->text(191),
            'deleted_at' => $deletedAt,
        ];
    }
}
