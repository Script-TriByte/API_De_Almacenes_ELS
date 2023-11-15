<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'docDeIdentidad' => '77777777',
            'nombre' => $this->faker->name(),
            'apellido' => $this->faker->lastname(),
            'telefono' => $this->faker->numberBetween(91000000, 97999999),
            'direccion' => substr($this->faker->address(), 1, 40),
        ];
    }
}
