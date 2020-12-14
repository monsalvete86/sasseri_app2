<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formatos extends Model
{
    protected $table='formatos';
    protected $fillable = [
        'numero', 'formato', 'tercero', 'fecha', 'detalle', 'condicion', 'usuario', 'haberes', 'debes', 'subtotal',
        'impuesto', 'vr_impuesto', 'total', 'doc_afecta', 'banco', 'forma_pago', 'num_cheque', 'cerrado','doc_afecta_long'
    ];
    public function usuario()
    {
        return $this->belongsTo('App\User');
    }
    public function tercero()
    {
        return $this->belongsTo('App\Persona');
    }
}
