<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CajasAdmin extends Model
{
    protected $table = 'cajas_admin';
    protected $fillable = ['id','id_caja','id_usuario','usu_crea','creted_at','updated_at'];
}
