<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleEgreso extends Model
{
    protected $table = 'detalle_egresos';
    protected $fillable = [
        'idegreso', 
        'idarticulo',
        'cantidad',
        'precio'
    ];
    public $timestamps = false;

}
