<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Paquete;

class PaqueteTest extends TestCase
{
    public function test_ModificarPesoUnoQueNoExiste()
    {
        $datosAInsertar = [
            "peso" => "50"
        ];

        $response = $this->put('/api/v1/Paquetes/12165454', $datosAInsertar);
        $response->assertStatus(404); 
    }

    public function test_ModificarPesoUnoQueExiste()
    {
        $datosAInsertar = [
            "peso" => "30",
        ];

        $response = $this->put('/api/v1/Paquetes/1', $datosAInsertar);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Se ha asignado el peso al Paquete 1 correctamente."
        ]);
    }

    public function test_InsertarPaqueteSinNada()
    {
        $response = $this->post('/api/v1/Paquetes');
        $response->assertStatus(404); 
    }

    public function test_InsertarPaquete()
    {
        $datosAInsertar = [
            "idArticulo" => "1",
            "cantidadArticulos" => "3",
            "peso" => "30"
        ];

        $response = $this->post('/api/v1/Paquetes', $datosAInsertar);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Paquete creado correctamente."
        ]);
    }

}
