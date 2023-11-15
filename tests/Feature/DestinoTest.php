<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

use App\Models\Destino;

class DestinoTest extends TestCase
{
    public function test_CrearUnDestinoSinAutenticacion()
    {
        $datosAInsertar = [
            "direccion" => "Direccion de prueba",
            "idDepartamento" => "1"
        ];

        $response = $this->post('/api/v3/destinos');
        $response->assertStatus(401);
    }

    public function test_CrearUnDestino()
    {
        $datosAInsertar = [
            "direccion" => "Direccion de prueba",
            "idDepartamento" => "1"
        ];

        $user = User::first();
        $response = $this->actingAs($user, "api")->post('/api/v3/destinos');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Destino registrado correctamente."
        ]);
    }

    public function test_CrearUnDestinoSinDatos()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->post('/api/v3/destinos');
        $response->assertStatus(401);
    }
}
