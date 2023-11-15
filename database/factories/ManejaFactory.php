<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ManejaFactory extends Factory
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
            'idVehiculo' => '1'
        ];
    }
}
