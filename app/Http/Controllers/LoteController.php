<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Paquete;
use App\Models\Lote;
use App\Models\PaqueteLote;

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

    public function EliminarLote(Request $request, $idLote)
    {
        $lote = Lote::findOrFail($idLote);
        $lote->delete();

        $relacionLotePaquete = PaqueteLote::where('idLote', $idLote) -> get();
        $relacionLotePaquete::delete();

        return [ "mensaje" => "El lote con el id $idLote fue eliminado correctamente." ];
    }

    public function SacarPaqueteDelLote(Request $request, $idLote, $idPaquete)
    {
        $lote = Lote::findOrFail($idLote);
        $paquete = PaqueteLote::where('idPaquete', $idPaquete) -> get();

        if($lote -> $idLote === $paquete -> $idPaquete){
            $paquete::delete();
            $lote->save();
            $paquete->save();

            return [ "mensahe" => "El paquete se extrajo correctamente"];
        } 

        return [ "mensaje" => "El paquete ingresado no existe en ese lote."];
    }
}
