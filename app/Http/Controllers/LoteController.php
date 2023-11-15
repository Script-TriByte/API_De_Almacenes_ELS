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

    public function IniciarTransaccion()
    {
        $this->BloquearTablas();
        DB::beginTransaction();
    }

    public function FinalizarTransaccion()
    {
        DB::commit();
        DB::raw('UNLOCK TABLES');
    }

    public function CrearPaqueteLote($idAutomatico, $idPaquete)
    {
        PaqueteLote::create([
            "idLote" => $idAutomatico,
            "idPaquete" => $idPaquete
        ]);
    }

    public function InsertarDatos($request)
    {
        $modeloTablaLote = Lote::create([
            "cantidadPaquetes" => $request->input("cantidadPaquetes"),
            "idDestino" => $request->input("idDestino"),
            "idAlmacen" => $request->input("idAlmacen")
        ]);

        $idAutomatico = $modeloTablaLote->idLote;

        return $idAutomatico;
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

        $this->IniciarTransaccion();

        $idAutomatico = $this->InsertarDatos($request);

        $this->CrearPaqueteLote($idAutomatico, $idPaquete);

        PaqueteEstanteria::where('idPaquete', $idPaquete)->delete();

        $this->FinalizarTransaccion(); 

        return [ "mensaje" => "Lote creado correctamente." ];
    }

    public function EliminarDatos($lote, $idLote)
    {
        $lote->delete();
        $relacionLotePaquete = PaqueteLote::where('idLote', $idLote)->delete();
    }

    public function EliminarLote(Request $request, $idLote)
    {
        $validation = Validator::make(['idLote' => $idLote],[
            'idLote' => 'required|numeric'
        ]);

        if($validation->fails())
            return response($validation->errors(), 401);
        
        $lote = Lote::findOrFail($idLote);

        $this->IniciarTransaccion();

        $this->EliminarDatos($lote, $idLote);

        $this->FinalizarTransaccion();

        return [ "mensaje" => "El lote con el id $idLote fue eliminado correctamente." ];
    }

    public function AsignarDatosAlChofer($request, $idLote, $documentoDeIdentidad)
    {
        VehiculoLoteDestino::create()([
            "idLote" => $idLote,
            "fechaEstimada" => $request->input("fechaEstimada"),
            "horaEstimada" => $request->input("horaEstimada"),
            "docDeIdentidad" => $documentoDeIdentidad
        ]);
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

        $this->IniciarTransaccion();

        $this->AsignarDatosAlChofer($request, $idLote, $documentoDeIdentidad);

        $this->FinalizarTransaccion();

        return [ "mensaje" => "Se ha asignado el lote al chofer con la CI $documentoDeIdentidad correctamente." ];
    }

    public function ListarTodos()
    {
        return Lote::all();
    }
}
