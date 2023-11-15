<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TipoArticuloController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\EstanteriaController;
use App\Http\Controllers\DestinoController;

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

Route::prefix('v3')->middleware("auth:api")->group(function ()
{
    Route::post('/destino',
        [DestinoController::class, "Crear"]
    );

    Route::post('/tipoarticulo',
        [TipoArticuloController::class, "Crear"]
    );

    Route::get('/tipoarticulo/{idArticulo}',
        [ArticuloController::class, "ObtenerTiposDeArticulo"]
    );

    Route::get('/articulos',
        [ArticuloController::Class, "ListarTodos"]
    );

    Route::post('/articulo',
        [ArticuloController::class, "Crear"]
    );

    Route::put('/articulo/{idArticulo}',
        [ArticuloController::class, "Modificar"]
    );

    Route::delete('/articulo/{idArticulo}',
        [ArticuloController::class, "Eliminar"]
    );

    Route::get('/paquetes',
        [PaqueteController::class, "ListarTodos"]
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

    Route::get('/lotes',
        [LoteController::class, "ListarTodos"]
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