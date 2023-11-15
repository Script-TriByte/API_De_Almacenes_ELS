<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CodigoDeBultoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipo' => 'A',
            'maximoApilado' => '50',
        ];
    }
}
