<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleFacturacion extends Model
{
    protected $table = 'detalle_facturacion';
    protected $fillable =[
        'id','id_factura','id_producto','valor_venta','cantidad','valor_iva','valor_descuento','procentaje_iva','valor_subtotal','valor_final'
    ];
    public function factura(){
        return $this->hasOne('App\Facturacion');
    }
    public function articulo(){
        return $this->belongsTo('App\Articulo');
    }
}
