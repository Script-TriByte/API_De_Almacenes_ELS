<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Lote;

class LoteTest extends TestCase
{
    public function test_InsertarLoteSinNada()
    {
        $response = $this->post('/api/v1/Lotes');
        $response->assertStatus(404); 
    }

    public function test_InsertarLote()
    {
        $datosAInsertar = [
            "idPaquete" => "1",
            "cantidadPaquetes" => "4"
        ];

        $response = $this->post('/api/v1/Lotes', $datosAInsertar);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Lote creado correctamente."
        ]);
    }
}
