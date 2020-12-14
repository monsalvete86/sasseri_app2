<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolPermisos extends Model
{
    protected $table = 'roles_permisos';
    protected $fillable = ['id_rol','id_modulo','id_empresa','lectura','escritura','edicion','anular','imprimir','usu_crea','estado'];
    // public $timestamps = false;

    public function users()
    {
        return $this->hasMany('App\User');
    }

}
