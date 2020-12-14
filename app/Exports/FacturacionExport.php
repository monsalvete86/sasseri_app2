<?php

namespace App\Exports;

use App\Facturacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

// class FacturacionExport implements FromCollection
// {
//     /**
//     * @return \Illuminate\Support\Collection
//     */
//     public function collection()
//     {
//         return Facturacion::all();
//     }
// }

class FacturacionExport implements FromView
{
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $cons="SELECT id,num_factura,id_tercero,fec_crea,fec_edita,usu_edita,subtotal,valor_iva,total,abono,abono as abono2,saldo,detalle,lugar,descuento,fec_registra,fec_envia,fec_anula,usu_registra,usu_envia,usu_anula,fecha,estado,id_usuario,id_cierre_caja FROM facturacion WHERE id=$this->id";
        $factura = DB::select($cons); 
        $factura = $factura[0];

        $cons2 = "SELECT detalle_facturacion.id,detalle_facturacion.id_factura,detalle_facturacion.id_producto,detalle_facturacion.padre,detalle_facturacion.valor_venta,detalle_facturacion.cantidad,detalle_facturacion.valor_iva,detalle_facturacion.valor_descuento,detalle_facturacion.porcentaje_iva,detalle_facturacion.valor_subtotal,detalle_facturacion.valor_final, articulos.nombre,articulos.idcategoria, articulos.idcategoria2,articulos.codigo,articulos.precio_venta,articulos.stock,articulos.descripcion,articulos.cod_invima,articulos.lote,articulos.fec_vence,articulos.minimo,articulos.tipo_articulo,articulos.iva, articulos.talla,articulos.id_und_medida,articulos.id_concentracion,articulos.id_presentacion,articulos.condicion, presentacion.nombre as nom_presentacion FROM detalle_facturacion,articulos, presentacion WHERE id_factura=".$factura->id." AND detalle_facturacion.id_producto=articulos.id AND articulos.id_presentacion=presentacion.id";
        $detalles = DB::select($cons2);

        $cons3="SELECT nombre1,nombre2,apellido1,apellido2,num_documento, tipo_documento FROM personas WHERE id=".$factura->id_tercero;
        $tercero = DB::select($cons3); 
        $tercero = $tercero[0];

        $cons4="SELECT * FROM users WHERE id=".$factura->id_usuario;
        $user = DB::select($cons4); 
        $user = $user[0];

        $cons5="SELECT * FROM cajas_cierres,cajas WHERE cajas_cierres.id=".$factura->id_cierre_caja.' AND cajas_cierres.id_caja=cajas.id';
        $caja = DB::select($cons5); 
        $caja = $caja[0];

        $cons6="SELECT * FROM zona WHERE zona.id=".$factura->lugar;
        $lugar = DB::select($cons6); 
        $lugar = $lugar[0];

        return view('pdf.FacturaExcel', [
            'facturacion' => $factura,
            'detalles' => $detalles,
            'tercero' => $tercero,
            'user' => $user,
            'caja' => $caja,
            'lugar' => $lugar,
        ]);
    }
}

?>