<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VehiculoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'matricula' => 'PLH XXXX',
            'capacidad' => '70',
            'pesoMaximo' => '500',
            'modelo' => '1'
        ];
    }
}
