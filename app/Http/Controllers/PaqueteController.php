<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Articulo;
use App\Models\Paquete;
use App\Models\ArticuloPaquete;
use App\Models\PaqueteLote;
use App\Models\PaqueteCodigoDeBulto;
use App\Models\Estanteria;
use App\Models\PaqueteEstanteria;

class PaqueteController extends Controller
{
    public function BloquearTablas()
    {
        DB::raw('LOCK TABLE paquetes WRITE');
        DB::raw('LOCK TABLE articulos READ');
        DB::raw('LOCK TABLE articulo_paquete WRITE');
        DB::raw('LOCK TABLE paquete_lote WRITE');
        DB::raw('LOCK TABLE paquete_estanteria WRITE');
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

    public function CrearArticuloPaquete($request, $idAutomatico)
    {
        ArticuloPaquete::create([
            "idArticulo" => $request->input("idArticulo"),
            "idPaquete" => $idAutomatico
        ]);
    }

    public function CrearPaqueteCodigoDeBulto($idAutomatico, $codigoDeBulto)
    {
        PaqueteCodigoDeBulto::create([
            "idPaquete" => $idAutomatico,
            "codigo" => $codigoDeBulto
        ]);
    }

    public function InsertarDatos($request, $modeloTablaPaquete)
    {
        $modeloTablaPaquete = Paquete::create([
            "cantidadArticulos" => $request->input("cantidadArticulos"),
            "peso" => "0"
        ]);

        $idAutomatico = $modeloTablaPaquete->idPaquete;

        return $idAutomatico;
    }
    
    public function CrearPaquete(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'idArticulo' => 'required|numeric',
            'cantidadArticulos' => 'required|numeric|min:1|max:20',
            'codigoDeBulto' => 'required|numeric'
        ]);

        if($validation->fails())
            return response($validation->errors(), 401);

        $idArticulo = $request->input("idArticulo");

        Articulo::findOrFail($idArticulo);

        $this->IniciarTransaccion();

        $idAutomatico = $this->InsertarDatos($request, $modeloTablaPaquete);

        $this->CrearArticuloPaquete($request, $idAutomatico);
        $this->CrearPaqueteCodigoDeBulto($idAutomatico, $request->input('codigoDeBulto'));

        $this->FinalizarTransaccion();

        return [ "mensaje" => "Paquete creado correctamente." ];
    }

    public function AsignarDatos($request, $paquete)
    {
        $paquete->peso = $request->input("peso");
        $paquete->save();
    }

    public function AsignarPeso(Request $request, $idPaquete)
    {
        $validation = Validator::make($request->all(),[
            'idPaquete' => 'required|numeric',
            'peso' => 'required|numeric'
        ]);

        if($validation->fails())
            return response($validation->errors(), 401);

        $paquete = Paquete::findOrFail($idPaquete);

        $this->IniciarTransaccion();

        $this->AsignarDatos($request, $paquete);

        $this->FinalizarTransaccion();

        return [ "mensaje" => "Se ha asignado el peso al Paquete $idPaquete correctamente." ];
    }

    public function AsignarPaqueteEnEstanteria($idPaquete, $idEstanteria)
    {
        PaqueteEstanteria::create([
            "idPaquete" => $idPaquete,
            "idEstanteria" => $idEstanteria
        ]);
    }

    public function AsignarAEstanteria(Request $request, $idPaquete, $idEstanteria)
    {
        $validation = Validator::make(['idPaquete' => $idPaquete, 'idEstanteria' => $idEstanteria],[
            'idPaquete' => 'required|numeric',
            'idEstanteria' => 'required|numeric'
        ]);

        if($validation->fails())
            return response($validation->errors(), 401);

        Paquete::findOrFail($idPaquete);
        Estanteria::findOrFail($idEstanteria);

        $this->IniciarTransaccion();

        $this->AsignarPaqueteEnEstanteria($idPaquete, $idEstanteria);

        PaqueteLote::where('idPaquete', $idPaquete)->delete();

        $this->FinalizarTransaccion();

        return [ "mensaje" => "Se ha asignado a la estanteria correctamente." ];
    }

    public function ListarTodos()
    {
        return Paquete::all();
    }
}