<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Egreso;
use App\DetalleEgreso;
use App\Stock;
use App\Cuentas;
use App\Formatos;
use App\Articulo;
use Illuminate\Support\Facades\Auth;

class EgresosController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        
        if ($buscar==''){
            $egresos = Egreso::join('personas','egresos.idproveedor','=','personas.id')
            ->join('users','egresos.idusuario','=','users.id')
            ->select('egresos.id','egresos.tipo_comprobante','egresos.serie_comprobante',
            'egresos.num_comprobante','egresos.tipo_egreso','egresos.fecha_hora','egresos.impuesto','egresos.total','egresos.forma_pago','egresos.flete','egresos.fecha_egreso','detalle',
            'egresos.estado','egresos.idproveedor','personas.nombre','personas.nombre1','personas.apellido1','personas.num_documento','personas.regimen','users.usuario','egresos.saldo_parcial','egresos.iva_incluido','valor_iva')
            ->where('egresos.id_empresa','=',$id_empresa)
            ->orderBy('egresos.id', 'desc')->paginate(3);
        }
        else{
            $egresos = Egreso::join('personas','egresos.idproveedor','=','personas.id')
            ->join('users','egresos.idusuario','=','users.id')
            ->select('egresos.id','egresos.tipo_comprobante','egresos.serie_comprobante',
            'egresos.num_comprobante','egresos.tipo_egreso','egresos.fecha_hora','egresos.impuesto','egresos.total','egresos.forma_pago','egresos.flete','egresos.fecha_egreso','detalle',
            'egresos.estado','egresos.idproveedor','personas.nombre','personas.nombre1','personas.apellido1','personas.num_documento','personas.regimen','users.usuario','egresos.saldo_parcial','egresos.iva_incluido','valor_iva')
            ->where('egresos.id_empresa','=',$id_empresa)
            ->where('egresos.'.$criterio, 'like', '%'. $buscar . '%')->orderBy('egresos.id', 'desc')->paginate(3);
        }
        
        return [
            'pagination' => [
                'total'        => $egresos->total(),
                'current_page' => $egresos->currentPage(),
                'per_page'     => $egresos->perPage(),
                'last_page'    => $egresos->lastPage(),
                'from'         => $egresos->firstItem(),
                'to'           => $egresos->lastItem(),
            ],
            'egresos' => $egresos
        ];
    }
    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $id = $request->id;
        $egreso = Egreso::join('personas','egresos.idproveedor','=','personas.id')
        ->join('users','egresos.idusuario','=','users.id')
        ->select('egresos.id','egresos.tipo_comprobante','egresos.serie_comprobante',
        'egresos.num_comprobante','egresos.tipo_egreso','egresos.fecha_hora','egresos.impuesto','egresos.total','egresos.forma_pago','egresos.flete','egresos.fecha_egreso','detalle',
        'egresos.estado','personas.nombre','personas.nombre1','personas.apellido1','personas.num_documento','personas.regimen','users.usuario')
        ->where('egresos.id_empresa','=',$id_empresa)
        ->where('egresos.id','=',$id)
        ->orderBy('egresos.id', 'desc')->take(1)->get();
        
        return ['egreso' => $egreso];
    }
    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $detalles = DetalleEgreso::join('articulos','detalle_egresos.idarticulo','=','articulos.id')
        ->select('detalle_egresos.cantidad','detalle_egresos.precio','detalle_egresos.porcentaje_iva as porcentaje','articulos.nombre as articulo')
        ->where('detalle_egresos.idegreso','=',$id)
        ->orderBy('detalle_egresos.id', 'desc')->get();
        
        return ['detalles' => $detalles];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        try{
            DB::beginTransaction();

            $mytime= Carbon::now('America/Lima');

            $egreso = new Egreso();
            
            
            $egreso->idusuario = \Auth::user()->id;
            $egreso->idproveedor = $request->idproveedor;
            $egreso->tipo_comprobante = $request->tipo_comprobante;
            $egreso->serie_comprobante = $request->serie_comprobante;
            $egreso->num_comprobante = $request->num_comprobante;
            $egreso->tipo_egreso = $request->tipo_egreso;
            $egreso->fecha_hora = $mytime->toDateString();
            $egreso->impuesto = $request->impuesto;
            $egreso->total = $request->total;
            $egreso->forma_pago = $request->forma_pago;
            $egreso->flete = $request->flete;
            $egreso->fecha_egreso = $request->fecha_egreso;
            $egreso->detalle = $request->detalle;
            $egreso->saldo_parcial = $request->saldo_parcial;
            $egreso->iva_incluido = $request->iva_incluido;
            $egreso->valor_iva = $request->valor_iva;
            $egreso->estado = 'Registrado';
            $egreso->id_empresa = $id_empresa;
            $egreso->save();

            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            $debe = 0;
            $haber = 0;
            $cuenta = '';
            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleEgreso();
                $detalle->idegreso = $egreso->id;
                $detalle->idarticulo = $det['idarticulo'];
                if($det['padre']!='')
                {
                    $detalle->cantidad = $det['cantidad']*$det['unidades'];
                }
                else
                {
                    $detalle->cantidad = $det['cantidad'];
                }
                $detalle->precio = $det['precio'];  
                $detalle->vr_iva = $det['iva_individual'];
                if($request->regimen_proveedor!='Simplificado')
                {
                    if($request->iva_incluido==1){
                        $subtotal=($det['precio']*$det['cantidad'])-$det['iva_individual'];
                    }else{$subtotal=$det['precio']*$det['cantidad'];}
                }else{$subtotal=$det['precio']*$det['cantidad'];}
                $detalle->precio_total = $subtotal+$det['iva_individual'];
                $detalle->porcentaje_iva = $det['porcentaje'];
                $detalle->id_usuario = $id_usuario;        
                $detalle->save();

                $stock = new Stock();
                $stock->id_producto = $det['idarticulo'];
                $stock->id_usuario = $id_usuario;
                if($det['padre']!='')
                {
                    $stock->cantidad = $det['cantidad']*$det['unidades'];
                }
                else
                {
                    $stock->cantidad = $det['cantidad'];
                }
                $stock->tipo_movimiento = $request->tipo_movimiento;
                $stock->sumatoria = $request->sumatoria;
                $stock->save();

                $cuentasArticulo = Articulo::leftJoin('modelo_contable','articulos.idcategoria','modelo_contable.id')
                ->select('articulos.id','articulos.idcategoria','modelo_contable.nombre','modelo_contable.idCuentaProductos','modelo_contable.idCuentaSalidaProductos','idCuentaSaldosIniciales','idCuentaDonaciones','idCuentaDevolucionesVentas','idCuentaDevolucionesCompras','idCuentaImpuestoConsumoVentas')
                ->where('articulos.id','=',$detalle->idarticulo)
                ->get();

                if($egreso->tipo_egreso != 'Saldos iniciales')
                {
                    $debe = $debe+$detalle->precio;
                }
                else
                {
                    $haber = $haber+$detalle->precio;
                }

                if($egreso->tipo_egreso=='Bajas'){
                    $id_cuenta = $cuentasArticulo[0]['idCuentaSalidaProductos'];
                }elseif($egreso->tipo_egreso=='Ajuste inventario'){
                    $id_cuenta = $cuentasArticulo[0]['idCuentaSalidaProductos'];
                }elseif($egreso->tipo_egreso=='Devoluciones'){
                    $id_cuenta = $cuentasArticulo[0]['idCuentaDevolucionesCompras'];
                }
            }

            $formatos = array();

            $formatos = DB::table('formatos')->select('numero')->where('formato','=',$request->tipo_formato)->orderBy('id','desc')->limit(1)->get();
            
            if(count($formatos)<=0) 
                $Numero=1;
            else           
                $Numero = (int) $formatos[0]->numero + 1;
                
            if(strlen($Numero)==1){ $Numero = "0000".$Numero;}
            if(strlen($Numero)==2){ $Numero = "000".$Numero;}
            if(strlen($Numero)==3){ $Numero = "00".$Numero;}
            if(strlen($Numero)==4){ $Numero = "0".$Numero;}

            $cuentas = new Cuentas();
            $cuentas->id_formato = $egreso->id;

            /*$cuentasArticulo = Articulos::leftJoin('cateorias','articulos.idcategoria','categorias.id')
            ->select('articulos.id','articulos.idcategoria','categorias.nombre','categorias.idCuentaSalidaProductos','categorias.idCuentaSalidaProductos','idCuentaSaldosIniciales','idCuentaDonaciones')
            ->where('articulos.id','=',$detalle->idarticulo)
            ->get();*/


            $cuentas->numero = $Numero;
            $cuentas->tercero = $egreso->idproveedor;
            $cuentas->debe = $debe;
            $cuentas->haber = $haber;
            $cuentas->doc_externo = 1;
            $cuentas->fecha = '2019-06-07';
            $cuentas->usuario = $id_usuario;
            $cuentas->cuenta = $id_cuenta;
            $cuentas->save();

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        try{
            DB::beginTransaction();

            $mytime= Carbon::now('America/Lima');

            $egreso = Egreso::findOrFail($request->id);
            
            
            $egreso->idusuario = \Auth::user()->id;
            $egreso->idproveedor = $request->idproveedor;
            $egreso->tipo_comprobante = $request->tipo_comprobante;
            $egreso->serie_comprobante = $request->serie_comprobante;
            $egreso->num_comprobante = $request->num_comprobante;
            $egreso->tipo_egreso = $request->tipo_egreso;
            $egreso->fecha_hora = $mytime->toDateString();
            $egreso->impuesto = $request->impuesto;
            $egreso->total = $request->total;
            $egreso->forma_pago = $request->forma_pago;
            $egreso->flete = $request->flete;
            $egreso->fecha_egreso = $request->fecha_egreso;
            $egreso->detalle = $request->detalle;
            $egreso->saldo_parcial = $request->saldo_parcial;
            $egreso->iva_incluido = $request->iva_incluido;
            $egreso->valor_iva = $request->valor_iva;
            $egreso->save();

            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            $debe = 0;
            $haber = 0;
            $cuenta = '';

            $borrar_detalles = DetalleEgreso::where('idegreso','=',$egreso->id)->delete();
            
            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleEgreso();
                $detalle->idegreso = $egreso->id;
                $detalle->idarticulo = $det['idarticulo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];  
                $detalle->vr_iva = $det['iva_individual'];
                if($request->regimen_proveedor!='Simplificado')
                {
                    if($request->iva_incluido==1){
                        $subtotal=($det['precio']*$det['cantidad'])-$det['iva_individual'];
                    }else{$subtotal=$det['precio']*$det['cantidad'];}
                }else{$subtotal=$det['precio']*$det['cantidad'];}
                $detalle->precio_total = $subtotal+$det['iva_individual'];
                $detalle->porcentaje_iva = $det['porcentaje'];
                $detalle->id_usuario = $id_usuario;        
                $detalle->save();

                // $stock = new Stock();
                // $stock->id_producto = $det['idarticulo'];
                // $stock->id_usuario = $id_usuario;
                // $stock->cantidad = $det['cantidad'];
                // $stock->tipo_movimiento = $request->tipo_movimiento;
                // $stock->sumatoria = $request->sumatoria;
                // $stock->save();
            }

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $egreso = Egreso::findOrFail($request->id);
        $egreso->estado = 'Anulado';
        $egreso->save();
    }

    public function cerrar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        // numero de formato
        
        $formatoCompras = DB::table('formatos_procesos')->select('idFormatoSalidas')->where('id_empresa','=',$id_empresa)->get();
        $tipo_formato = $formatoCompras[0]->idFormatoSalidas;

        $formatos = array();

        $formatos = DB::table('formatos')->select('numero')->where('formato','=',$tipo_formato)->orderBy('id','desc')->limit(1)->get();
        
        if(count($formatos)<=0) 
            $Numero=1;
        else           
            $Numero = (int) $formatos[0]->numero + 1;
            
        if(strlen($Numero)==1){ $Numero = "0000".$Numero;}
        if(strlen($Numero)==2){ $Numero = "000".$Numero;}
        if(strlen($Numero)==3){ $Numero = "00".$Numero;}
        if(strlen($Numero)==4){ $Numero = "0".$Numero;}

        $cons = 'SELECT sum(detalle_egresos.precio) as total_precio, sum(detalle_egresos.vr_iva) as total_iva,modelo_contable.idCuentaSalidaProductos,detalle_egresos.cantidad,detalle_egresos.precio,articulos.nombre as articulo,articulos.idcategoria,modelo_contable.nombre,plan_cuentas.codigo FROM `detalle_egresos`, articulos ,modelo_contable, plan_cuentas WHERE idegreso='.$request->id.' and articulos.id = detalle_egresos.idarticulo and articulos.idcategoria = modelo_contable.id and modelo_contable.idCuentaSalidaProductos = plan_cuentas.id group by modelo_contable.idCuentaSalidaProductos';

        $detalles = DB::select($cons);
        
        // crear el formato nuevo
        $formato = new Formatos();
        $formato->numero = $Numero;
        $formato->formato = $tipo_formato;
        $formato->tercero = $request->tercero;
        $formato->fecha = $request->fecha;
        $formato->detalle = $request->detalle;
        $formato->condicion = 1;
        $formato->usuario = $id_usuario;
        $formato->subtotal = $request->total-$request->vr_impuesto;
        $formato->impuesto = null;
        $formato->vr_impuesto = $request->vr_impuesto;
        $formato->total = $request->total;
        $formato->debes = $request->total;
        $formato->haberes = $request->total;
        $formato->doc_externo = $request->id;
        $formato->tipo_doc_externo = 'Compras';
        $formato->doc_afecta = null;
        $formato->banco = null;
        $formato->forma_pago = '';
        $formato->num_cheque = null;
        $formato->cerrado = 0;
        $formato->doc_afecta_long = null;
        $formato->id_empresa = $id_empresa;
        $formato->id_retencion = null;
        $formato->save();

        foreach($detalles as $det)
        {
            $cuentas = new Cuentas();
            $cuentas->id_formato = $formato->id;
            $cuentas->numero = $Numero;
            $cuentas->tercero = $request->tercero;
            $cuentas->debe = $det->total_precio;
            $cuentas->haber = $det->total_iva;
            $cuentas->centro_costos = null;
            $cuentas->doc_externo = $request->id;
            $cuentas->detalle = $request->detalle;
            $cuentas->fecha = $request->fecha;
            $cuentas->base_graba = null;
            $cuentas->usuario = $id_usuario;
            $cuentas->cerrado = 0;
            $cuentas->condicion = 1;
            $cuentas->cuenta = $det->idCuentaSalidaProductos;
            $cuentas->num_cuenta = $det->codigo;
            $cuentas->doc_afecta_long = '"';
            $cuentas->saldo_cuent = null;
            $cuentas->save();

            $egreso = Egreso::findOrFail($request->id);
            $egreso->estado = 'Cerrado';
            $egreso->save();
        }
    }
}
