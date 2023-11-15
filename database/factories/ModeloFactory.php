<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ModeloFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => 'PlaceholderModelo',
            'anio' => $this->faker->numberBetween(2000, 2023),
        ];
    }
}
