<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoTarifario extends Model
{
    protected $table = 'productos_tarifarios';
    protected $fillable = ['id','id_tarifario','id_producto','valor'];
    public $timestamps = false;

}
