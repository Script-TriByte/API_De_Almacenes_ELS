<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\LoteController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function ()
{
    Route::post('/Paquetes',
        [PaqueteController::class, "CrearPaquete"]
    );

    Route::put('/Paquetes/{idPaquete}',
        [PaqueteController::class,"AsignarPeso"]
    );

    Route::post('/Lotes',
        [LoteController::class, "CrearLote"]
    );
});