<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();
        \App\Models\Usuario::factory(1)->create();
        \App\Models\Chofer::factory(1)->create();
        \App\Models\Destino::factory(1)->create();
        \App\Models\Articulo::factory(1)->create();
        \App\Models\Paquete::factory(1)->create();
        \App\Models\ArticuloPaquete::factory(1)->create();
        \App\Models\Almacen::factory(1)->create();
        \App\Models\Estanteria::factory(1)->create();
        \App\Models\Modelo::factory(1)->create();
        \App\Models\Vehiculo::factory(1)->create();
        \App\Models\Maneja::factory(1)->create();
        \App\Models\Lote::factory(1)->create();
        \App\Models\PaqueteLote::factory(1)->create();
        \App\Models\VehiculoLoteDestino::factory(1)->create();
    }
}
