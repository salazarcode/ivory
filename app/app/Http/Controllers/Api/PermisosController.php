<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Permiso;
use App\User;
use Validator;

class PermisosController extends Controller
{
    public $mensajes = [
        "notFound" => "El modelo solicitado no existe",
        "nonModel" => "No existe ningún elemento aún",
        "notFoundEntry" => "Alguno de los modelos no existe",
    ];

    public function retrieve($id = null)
    {
        if($id == null)
            $permiso = Permiso::all();
        else
        {
            $permiso = Permiso::find($id);
            if($permiso == null)
            {
                return response()->json(
                [
                    "status" => 0,
                    "descripcion" => $this->mensajes["notFound"]
                ], 200);
            }
        }

        if($permiso->count() == 0)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["nonModel"]
            ], 200);
        }
            
        return response()->json($permiso, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }            

        $input = $request->all();
        $permiso = Permiso::create($input);

        return response()->json($permiso, 200);
    }

    public function update($id, Request $request)
    {
        $permiso = Permiso::find($id);

        if($permiso==null)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["notFound"]
            ], 200);
        }

        $permiso->nombre = $request->nombre;
        $permiso->descripcion = $request->descripcion;
        $permiso->save();

        return response()->json($permiso, 200);
    }

    public function delete($id)
    {
        $permiso = Permiso::find($id);
        if($permiso == null)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["notFound"]
            ], 200);
        }
        $permiso->delete();
        return response()->json(
        [
            "status" => 1,
            "descripción" => "Eliminación exitosa"
        ], 200);        
    }

    public function attach($permiso_id, $user_id)
    {
        $permiso = Permiso::find($permiso_id);
        $user = User::find($user_id);
        if($permiso == null || $user == null)
        {
            return response()->json([
                "status" => 0,
                "mensaje" => $this->mensajes["notFoundEntry"]
            ], 200);
        }

        $user->permisos()->attach($permiso_id);

        return response()->json([
            "status" => 1,
            "mensaje" => "Permiso <{$permiso->nombre}> agregado al usuario <{$user->name}>"
        ], 200);
    }

    public function detach($permiso_id, $user_id)
    {
        $permiso = Permiso::find($permiso_id);
        $user = User::find($user_id);
        if($permiso == null || $user == null)
        {
            return response()->json([
                "status" => 0,
                "mensaje" => $this->mensajes["notFoundEntry"]
            ], 200);
        }

        $user->permisos()->detach($permiso_id);

        return response()->json([
            "status" => 1,
            "mensaje" => "Permiso <{$permiso->nombre}> retirado del usuario <{$user->name}>"
        ], 200);
    }
}
