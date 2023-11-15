<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ArticuloTest extends TestCase
{
    public function test_CrearUnArticuloConDatosCorrectos()
    {
        $datosAInsertar = [
            "nombre" => "Placeholder",
            "anioCreacion" => "2004",
            "tipo" => "A"
        ];
        $user = User::first();
        $response = $this->actingAs($user, "api")->post('/api/v3/articulo', $datosAInsertar);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Articulo registrado correctamente."
        ]);
    }

    public function test_CrearUnArticuloConDatosErroneos()
    {
        $datosAInsertar = [
            "nombre" => "P",
            "anioCreacion" => "210480",
            "tipo" => "Hola"
        ];
        $user = User::first();
        $response = $this->actingAs($user, "api")->post('/api/v3/articulo', $datosAInsertar);
        $response->assertStatus(401);
    }

    public function test_ModificarUnArticuloExistente()
    {
        $datosAInsertar = [
            "nombre" => "NuevoNombre",
        ];
        $user = User::first();
        $response = $this->actingAs($user, "api")->put('/api/v3/articulo/1', $datosAInsertar);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Articulo modificado correctamente."
        ]);
    }

    public function test_ModificarUnArticuloInexistente()
    {
        $datosAInsertar = [
            "nombre" => "NuevoNombre",
        ];
        $user = User::first();
        $response = $this->actingAs($user, "api")->put('/api/v3/articulo/99', $datosAInsertar);
        $response->assertStatus(404);
        $response->assertJsonFragment([
            "mensaje" => "Articulo inexistente."
        ]);
    }

    public function test_ObtenerTipoDeArticuloDeUnoExistente()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->get('/api/v3/tipoarticulo/1');
        $response->assertStatus(200);
    }

    public function test_ObtenerTipoDeArticuloDeUnoInexistente()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->get('/api/v3/tipoarticulo/99');
        $response->assertStatus(404);
        $response->assertJsonFragment([
            "mensaje" => "Articulo inexistente."
        ]);
    }

    public function test_EliminarUnArticuloExistente()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->delete('/api/v3/articulo/1');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Articulo eliminado correctamente."
        ]);
    }

    public function test_EliminarUnArticuloInexistente()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->delete('/api/v3/articulo/999');
        $response->assertStatus(404);
        $response->assertJsonFragment([
            "mensaje" => "Articulo inexistente."
        ]);
    }
}
