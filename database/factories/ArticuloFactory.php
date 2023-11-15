<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticuloFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => "SeederArticulo",
            'anioCreacion' => $this->faker->numberBetween(2000, 2023),
        ];
    }
}
