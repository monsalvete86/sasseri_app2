<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;

class Cuentas extends Model
{
    protected $table = 'cuentas';
    protected $fillable = [
        'id_formato', 'numero', 'tercero', 'debe', 'haber','doc_externo', 'centro_costos', 'detalle', 'fecha', 'base_graba',
        'usuario', 'cerrado', 'condicion'  , 'cuenta','doc_afecta_long','saldo_cuent'
    ];
    public function tercero(){
        return $this->belongsTo('App\Persona');
    }
    public function formato(){
        return $this->belongsTo('App\Formatos');
    }
    public function cuenta(){
        return $this->belongsTo('App\Plancuentas_model');
    }
    public function conf_formato(){
        return $this->belongsTo('App\Conf_formatos');
    }
}
