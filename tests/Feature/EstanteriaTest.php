<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

use App\Models\Estanteria;

class EstanteriaTest extends TestCase
{
    public function test_CrearEstanteriaCorrectamente()
    {
        $datosAInsertar = [
            'peso' => '320',
            'apiladoMaximo' => '20',
            'idAlmacen' => '1'
        ];

        $user = User::first();
        $response = $this->actingAs($user, "api")->post('/api/v3/estanteria', $datosAInsertar);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Estanteria creada correctamente."
        ]);
    }

    public function test_CrearEstanteriaSinDatos()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->post('/api/v3/estanteria');
        $response->assertStatus(401);
    }

    public function test_EliminarEstanteriaExistente()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->delete('/api/v3/estanteria/1');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Estanteria eliminada correctamente."
        ]);
    }

    public function test_EliminarEstanteriaInexistente()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->delete('/api/v3/estanteria/9');
        $response->assertStatus(404);
    }
}
