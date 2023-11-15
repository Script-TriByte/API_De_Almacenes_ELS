<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaqueteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cantidadArticulos' => $this->faker->numberBetween(1, 20),
            'peso' => $this->faker->numberBetween(50, 150),
        ];
    }
}
