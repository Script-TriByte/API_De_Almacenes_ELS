<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Lote;

class LoteTest extends TestCase
{
    public function test_InsertarLoteSinDatos()
    {
        $response = $this->post('/api/v2/lotes');
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

        $response = $this->post('/api/v2/lotes', $datosAInsertar);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Lote creado correctamente."
        ]);
    }

    public function test_EliminarUnLoteQueExiste()
    {
        $response = $this->delete('/api/v2/lotes/1');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "El lote con el id 1 fue eliminado correctamente.."
        ]);
    }

    public function test_EliminarUnLoteQueNoExiste()
    {
        $response = $this->delete('/api/v2/lotes/9999');
        $response->assertStatus(401); 
    }

    public function test_AsignarUnLoteAUnChoferCorrectamente()
    {
        $response = $this->put('/api/v2/lotes/1/77777777');
        $response->assertStatus(200); 
        $response->assertJsonFragment([
            "mensaje" => "Se ha asignado el lote al chofer con la CI 77777777 correctamente."
        ]);
    }

    public function test_AsignarUnLoteAUnChoferConDatosInexistentes()
    {
        $response = $this->put('/api/v2/lotes/9999/99999999');
        $response->assertStatus(401); 
    }
}
