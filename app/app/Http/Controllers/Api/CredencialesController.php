<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Sitio;
use App\Marca;
use App\Tcredencial;
use App\Credencial;

class CredencialesController extends Controller
{
    public $mensajes = [
        "notFound" => "El modelo solicitado no existe",
        "nonModel" => "No existe ningún elemento aún",
        "notFoundEntry" => "Alguno de los modelos no existe",
    ];

    public function retrieve($id = null)
    {
        if($id == null)
            $credencial = Credencial::all();
        else
        {
            $credencial = Credencial::find($id);
            if($credencial == null)
            {
                return response()->json(
                [
                    "status" => 0,
                    "descripcion" => $this->mensajes["notFound"]
                ], 200);
            }
        }

        if($credencial->count() == 0)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["nonModel"]
            ], 200);
        }
            
        return response()->json($credencial, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sitio_id' => 'required',
            'marca_id' => 'required',
            'tcredencial_id' => 'required',
            'valor' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }            

        $sitio = Sitio::find($request->sitio_id);
        $marca = Marca::find($request->marca_id);
        $tipo = Tcredencial::find($request->tcredencial_id);

        if($sitio == null || $marca == null || $tipo == null)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => "El sitio, la marca o el tipo de credencial no existe"
            ], 200);
        }

        $input = $request->all();
        $credencial = Credencial::create($input);

        return response()->json($credencial, 200);
    }

    public function update($id, Request $request)
    {
        $credencial = Credencial::find($id);

        if($credencial==null)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["notFound"]
            ], 200);
        }

        $sitio = Sitio::find($request->sitio_id);
        $marca = Marca::find($request->marca_id);
        $tipo = Tcredencial::find($request->tcredencial_id);

        if($sitio == null || $marca == null || $tipo == null)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => "El sitio, la marca o el tipo de credencial no existe"
            ], 200);
        }

        $credencial->sitio_id = $request->sitio_id;
        $credencial->marca_id = $request->marca_id;
        $credencial->tcredencial_id = $request->tcredencial_id;
        $credencial->valor = $request->valor;
        $credencial->save();

        return response()->json($credencial, 200);
    }

    public function delete($id)
    {
        $credencial = Credencial::find($id);
        if($credencial == null)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["notFound"]
            ], 200);
        }
        $credencial->delete();
        return response()->json(
        [
            "status" => 1,
            "descripción" => "Eliminación exitosa"
        ], 200);        
    }

    public function credencialesSitio($marca_id, $sitio_id)
    {
        $credenciales = Credencial::where([
            ['marca_id', '=', $marca_id],
            ['sitio_id', '=', $sitio_id]
        ])->get();
        return response()->json([
            "status" => 1,
            "data" => $credenciales
        ],200);
    }
}
