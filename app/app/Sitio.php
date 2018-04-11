<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sitio extends Model
{
    protected $fillable = [
        'nombre'
    ];
    public function marcas()
    {
        return $this->belongsToMany('App\Marca');
    }
}
