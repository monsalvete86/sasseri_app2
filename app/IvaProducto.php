<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IvaProducto extends Model
{
    protected $table = 'productos_iva';
    protected $fillable = ['id','id_iva','id_producto'];
    public $timestamps = false;
}
