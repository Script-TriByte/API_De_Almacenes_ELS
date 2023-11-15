<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Paquete;
use App\Models\PaqueteLote;

class PaqueteLoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'idPaquete' => '1',
            'idLote' => '1',
        ];
    }
}
