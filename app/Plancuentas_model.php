<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plancuentas_model extends Model
{
    protected $table = "plan_cuentas";

    protected $filleable = ['codigo','nombre','naturaleza','tipo','corriente','banco','diferido','tercero','niif','anio','condicion','orden'];
}
