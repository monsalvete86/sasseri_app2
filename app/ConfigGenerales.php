<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigGenerales extends Model
{
    protected $table = 'empresas';
    protected $fillable = ['id','nombre','logo','repre_legal','nit','direccion','res_fact_elect','res_fact_pos','correo','celular','telefono','usu_crea','estado'];
    // public $timestamps = false;

    public function users()
    {
        return $this->hasMany('App\User');
    }

}
