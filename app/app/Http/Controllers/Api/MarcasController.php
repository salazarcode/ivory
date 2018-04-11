<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Marca;
use App\User;
use Validator;


class MarcasController extends Controller
{
    public $mensajes = [
        "notFound" => "El modelo solicitado no existe",
        "nonModel" => "No existe ningún elemento aún"
    ];

    public function retrieve($id = null)
    {
        if($id == null)
            $marca = Marca::all();
        else
        {
            $marca = Marca::find($id);
            if($marca == null)
            {
                return response()->json(
                [
                    "status" => 0,
                    "descripcion" => $this->mensajes["notFound"]
                ], 200);
            }
        }

        if($marca->count() == 0)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["nonModel"]
            ], 200);
        }
            
        return response()->json($marca, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'user_id' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }            

        if(User::find($request->user_id) == null )
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => "El usuario de id = {$request->user_id} no existe"
            ], 200);
        }

        $input = $request->all();
        $marca = Marca::create($input);

        return response()->json($marca, 200);
    }

    public function update($id, Request $request)
    {
        $marca = Marca::find($id);

        if($marca==null)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["notFound"]
            ], 200);
        }

        if(User::find($request->user_id) == null )
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => "El usuario de id = {$request->user_id} no existe"
            ], 200);
        }

        $marca->titulo = $request->titulo;
        $marca->user_id = $request->user_id;
        $marca->save();

        return response()->json($marca, 200);
    }

    public function delete($id)
    {
        $marca = Marca::find($id);
        if($marca == null)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["notFound"]
            ], 200);
        }
        $marca->delete();
        return response()->json(
        [
            "status" => 1,
            "descripción" => "Eliminación exitosa"
        ], 200);        
    }

    public function marcasDeUsuario($user_id)
    {
        $user = User::find($user_id);

        if($user == null)
        {
            return response()->json(
            [
                "status" => 0,
                "descripción" => "El usuario no existe"
            ], 200); 
        }
        $marcas = $user->marcas;

        if($marcas->count() == 0)
        {
            return response()->json(
            [
                "status" => 1,
                "descripción" => $this->mensajes["nonModel"]
            ], 200); 
        }
        return response()->json($marcas, 200);
    }

    public function sitiosDeMarca($marca_id)
    {
        return response()->json([
            "status" => 1,
            "data" => Marca::find($marca_id)->sitios
        ], 200);
    }
}
