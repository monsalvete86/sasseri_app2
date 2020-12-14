<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
    //protected $primaryKey = 'id';
    protected $fillable = ['nom_compania','direccion','tipo_id','identificacion','ciudad','departamento','telefono','rep_legal'];

}
