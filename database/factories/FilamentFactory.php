<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Filament>
 */
class FilamentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->name(),
            "material" => $this->faker->name(),
            "type" => $this->faker->name(),
            "marca" => $this->faker->name(),
            "description" => $this->faker->paragraph(),
        ];
    }
}
