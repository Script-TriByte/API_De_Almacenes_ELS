<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Lote;
use App\Models\VehiculoLoteDestino;

class VehiculoLoteDestinoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'idLote' => '1',
            'fechaEstimada' => $this->faker->date(),
            'horaEstimada' => $this->faker->time(),
            'docDeIdentidad' => '77777777',
        ];
    }
}
