<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Printer>
 */
class PrinterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->word(), // Nombre de la impresora
            "model" => $this->faker->word(), // Modelo de la impresora
            "type" => $this->faker->randomElement(['FDM', 'SLA', 'Resina']), // Tipo de impresora
            "brand" => $this->faker->company(), // Marca de la impresora
            "print_volume" => $this->faker->randomElement(['220x220x250 mm', '300x300x400 mm', '130x80x165 mm']), // Volumen de impresión
            "status" => $this->faker->randomElement(['Available', 'On Use', 'Not Available']), // Estado de la impresora
            "description" => $this->faker->paragraph(), // Descripción de la impresora
        ];
    }
}