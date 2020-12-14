<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CierresXCaja extends Model
{
    protected $table = 'cajas_cierres';
    protected $fillable = ['id','id_caja','vr_inicial','obs_inicial','vr_gastos','obs_gastos','vr_software','vr_final','estado','usu_crea','id_empresa','created_at'];
}
