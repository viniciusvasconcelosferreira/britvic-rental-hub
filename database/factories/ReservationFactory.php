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
        $status = $this->faker->randomElement(['pending', 'confirmed', 'in_progress', 'completed', 'cancelled']);
        $date = $status == 'cancelled' ? $this->faker->dateTimeBetween('-1 month', 'now') : $this->faker->dateTimeBetween('now', '+30 days');

        return [
            'user_id' => User::factory(),
            'vehicle_id' => Vehicle::factory(),
            'date' => $date,
            'status' => $status,
            'additional_information' => $this->faker->text(191),
            'deleted_at' => $status == 'cancelled' ? now() : null,
        ];
    }
}
