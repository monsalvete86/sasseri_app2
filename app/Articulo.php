<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table = 'articulos';
    protected $fillable =[
        'id','idcategoria','idcategoria2','codigo','nombre','precio_venta','stock','descripcion','cod_invima','lote','fec_vence','minimo','tipo_articulo','iva','talla','marca','linea','id_und_medida','id_concentracion','id_presentacion','descripcion','condicion','img','id_usuario','id_empresa'
    ];
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }

    public function und_medida(){
        return $this->belongsTo('App\UndMedida');
    }

    public function consentracion(){
        return $this->belongsTo('App\Concentracion');
    }

    public function presentacion(){
        return $this->belongsTo('App\Presentacion');
    }
    public function detalle_factura(){
        return $this->belongsTo('App\DetalleFacturacion');
    }
}
