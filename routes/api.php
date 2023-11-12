<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\EstanteriaController;

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

    Route::delete('/Lotes/{idLote}',
        [LoteController::class, "EliminarLote"]
    );
});

Route::prefix('v2')->group(function ()
{
    Route::post('/paquetes',
        [PaqueteController::class, "CrearPaquete"]
    );

    Route::put('/paquetes/{idPaquete}',
        [PaqueteController::class,"AsignarPeso"]
    );

    Route::put('/paquetes/{idPaquete}/{idEstanteria}',
        [PaqueteController::class,"AsignarAEstanteria"]
    );

    Route::post('/lotes',
        [LoteController::class, "CrearLote"]
    );

    Route::delete('/lotes/{idLote}',
        [LoteController::class, "EliminarLote"]
    );

    Route::put('/lotes/{idLote}/{documentoDeIdentidad}',
        [LoteController::class,"AsignarLoteAChofer"]
    );

    Route::post('/estanterias',
        [EstanteriaController::class, "Crear"]
    );

    Route::delete('/estanterias/{idEstanteria}',
        [EstanteriaController::class, "Eliminar"]
    );
});

Route::prefix('v3')->group(function ()
{
    Route::get('/tipoarticulo',
        [ArticuloController::class, "ObtenerTiposDeArticulo"]
    );

    Route::post('/articulos',
        [ArticuloController::class, "Crear"]
    );

    Route::put('/articulos/{idArticulo}',
        [ArticuloController::class, "Modificar"]
    );

    Route::delete('/articulos/{idArticulo}',
        [ArticuloController::class, "Eliminar"]
    );

    Route::post('/paquete',
        [PaqueteController::class, "CrearPaquete"]
    );

    Route::put('/paquete/{idPaquete}',
        [PaqueteController::class,"AsignarPeso"]
    );

    Route::post('/paquete/{idPaquete}/{idEstanteria}',
        [PaqueteController::class,"AsignarAEstanteria"]
    );

    Route::post('/lote',
        [LoteController::class, "CrearLote"]
    );

    Route::delete('/lote/{idLote}',
        [LoteController::class, "EliminarLote"]
    );

    Route::put('/lote/{idLote}/{documentoDeIdentidad}',
        [LoteController::class,"AsignarLoteAChofer"]
    );

    Route::post('/estanteria',
        [EstanteriaController::class, "Crear"]
    );

    Route::delete('/estanteria/{idEstanteria}',
        [EstanteriaController::class, "Eliminar"]
    );
});