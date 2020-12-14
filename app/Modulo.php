<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'modulos';
    protected $fillable = ['nombre','descripcion','estado','usu_crea','componente','menu','tipo','icono','template','padre'];
    
    public function user()
    {
        return $this->hasOne('App\User');
    }
}
