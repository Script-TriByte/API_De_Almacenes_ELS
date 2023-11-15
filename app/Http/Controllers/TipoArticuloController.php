<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\TipoArticulo;

class TipoArticuloController extends Controller
{
    public function BloquearTablaTipo()
    {
        DB::raw('LOCK TABLE tipoArticulo WRITE');
    }

    public function IniciarTransaccion()
    {
        $this->BloquearTablaTipo();
        DB::beginTransaction();
    }

    public function FinalizarTransaccion()
    {
        DB::commit();
        DB::raw('UNLOCK TABLES');
    }

    public function InsertarDatos($request)
    {
        TipoArticulo::create([
            "tipo" => $request->input('tipo'),
            "nombre" => $request->input('nombre')
        ]);
    }

    public function Crear(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'tipo' => 'required|alpha|min:1|max:1|unique:tipoArticulo',
            'nombre' => 'required|alpha|min:2'
        ]);

        if($validation->fails())
            return response($validation->errors(), 401);

        $this->IniciarTransaccion();

        $this->InsertarDatos($request);

        $this->FinalizarTransaccion();

        return [ "mensaje" => "Tipo de articulo registrado con exito." ];
    }
}
