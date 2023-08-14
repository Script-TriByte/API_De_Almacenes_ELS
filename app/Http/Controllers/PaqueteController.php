<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Articulo;
use App\Models\Paquete;
use App\Models\ArticuloPaquete;

class PaqueteController extends Controller
{
    public function CrearArticuloPaquete($request, $idAutomatico)
    {
        ArticuloPaquete::create([
            "idArticulo" => $request->input("idArticulo"),
            "idPaquete" => $idAutomatico
        ]);
    }
    
    public function CrearPaquete(Request $request)
    {
        $idArticulo = $request->input("idArticulo");

        Articulo::findOrFail($idArticulo);

        $modeloTablaPaquete = Paquete::create([
            "cantidadArticulos" => $request->input("cantidadArticulos"),
            "peso" => "0"
        ]);

        $idAutomatico = $modeloTablaPaquete->idPaquete;

        $this->CrearArticuloPaquete($request, $idAutomatico);

        return [ "mensaje" => "Paquete creado correctamente." ];
    }

    public function AsignarPeso(Request $request, $idPaquete)
    {
        $paquete = Paquete::findOrFail($idPaquete);

        $paquete->peso = $request->input("peso");
        $paquete->save();

        return [ "mensaje" => "Se ha asignado el peso al Paquete $idPaquete correctamente." ];
    }
}