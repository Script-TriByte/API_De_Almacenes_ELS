<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoteTest extends TestCase
{
    public function test_InsertarLoteSinDatos()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->post('/api/v3/lote');
        $response->assertStatus(401); 
    }

    public function test_InsertarLote()
    {
        $datosAInsertar = [
            "idPaquete" => "1",
            "cantidadPaquetes" => "4",
            "idDestino" => "1",
            "idAlmacen" => "1"
        ];

        $user = User::first();
        $response = $this->actingAs($user, "api")->post('/api/v3/lote', $datosAInsertar);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Lote creado correctamente."
        ]);
    }

    public function test_EliminarUnLoteQueExiste()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->delete('/api/v3/lote/1');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "El lote con el id 1 fue eliminado correctamente."
        ]);
    }

    public function test_EliminarUnLoteQueNoExiste()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->delete('/api/v3/lote/9999');
        $response->assertStatus(404); 
    }

    public function test_AsignarUnLoteAUnChoferCorrectamente()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->put('/api/v3/lote/1/77777777');
        $response->assertStatus(200); 
        $response->assertJsonFragment([
            "mensaje" => "Se ha asignado el lote al chofer con la CI 77777777 correctamente."
        ]);
    }

    public function test_AsignarUnLoteAUnChoferConDatosInexistentes()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->put('/api/v3/lote/9999/99999999');
        $response->assertStatus(401); 
    }
}
