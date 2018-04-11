<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use Validator;

class RolesController extends Controller
{
    public $mensajes = [
        "notFound" => "El modelo solicitado no existe",
        "nonModel" => "No existe ningún elemento aún"
    ];

    public function retrieve($id = null)
    {
        if($id == null)
            $role = Role::all();
        else
        {
            $role = Role::find($id);
            if($role == null)
            {
                return response()->json(
                [
                    "status" => 0,
                    "descripcion" => $this->mensajes["notFound"]
                ], 200);
            }
        }

        if($role->count() == 0)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["nonModel"]
            ], 200);
        }
            
        return response()->json($role, 200);
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
        $role = Role::create($input);

        return response()->json($role, 200);
    }

    public function update($id, Request $request)
    {
        $role = Role::find($id);

        if($role==null)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["notFound"]
            ], 200);
        }

        $role->nombre = $request->nombre;
        $role->save();

        return response()->json($role, 200);
    }

    public function delete($id)
    {
        $role = Role::find($id);
        if($role == null)
        {
            return response()->json(
            [
                "status" => 0,
                "descripcion" => $this->mensajes["notFound"]
            ], 200);
        }
        $role->delete();
        return response()->json(
        [
            "status" => 1,
            "descripción" => "Eliminación exitosa"
        ], 200);        
    }
}
