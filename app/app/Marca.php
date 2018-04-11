<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = [
        'titulo', 'user_id'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function sitios()
    {
        return $this->belongsToMany('App\Sitio');
    }
}
