<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanCuentasCategorias extends Model
{
    protected $table = 'plan_cuentas_categorias';
    protected $fillable = ['id','id_plan_cuentas','id_categoria'];
}
