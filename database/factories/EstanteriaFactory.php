<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EstanteriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'peso' => '400',
            'apiladoMaximo' => '30',
            'idAlmacen' => '1',
        ];
    }
}
