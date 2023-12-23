<?php

namespace Database\Factories;

use App\Models\User;
use Faker\Provider\Fakecar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new Fakecar($this->faker));
        $vehicle = $this->faker->vehicleArray();

        return [
            'model' => $vehicle['model'],
            'brand' => $vehicle['brand'],
            'year' => $this->faker->year,
            'number_plate' => $this->faker->unique()->regexify('[A-Z]{3}-[0-9]{4}'),
            'user_id' => User::factory(),
        ];
    }
}
