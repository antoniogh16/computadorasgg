<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\equipos>
 */
class EquiposFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ram' => $this->faker->name,
            'procesador' => $this->faker->name,
            'graficos' => $this->faker->name,
            'monitor' => $this->faker->name,
            'hd' => $this->faker->name,
            'descripcion' => $this->faker->name,
            'marcas_id' => $this->faker->numberBetween(1,6)
        ];
    }
}
