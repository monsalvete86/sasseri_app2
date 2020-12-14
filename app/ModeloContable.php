<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModeloContable extends Model
{
    protected $table = 'modelo_contable';
    //protected $primaryKey = 'id';
    protected $fillable = ['nombre','descripcion','idIvaCompra','idIvaVenta','idIvaDevolucionCompra','idIvaDevolucionVenta','condicion'];

    public function articulos()
    {
        return $this->hasMany('App\Articulo');
    }
}
