<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormatoProceso extends Model
{
    protected $table = 'formatos_procesos';
    protected $fillable = ['id','idFormatoCompras','idFormatoVentas','idForamtoSalida'];
}
