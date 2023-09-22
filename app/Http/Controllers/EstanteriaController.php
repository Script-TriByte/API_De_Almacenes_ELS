<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Estanteria;

class EstanteriaController extends Controller
{
    public function BloquearTablaEstanteria()
    {
        DB::raw('LOCK TABLE estanterias WRITE');
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

        $this -> BloquearTablaEstanteria();
        DB::beginTransaction();

        Estanteria::create([
            "peso" => $request->input("peso"),
            "apiladoMaximo" => $request->input("apiladoMaximo"),
            "idAlmacen" => $request->input("idAlmacen")
        ]);

        DB::commit();
        DB::raw('UNLOCK TABLES');
        
        return [ "mensaje" => "Estanteria creada correctamente." ];
    }

    public function Eliminar(Request $request, $idEstanteria)
    {
        $validation = Validator::make([ 'idEstanteria', $idEstanteria ],[
            'idEstanteria' => 'required|numeric',
        ]);

        if($validation->fails())
            return response($validation->errors(), 401);

        $estanteria = Estanteria::findOrFail($idEstanteria);

        $relacionesConPaquete = PaqueteEstanteria::where('idEstanteria', $idEstanteria)->first();

        if($relacionesConPaquete != null)
            return response([ "mensaje" => "La estanteria a eliminar cuenta con paquetes." ], 401);

        $this -> BloquearTablaEstanteria();
        DB::beginTransaction();

        $estanteria->delete();

        DB::commit();
        DB::raw('UNLOCK TABLES');

        return [ "mensaje" => "Estanteria eliminada correctamente." ];
    }
}
