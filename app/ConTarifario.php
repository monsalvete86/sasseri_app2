<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConTarifario extends Model
{
    protected $table = 'con_tarifarios';
    protected $fillable = ['id','nombre','descripcion','id_empresa','estado'];

}
