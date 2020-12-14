<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentasxPagar extends Model
{
    protected $table = 'cuentas_x_pagar';
    protected $fillable = ['id','id_tercero','id_factura','num_pago','pago_ante','id_pago','valor_deuda','abono','saldo','fecha_pago','estado_pago','sin_factura','usuario'];

    public function persona(){
        return $this->belongsTo('App\Persona');
    }
}
