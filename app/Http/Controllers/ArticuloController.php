<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

use App\Models\Articulo;
use App\Models\TipoArticulo;
use App\Models\ArticuloTipoArticulo;

class ArticuloController extends Controller
{
    public function BloquearTablas()
    {
        DB::raw('LOCK TABLE articulos WRITE');
        DB::raw('LOCK TABLE tipoArticulo READ');
        DB::raw('LOCK TABLE articulo_tipoArticulo WRITE');
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

    public function RelacionarConTipo($idAutomatico, $idTipo)
    {
        try {
            ArticuloTipoArticulo::create([
                "idArticulo" => $idAutomatico,
                "idTipo" => $idTipo
            ]);
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos. Intentelo mas tarde." ];
        }
    }

    public function CrearArticulo($request)
    {
        try {
            $articulo = Articulo::create([
                "nombre" => $request->input("nombre"),
                "anioCreacion" => $request->input("anioCreacion")
            ]);

            return $articulo;
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos. Intentelo mas tarde." ];
        }
    }

    public function Crear(Request $request)
    {
        try {
            $validation = Validator::make($request->all(),[
                'nombre' => 'required|min:2|max:255',
                'anioCreacion' => 'required|digits:4|numeric',
                'tipo' => 'required|alpha|min:1|max:1'
            ]);
    
            if($validation->fails())
                throw new ValidationException($validation);
    
            $tipoArticulo = TipoArticulo::where('tipo', $request->input('tipo'))->firstOrFail();
    
            $this->IniciarTransaccion();
    
            $articulo = $this->CrearArticulo($request);
    
            $this->RelacionarConTipo($articulo->idArticulo, $tipoArticulo->idTipoArticulo);
    
            $this->FinalizarTransaccion();
    
            return [ "mensaje" => "Articulo registrado correctamente." ];
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos. Intentelo mas tarde." ];
        }
        catch (ModelNotFoundException $e) {
            return response([ "mensaje" => "Tipo de Articulo inexistente." ], 404);
        }
        catch (ValidationException $e) {
            return response($e->validator->errors(), 401);
        }
    }

    public function ModificarDatos($request, $articulo)
    {
        try {
            $articulo->nombre = $request->input("nombre");
            $articulo->save();
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos. Intentelo mas tarde." ];
        }
    }

    public function Modificar(Request $request, $idArticulo)
    {
        try {
            $validation = Validator::make(['idArticulo' => $idArticulo],[
                'idArticulo' => 'required|numeric',
            ]);
    
            if($validation->fails())
                throw new ValidationException($validation);
    
            $articulo = Articulo::findOrFail($idArticulo);
    
            $this->IniciarTransaccion();
    
            $this->ModificarDatos($request, $articulo);
    
            $this->FinalizarTransaccion();
    
            return ["mensaje" => "Articulo modificado correctamente."];
        }
        catch (ModelNotFoundException $e) {
            return response([ "mensaje" => "Articulo inexistente." ], 404);
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos. Intentelo mas tarde." ];
        }
        catch (ValidationException $e) {
            return response($e->validator->errors(), 401);
        }
    }

    public function EliminarDatos($articulo, $idArticulo)
    {
        try {
            ArticuloTipoArticulo::where('idArticulo', $idArticulo)->delete();
            $articulo->delete();
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos. Intentelo mas tarde." ];
        }
    }

    public function Eliminar(Request $request, $idArticulo)
    {
        try {
            $validation = Validator::make(['idArticulo' => $idArticulo],[
                'idArticulo' => 'required|numeric',
            ]);
    
            if($validation->fails())
                throw new ValidationException($validation);
    
            $articulo = Articulo::findOrFail($idArticulo);
    
            $this->IniciarTransaccion();
    
            $this->EliminarDatos($articulo, $idArticulo);
    
            $this->FinalizarTransaccion();
    
            return ["mensaje" => "Articulo eliminado correctamente."];
        }
        catch (ModelNotFoundException $e) {
            return response([ "mensaje" => "Articulo inexistente." ], 404);
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos. Intentelo mas tarde." ];
        }
        catch (ValidationException $e) {
            return response($e->validator->errors(), 401);
        }
    }

    public function IterarTiposDeArticulo($tipoArticuloRelacionado, $tiposDeArticuloQuePosee)
    {
        forEach($tipoArticuloRelacionado as $relacionesConArticulo) {
            $idTipoArticulo = $relacionesConArticulo['idTipo'];

            $tipoArticulo = TipoArticulo::findOrFail($idTipoArticulo);

            $tiposDeArticuloQuePosee[] = $tipoArticulo;
        }

        return $tiposDeArticuloQuePosee;
    }

    public function ObtenerTiposDeArticulo(Request $request, $idArticulo)
    {
        try {
            $tipoArticuloRelacionado = ArticuloTipoArticulo::where('idArticulo', $idArticulo)->get();
            
            if(!isset($tipoArticuloRelacionado))
                throw new ModelNotFoundException;
        
            $tiposDeArticuloQuePosee = [];
            $tiposDeArticuloQuePosee = $this->IterarTiposDeArticulo($tipoArticuloRelacionado, $tiposDeArticuloQuePosee);

            return $tiposDeArticuloQuePosee;
        }
        catch (ModelNotFoundException $e){
            return response([ "mensaje" => "Articulo inexistente." ], 404);
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos. Intentelo mas tarde." ];
        }
    }

    public function ListarTodos()
    {
        return Articulo::all();
    }
}
