<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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

        $response = $this->post('/api/v2/estanterias', $datosAInsertar);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Estanteria creada correctamente."
        ]);

        Estanteria::where('apiladoMaximo', '320')->delete();
    }

    public function test_CrearEstanteriaSinDatos()
    {
        $response = $this->post('/api/v2/estanterias');
        $response->assertStatus(401);
    }

    public function test_EliminarEstanteriaExistente()
    {
        $response = $this->delete('/api/v2/estanterias/1');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Estanteria eliminada correctamente."
        ]);
        
        Estanteria::withTrashed()->where("identificador", 1)->restore();
    }

    public function test_EliminarEstanteriaInexistente()
    {
        $response = $this->delete('/api/v2/estanterias/9999');
        $response->assertStatus(404);
    }
}
