<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentasxCobrar extends Model
{
    protected $table = 'cuentas_x_cobrar';
    protected $fillable = ['id','id_tercero','id_factura','num_pago','pago_ante','id_pago','valor_deuda','abono','saldo','fecha_cobro','estado_abono','estado_cobro','sin_factura','usuario'];
    public function persona(){
        return $this->belongsTo('App\Persona');
    }
    public function detalleFactura()
    {
        return $this->belongsTo('App\DetalleFacturacion');
    }
}
