<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tcredencial extends Model
{
    protected $table = "tcredenciales";
    protected $fillable = [
        'nombre'
    ];
    public function credenciales()
    {
        return $this->hasMany('App\Credencial');
    }
}
