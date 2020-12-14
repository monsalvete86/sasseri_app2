<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturacion extends Model
{
    protected $table = 'facturacion';
    protected $fillable =[
        'id','num_factura','id_tercero','id_usuario','fec_crea','fec_edita','usu_edita','subtotal','valor_iva','total','abono','saldo','detalle','descuento','fec_registra','fec_envia','fec_anula','usu_registra','usu_envia','usu_anula','fecha','estado'
    ];
    public function persona(){
        return $this->belongsTo('App\Persona');
    }
    public function detalleFactura()
    {
        return $this->hasMany('App\DetalleFacturacion');
    }
}
