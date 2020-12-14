<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbonoPagar extends Model
{
    protected $table = 'abono_pagar';
    protected $fillable = ['id','num_pago','pago_ante','id_pago','abono','estado_pago','id_empresa','usu_crea'];

    public function persona(){
        return $this->belongsTo('App\Persona');
    }
}
