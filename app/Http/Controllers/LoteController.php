<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoteController extends Controller
{
    public function CrearPaqueteLote($request, $idAutomatico)
    {
        PaqueteLote::create([
            "idLote" => $idAutomatico,
            "idPaquete" => $request->input("idPaquete")
        ]);
    }

    public function CrearLote(Request $request)
    {
        $idPaquete = $request->input("idPaquete");

        Paquete::findOrFail($idPaquete);

        $modeloTablaLote = Lote::create([
            "cantidadPaquetes" => $request->input("cantidadPaquetes")
        ]);

        $idAutomatico = $modeloTablaLote->idLote;

        $this->CrearPaqueteLote($request, $idAutomatico);

        return [ "mensaje" => "Lote creado correctamente." ];
    }
}
