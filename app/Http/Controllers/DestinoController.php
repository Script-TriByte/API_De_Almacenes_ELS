<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Destino;

class DestinoController extends Controller
{
    public function BloquearTablaDestino()
    {
        DB::raw('LOCK TABLE destinos WRITE');
    }

    public function IniciarTransaccion()
    {
        $this->BloquearTablaDestino();
        DB::beginTransaction();
    }

    public function FinalizarTransaccion()
    {
        DB::commit();
        DB::raw('UNLOCK TABLES');
    }

    public function InsertarDatos($request)
    {
        Destino::create([
            "direccion" => $request->input('direccion'),
            "idDepartamento" => $request->input('idDepartamento')
        ]);
    }

    public function Crear(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'direccion' => 'required|min:2|max:40|unique:destinos',
            'idDepartamento' => 'required|numeric'
        ]);

        if($validation->fails())
            return response($validation->errors(), 401);

        $this->IniciarTransaccion();

        $this->InsertarDatos($request);

        $this->FinalizarTransaccion();

        return [ "mensaje" => "Destino registrado correctamente." ];
    }
}
