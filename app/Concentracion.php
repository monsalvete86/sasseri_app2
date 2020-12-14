<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concentracion extends Model
{
    protected $table = 'concentraciones';
    protected $fillable = ['id','nombre'];

    public function articulos()
    {
        return $this->hasMany('App\Articulo');
    }
}
