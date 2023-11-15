<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Estanteria;
use App\Models\PaqueteEstanteria;

class EstanteriaController extends Controller
{
    public function BloquearTablaEstanteria()
    {
        DB::raw('LOCK TABLE estanterias WRITE');
    }

    public function IniciarTransaccion()
    {
        $this->BloquearTablaEstanteria();
        DB::beginTransaction();
    }
    
    public function FinalizarTransaccion()
    {
        DB::commit();
        DB::raw('UNLOCK TABLES');
    }

    public function InsertarDatos($request)
    {
        Estanteria::create([
            "peso" => $request->input("peso"),
            "apiladoMaximo" => $request->input("apiladoMaximo"),
            "idAlmacen" => $request->input("idAlmacen")
        ]);
    }

    public function Crear(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'peso' => 'required|numeric',
            'apiladoMaximo' => 'required|numeric',
            'idAlmacen' => 'required|numeric'
        ]);

        if($validation->fails())
            return response($validation->errors(), 401);

        $this->IniciarTransaccion();

        $this->InsertarDatos($request);

        $this->FinalizarTransaccion();
        
        return [ "mensaje" => "Estanteria creada correctamente." ];
    }

    public function Eliminar(Request $request, $idEstanteria)
    {
        $validation = Validator::make([ 'idEstanteria' => $idEstanteria ],[
            'idEstanteria' => 'required|numeric',
        ]);

        if($validation->fails())
            return response($validation->errors(), 401);

        $estanteria = Estanteria::findOrFail($idEstanteria);

        $this->IniciarTransaccion();

        $estanteria->delete();

        $relacionesConPaquete = PaqueteEstanteria::where('idEstanteria', $idEstanteria);

        if (count($relacionesConPaquete) != 0)
            $relacionesConPaquete->delete();

        $this->FinalizarTransaccion();

        return [ "mensaje" => "Estanteria eliminada correctamente." ];
    }
}
