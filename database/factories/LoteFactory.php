<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'idLote' => $this->$faker->randomNumber(9),
            'cantidadPaquetes' => $this->faker->numberBetween(1, 5),
            'idDestino' => '1',
            'idAlmacen' => '1',
        ];
    }
}
