<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Paquete;
use App\Models\Lote;
use App\Models\PaqueteLote;
use App\Models\PaqueteEstanteria;
use App\Models\VehiculoLoteDestino;
use App\Models\Chofer;

class LoteController extends Controller
{
    public function BloquearTablas()
    {
        DB::raw('LOCK TABLE lotes WRITE');
        DB::raw('LOCK TABLE paquete_lote WRITE');
        DB::raw('LOCK TABLE paquete_estanteria WRITE');
        DB::raw('LOCK TABLE vehiculo_lote_destino WRITE');
        DB::raw('LOCK TABLE paquetes READ');
    }

    public function CrearPaqueteLote($idAutomatico, $idPaquete)
    {
        PaqueteLote::create([
            "idLote" => $idAutomatico,
            "idPaquete" => $idPaquete
        ]);
    }

    public function CrearLote(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'idPaquete' => 'required|numeric',
            'cantidadPaquetes' => 'required|numeric',
            'idDestino' => 'required|numeric',
            'idAlmacen' => 'required|numeric'
        ]);

        if($validation->fails())
            return response($validation->errors(), 401);

        $idPaquete = $request->input("idPaquete");

        Paquete::findOrFail($idPaquete);

        $this -> BloquearTablas();
        DB::beginTransaction();

        $modeloTablaLote = Lote::create([
            "cantidadPaquetes" => $request->input("cantidadPaquetes"),
            "idDestino" => $request->input("idDestino"),
            "idAlmacen" => $request->input("idAlmacen")
        ]);

        $idAutomatico = $modeloTablaLote->idLote;

        $this->CrearPaqueteLote($idAutomatico, $idPaquete);

        PaqueteEstanteria::where('idPaquete', $idPaquete)->delete();

        DB::commit();
        DB::raw('UNLOCK TABLES');

        return [ "mensaje" => "Lote creado correctamente." ];
    }

    public function EliminarLote(Request $request, $idLote)
    {
        $validation = Validator::make(['idLote' => $idLote],[
            'idLote' => 'required|numeric'
        ]);

        if($validation->fails())
            return response($validation->errors(), 401);
        
        $lote = Lote::findOrFail($idLote);

        $this -> BloquearTablas();
        DB::beginTransaction();

        $lote->delete();

        $relacionLotePaquete = PaqueteLote::where('idLote', $idLote)->get();
        $relacionLotePaquete->delete();

        DB::commit();
        DB::raw('UNLOCK TABLES');

        return [ "mensaje" => "El lote con el id $idLote fue eliminado correctamente." ];
    }

    public function AsignarLoteAChofer(Request $request, $idLote, $documentoDeIdentidad)
    {
        $validation = Validator::make(['idLote' => $idLote, 'documentoDeIdentidad' => $documentoDeIdentidad],[
            'idLote' => 'required|numeric',
            'documentoDeIdentidad' => 'required|numeric|digits:8'
        ]);

        if($validation->fails())
            return response($validation->errors(), 401);


        Lote::findOrFail($idLote);
        Chofer::findOrFail($documentoDeIdentidad);

        $this -> BloquearTablas();
        DB::beginTransaction();

        VehiculoLoteDestino::create()([
            "idLote" => $idLote,
            "fechaEstimada" => $request->input("idDestino"),
            "horaEstimada" => $request->input("idAlmacen"),
            "docDeIdentidad" => $documentoDeIdentidad
        ]);

        DB::commit();
        DB::raw('UNLOCK TABLES');

        return [ "mensaje" => "Se ha asignado el lote al chofer con la CI $documentoDeIdentidad correctamente." ];
    }
}
