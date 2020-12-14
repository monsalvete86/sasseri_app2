<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Ingreso;
use App\DetalleIngreso;
use App\Stock;
use App\Cuentas;
use App\Formatos;
use App\Articulo;
use Illuminate\Support\Facades\Auth;

class IngresoController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        
        if ($buscar==''){
            $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
            ->join('users','ingresos.idusuario','=','users.id')
            ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante',
            'ingresos.num_comprobante','ingresos.tipo_ingreso','ingresos.fecha_hora','ingresos.impuesto','ingresos.total','ingresos.forma_pago','ingresos.flete','ingresos.fecha_ingreso','detalle',
            'ingresos.estado','ingresos.idproveedor','personas.nombre','personas.nombre1','personas.apellido1','personas.num_documento','personas.regimen','users.usuario','ingresos.saldo_parcial','ingresos.iva_incluido','valor_iva')
            ->where('ingresos.id_empresa','=',$id_empresa)
            ->orderBy('ingresos.id', 'desc')->paginate(3);
        }
        else{
            $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
            ->join('users','ingresos.idusuario','=','users.id')
            ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante',
            'ingresos.num_comprobante','ingresos.tipo_ingreso','ingresos.fecha_hora','ingresos.impuesto','ingresos.total','ingresos.forma_pago','ingresos.flete','ingresos.fecha_ingreso','detalle',
            'ingresos.estado','ingresos.idproveedor','personas.nombre','personas.nombre1','personas.apellido1','personas.num_documento','personas.regimen','users.usuario','ingresos.saldo_parcial','ingresos.iva_incluido','valor_iva')
            ->where('ingresos.id_empresa','=',$id_empresa)
            ->where('ingresos.'.$criterio, 'like', '%'. $buscar . '%')->orderBy('ingresos.id', 'desc')->paginate(3);
        }
        
        return [
            'pagination' => [
                'total'        => $ingresos->total(),
                'current_page' => $ingresos->currentPage(),
                'per_page'     => $ingresos->perPage(),
                'last_page'    => $ingresos->lastPage(),
                'from'         => $ingresos->firstItem(),
                'to'           => $ingresos->lastItem(),
            ],
            'ingresos' => $ingresos
        ];
    }
    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $id = $request->id;
        $ingreso = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
        ->join('users','ingresos.idusuario','=','users.id')
        ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante',
        'ingresos.num_comprobante','ingresos.tipo_ingreso','ingresos.fecha_hora','ingresos.impuesto','ingresos.total','ingresos.forma_pago','ingresos.flete','ingresos.fecha_ingreso','detalle',
        'ingresos.estado','personas.nombre','personas.nombre1','personas.apellido1','personas.num_documento','personas.regimen','users.usuario')
        ->where('ingresos.id_empresa','=',$id_empresa)
        ->where('ingresos.id','=',$id)
        ->orderBy('ingresos.id', 'desc')->take(1)->get();
        
        return ['ingreso' => $ingreso];
    }
    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $detalles = DetalleIngreso::join('articulos','detalle_ingresos.idarticulo','=','articulos.id')
        ->select('detalle_ingresos.cantidad','detalle_ingresos.precio','detalle_ingresos.porcentaje_iva as porcentaje','articulos.nombre as articulo')
        ->where('detalle_ingresos.idingreso','=',$id)
        ->orderBy('detalle_ingresos.id', 'desc')->get();
        
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

            $ingreso = new Ingreso();
            
            
            $ingreso->idusuario = \Auth::user()->id;
            $ingreso->idproveedor = $request->idproveedor;
            $ingreso->tipo_comprobante = $request->tipo_comprobante;
            $ingreso->serie_comprobante = $request->serie_comprobante;
            $ingreso->num_comprobante = $request->num_comprobante;
            $ingreso->tipo_ingreso = $request->tipo_ingreso;
            $ingreso->fecha_hora = $mytime->toDateString();
            $ingreso->impuesto = $request->impuesto;
            $ingreso->total = $request->total;
            $ingreso->forma_pago = $request->forma_pago;
            $ingreso->flete = $request->flete;
            $ingreso->fecha_ingreso = $request->fecha_ingreso;
            $ingreso->detalle = $request->detalle;
            $ingreso->saldo_parcial = $request->saldo_parcial;
            $ingreso->iva_incluido = $request->iva_incluido;
            $ingreso->valor_iva = $request->valor_iva;
            $ingreso->estado = 'Registrado';
            $ingreso->id_empresa = $id_empresa;
            $ingreso->save();

            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            $debe = 0;
            $haber = 0;
            $cuenta = '';
            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleIngreso();
                $detalle->idingreso = $ingreso->id;
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

                if($ingreso->tipo_ingreso != 'Saldos iniciales')
                {
                    $debe = $debe+$detalle->precio;
                }
                else
                {
                    $haber = $haber+$detalle->precio;
                }

                if($ingreso->tipo_ingreso=='Compras'){
                    $id_cuenta = $cuentasArticulo[0]['idCuentaProductos'];
                }elseif($ingreso->tipo_ingreso=='Devoluciones'){
                    $id_cuenta = $cuentasArticulo[0]['idCuentaDevolucionesCompras'];
                }elseif($ingreso->tipo_ingreso=='Saldos iniciales'){
                    $id_cuenta = $cuentasArticulo[0]['idCuentaSaldosIniciales'];
                }elseif($ingreso->tipo_ingreso=='Donaciones'){
                    $id_cuenta = $cuentasArticulo[0]['idCuentaDonaciones'];
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
            $cuentas->id_formato = $ingreso->id;

            if($request->tipo_ingreso!='Saldos iniciales'){
                $id_tercero = $ingreso->idproveedor;
            }else{
                $id_tercero = -1;
            }

            /*$cuentasArticulo = Articulos::leftJoin('cateorias','articulos.idcategoria','categorias.id')
            ->select('articulos.id','articulos.idcategoria','categorias.nombre','categorias.idCuentaProductos','categorias.idCuentaSalidaProductos','idCuentaSaldosIniciales','idCuentaDonaciones')
            ->where('articulos.id','=',$detalle->idarticulo)
            ->get();*/


            $cuentas->numero = $Numero;
            $cuentas->tercero = $id_tercero;
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

            $ingreso = Ingreso::findOrFail($request->id);
            
            
            $ingreso->idusuario = \Auth::user()->id;
            $ingreso->idproveedor = $request->idproveedor;
            $ingreso->tipo_comprobante = $request->tipo_comprobante;
            $ingreso->serie_comprobante = $request->serie_comprobante;
            $ingreso->num_comprobante = $request->num_comprobante;
            $ingreso->tipo_ingreso = $request->tipo_ingreso;
            $ingreso->fecha_hora = $mytime->toDateString();
            $ingreso->impuesto = $request->impuesto;
            $ingreso->total = $request->total;
            $ingreso->forma_pago = $request->forma_pago;
            $ingreso->flete = $request->flete;
            $ingreso->fecha_ingreso = $request->fecha_ingreso;
            $ingreso->detalle = $request->detalle;
            $ingreso->saldo_parcial = $request->saldo_parcial;
            $ingreso->iva_incluido = $request->iva_incluido;
            $ingreso->valor_iva = $request->valor_iva;
            $ingreso->save();

            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            $debe = 0;
            $haber = 0;
            $cuenta = '';

            $borrar_detalles = DetalleIngreso::where('idingreso','=',$ingreso->id)->delete();
            
            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleIngreso();
                $detalle->idingreso = $ingreso->id;
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
        $ingreso = Ingreso::findOrFail($request->id);
        $ingreso->estado = 'Anulado';
        $ingreso->save();
    }

    public function cerrar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        // numero de formato
        
        $formatoCompras = DB::table('formatos_procesos')->select('idFormatoCompras')->where('id_empresa','=',$id_empresa)->get();
        $tipo_formato = $formatoCompras[0]->idFormatoCompras;

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

        $cons = 'SELECT sum(detalle_ingresos.precio) as total_precio, sum(detalle_ingresos.vr_iva) as total_iva,modelo_contable.idCuentaProductos,detalle_ingresos.cantidad,detalle_ingresos.precio,articulos.nombre as articulo,articulos.idcategoria,modelo_contable.nombre,plan_cuentas.codigo FROM `detalle_ingresos`, articulos ,modelo_contable, plan_cuentas WHERE idingreso='.$request->id.' and articulos.id = detalle_ingresos.idarticulo and articulos.idcategoria = modelo_contable.id and modelo_contable.idCuentaProductos = plan_cuentas.id group by modelo_contable.idCuentaProductos';

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
            $cuentas->debe = $det->total_iva;
            $cuentas->haber = $det->total_precio;
            $cuentas->centro_costos = null;
            $cuentas->doc_externo = $request->id;
            $cuentas->detalle = $request->detalle;
            $cuentas->fecha = $request->fecha;
            $cuentas->base_graba = null;
            $cuentas->usuario = $id_usuario;
            $cuentas->cerrado = 0;
            $cuentas->condicion = 1;
            $cuentas->cuenta = $det->idCuentaProductos;
            $cuentas->num_cuenta = $det->codigo;
            $cuentas->doc_afecta_long = '"';
            $cuentas->saldo_cuent = null;
            $cuentas->save();

            $ingreso = Ingreso::findOrFail($request->id);
            $ingreso->estado = 'Cerrado';
            $ingreso->save();
        }
    }
}
