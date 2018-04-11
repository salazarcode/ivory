<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use App\Sitio;
use App\Marca;

class SitiosController extends Controller
{
    public $mensajes = [
        "notFound" => "El modelo solicitado no existe",
        "nonModel" => "No existe ningún elemento aún",
        "notFoundEntry" => "Alguno de los modelos no existe",
    ];

    public function retrieve($id = null)
    {
        if($id == null)
            $sitio = Sitio::all();
        else
        {
            $sitio = Sitio::find($id);
            if($sitio == null)
            {
                return response()->json(
                [
                    "status" => 0,
                    "descripcion" => $this->mensajes["notFound"]
                ], 200);
            }
        }

        if($sitio->count() == 0)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["nonModel"]
            ], 200);
        }
            
        return response()->json($sitio, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }            

        $input = $request->all();
        $sitio = Sitio::create($input);

        return response()->json($sitio, 200);
    }

    public function update($id, Request $request)
    {
        $sitio = Sitio::find($id);

        if($sitio==null)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["notFound"]
            ], 200);
        }

        $sitio->nombre = $request->nombre;
        $sitio->save();

        return response()->json($sitio, 200);
    }

    public function delete($id)
    {
        $sitio = Sitio::find($id);
        if($sitio == null)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["notFound"]
            ], 200);
        }
        $sitio->delete();
        return response()->json(
        [
            "status" => 1,
            "descripción" => "Eliminación exitosa"
        ], 200);        
    }
    public function attach($marca_id, $sitio_id)
    {
        $marca = Marca::find($marca_id);
        $sitio = Sitio::find($sitio_id);

        if($marca == null || $sitio == null)
        {
            return response()->json([
                "status" => 0,
                "mensaje" => $this->mensajes["notFoundEntry"]
            ], 200);
        }

        $marca->sitios()->attach($sitio_id);

        return response()->json([
            "status" => 1,
            "mensaje" => "Sitio <{$sitio->nombre}> agregado a la marca <{$marca->titulo}>"
        ], 200);
    }
    public function detach($marca_id, $sitio_id)
    {
        $marca = Marca::find($marca_id);
        $sitio = Sitio::find($sitio_id);

        if($marca == null || $sitio == null)
        {
            return response()->json([
                "status" => 0,
                "mensaje" => $this->mensajes["notFoundEntry"]
            ], 200);
        }

        $marca->sitios()->detach($sitio_id);

        return response()->json([
            "status" => 1,
            "mensaje" => "Sitio <{$sitio->nombre}> retirado de la marca <{$marca->titulo}>"
        ], 200);
    }
}
