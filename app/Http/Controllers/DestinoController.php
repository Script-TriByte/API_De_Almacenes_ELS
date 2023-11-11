<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DestinoController extends Controller
{
    public function BloquearTablaDestino()
    {
        DB::raw('LOCK TABLE destinos WRITE');
    }

    public function Crear(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'direccion' => 'required|min:2|max:40|unique:destinos',
            'idDepartamento' => 'required|numeric'
        ]);

        if($validation->fails())
            return response($validation->errors(), 401);

        $this -> BloquearTablaDestino();
        DB::beginTransaction();

        Destino::create([
            "direccion" => $request->input('direccion'),
            "idDepartamento" => $request->input('idDepartamento')
        ]);

        DB::commit();
        DB::raw('UNLOCK TABLES');

        return [ "mensaje" => "Destino registrado correctamente." ];
    }
}
