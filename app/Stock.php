<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';
    protected $fillable =[
        'id', 'id_producto', 'id_usuario', 'fec_crea', 'cantidad', 'tipo_movimiento', 'sumatoria', 'condicion'
    ];
    public function producto(){
        return $this->belongsTo('App\Articulo');
    }

    public function usuario(){
        return $this->belongsTo('App\User');
    }
}
