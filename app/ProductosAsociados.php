<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosAsociados extends Model
{
    protected $table = 'productos_asociados';
    protected $fillable = ['id','id_presentacion','unidades','id_producto','estado'];

    public function articulos()
    {
        return $this->hasMany('App\Articulo');
    }
}
