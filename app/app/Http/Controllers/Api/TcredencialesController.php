<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use App\Tcredencial;

class TcredencialesController extends Controller
{
    public $mensajes = [
        "notFound" => "El modelo solicitado no existe",
        "nonModel" => "No existe ningún elemento aún",
        "notFoundEntry" => "Alguno de los modelos no existe",
    ];

    public function retrieve($id = null)
    {
        if($id == null)
            $tcredencial = Tcredencial::all();
        else
        {
            $tcredencial = Tcredencial::find($id);
            if($tcredencial == null)
            {
                return response()->json(
                [
                    "status" => 0,
                    "descripcion" => $this->mensajes["notFound"]
                ], 200);
            }
        }

        if($tcredencial->count() == 0)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["nonModel"]
            ], 200);
        }
            
        return response()->json($tcredencial, 200);
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
        $tcredencial = Tcredencial::create($input);

        return response()->json($tcredencial, 200);
    }

    public function update($id, Request $request)
    {
        $tcredencial = Tcredencial::find($id);

        if($tcredencial==null)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["notFound"]
            ], 200);
        }

        $tcredencial->nombre = $request->nombre;
        $tcredencial->descripcion = $request->descripcion;
        $tcredencial->save();

        return response()->json($tcredencial, 200);
    }

    public function delete($id)
    {
        $tcredencial = Tcredencial::find($id);
        if($tcredencial == null)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["notFound"]
            ], 200);
        }
        $tcredencial->delete();
        return response()->json(
        [
            "status" => 1,
            "descripción" => "Eliminación exitosa"
        ], 200);        
    }
}
