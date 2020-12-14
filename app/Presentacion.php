<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presentacion extends Model
{
    protected $table = 'presentacion';
    protected $fillable = ['id','nombre'];

    public function articulos()
    {
        return $this->hasMany('App\Articulo');
    }
}
