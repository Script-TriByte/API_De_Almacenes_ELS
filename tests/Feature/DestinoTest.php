<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Destino;

class DestinoTest extends TestCase
{
    public function test_CrearUnDestino()
    {
        $datosAInsertar = [
            "direccion" => "Direccion de prueba",
            "idDepartamento" => "1"
        ];

        $response = $this->post('/api/v2/destinos');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Destino registrado correctamente."
        ]);

        Destino::where('direccion', 'Direccion de prueba')->delete();
    }

    public function test_CrearUnDestinoSinDatos()
    {
        $response = $this->post('/api/v2/destinos');
        $response->assertStatus(401);
    }
}
