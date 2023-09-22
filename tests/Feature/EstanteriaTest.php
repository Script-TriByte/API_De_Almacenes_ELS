<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EstanteriaTest extends TestCase
{
    public function test_CrearEstanteriaCorrectamente()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_CrearEstanteriaSinDatos()
    {
        $response = $this->get('/');

        $response->assertStatus(401);
    }
}
