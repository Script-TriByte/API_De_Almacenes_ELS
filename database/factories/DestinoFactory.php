<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DestinoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'direccion' => substr($this->faker->address(), 1, 40),
            'idDepartamento' => $this->faker->numberBetween(1, 19),
        ];
    }
}
