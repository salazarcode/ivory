<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credencial extends Model
{
    protected $table = "credenciales";
    protected $fillable = [
        'sitio_id',
        'marca_id',
        'tcredencial_id',
        'valor'
    ];
    public function tcredencial()
    {
        return $this->belongsTo('App\Tcredencial');
    }
}
