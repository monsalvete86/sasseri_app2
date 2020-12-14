<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class conf_formatos extends Model
{
    protected $table = 'conf_formatos';

    protected $fillable = [
        'tipo', 'retencion', 'no_inicio', 'cierre', 'acarreo', 'depreciacion', 'fiscal', 'niif', 'nombre_formato'
        , 'condicion', 'fecha_vence'
    ];
}
