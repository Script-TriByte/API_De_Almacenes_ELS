<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class PaqueteTest extends TestCase
{
    public function test_ModificarPesoUnoQueNoExiste()
    {
        $datosAInsertar = [
            "peso" => "50"
        ];

        $user = User::first();
        $response = $this->actingAs($user, "api")->put('/api/v3/paquete/12165454', $datosAInsertar);
        $response->assertStatus(404); 
    }

    public function test_ModificarPesoUnoQueExiste()
    {
        $datosAInsertar = [
            "peso" => "30",
        ];

        $user = User::first();
        $response = $this->actingAs($user, "api")->put('/api/v3/paquete/1', $datosAInsertar);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Se ha asignado el peso al Paquete 1 correctamente."
        ]);
    }

    public function test_InsertarPaqueteSinNada()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->post('/api/v3/paquete');
        $response->assertStatus(401); 
    }

    public function test_InsertarPaquete()
    {
        $datosAInsertar = [
            "idArticulo" => "1",
            "cantidadArticulos" => "3",
            "peso" => "30",
            "codigoDeBulto" => "1"
        ];

        $user = User::first();
        $response = $this->actingAs($user, "api")->post('/api/v3/paquete', $datosAInsertar);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Paquete creado correctamente."
        ]);
    }

    public function test_AsignarUnPaqueteInexistenteAUnaEstanteria()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->post('/api/v3/paquete/10/1');
        $response->assertStatus(404); 
    }

    public function test_AsignarAEstanteria()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->post('/api/v3/paquete/1/1');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Se ha asignado a la estanteria correctamente."
        ]);
    }
}
