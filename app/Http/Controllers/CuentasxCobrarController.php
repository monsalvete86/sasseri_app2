<?php

namespace App\Http\Controllers;

use App\CuentasxCobrar;
use App\AbonoCobrar;
use App\Persona;
use App\Facturacion;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CuentasxCobrarController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        
        
        $Btercero_id = "";
        $Bfactura ="";
        $Bestado ="";
        $Bdesde ="";
        $Bhasta ="";  
             
        if($request->tercero_id_filtro!='') $Btercero_id="and cuentas_x_cobrar.id_tercero =".$request->tercero_id_filtro;
        if($request->Bfactura!='') $Bfactura=" and facturacion.num_factura = ".$request->Bfactura;
        if($request->Bestado!='') $Bestado="and cuentas_x_cobrar.estado_cobro = ".$request->Bestado;  
        if($request->Bdesde!='') $Bdesde="and cuentas_x_cobrar.fecha_cobro >='".$request->Bdesde."'";   
        if($request->Bhasta!='') $Bhasta="and cuentas_x_cobrar.fecha_cobro <='".$request->Bhasta."'";   
        
        
       /* $cons="SELECT cuentas_x_cobrar.id, cuentas_x_cobrar.id_tercero,cuentas_x_cobrar.valor_deuda,cuentas_x_cobrar.abono,cuentas_x_cobrar.saldo,cuentas_x_cobrar.fecha_cobro,cuentas_x_cobrar.estado_cobro,cuentas_x_cobrar.id_factura,cuentas_x_cobrar.sin_factura,cuentas_x_cobrar.id_empresa,cuentas_x_cobrar.id_pago,personas.num_documento,personas.nombre1,personas.nombre2,personas.apellido1,personas.apellido2,facturacion.num_factura FROM cuentas_x_cobrar JOIN personas on personas.id = cuentas_x_cobrar.id_tercero LEFT JOIN facturacion on cuentas_x_cobrar.id_factura = facturacion.id  where cuentas_x_cobrar.id_empresa = $id_empresa  $Bfactura $Bestado  $Bdesde $Bhasta $Btercero_id 
         ";*/
         $cons="SELECT cuentas_x_cobrar.id, cuentas_x_cobrar.id_tercero,cuentas_x_cobrar.num_pago,cuentas_x_cobrar.valor_deuda,cuentas_x_cobrar.abono,cuentas_x_cobrar.saldo,cuentas_x_cobrar.fecha_cobro,cuentas_x_cobrar.estado_cobro,cuentas_x_cobrar.id_factura,cuentas_x_cobrar.sin_factura,cuentas_x_cobrar.id_empresa,cuentas_x_cobrar.id_pago,personas.num_documento,personas.nombre1,personas.nombre2,personas.apellido1,personas.apellido2,facturacion.num_factura FROM cuentas_x_cobrar JOIN personas on personas.id = cuentas_x_cobrar.id_tercero  LEFT JOIN facturacion on cuentas_x_cobrar.id_factura = facturacion.id  where cuentas_x_cobrar.id_empresa = $id_empresa  $Bfactura $Bestado  $Bdesde $Bhasta $Btercero_id 
         ";
       
        $cuentasxcobrar = DB::select($cons);     
            
    
     
       foreach($cuentasxcobrar as $key=> $cc){
            //echo "valor=".$cuentasxcobrar[$key]->valor_deuda;           
            $cuentasxcobrar[$key]->valor_deuda_moneda = number_format($cc->valor_deuda,0);
            $cuentasxcobrar[$key]->abono_moneda = number_format($cc->abono,0);  
            $cuentasxcobrar[$key]->saldo_moneda = number_format($cc->saldo,0);         
           // print_r($cuentasxcobrar[$key]->id);
           
        }

        $cons1="SELECT cuentas_x_cobrar.valor_deuda FROM cuentas_x_cobrar where cuentas_x_cobrar.id_empresa = $id_empresa $Bestado $Bdesde $Bhasta $Btercero_id";
        $cons2="SELECT cuentas_x_cobrar.abono FROM cuentas_x_cobrar where cuentas_x_cobrar.id_empresa = $id_empresa  $Bestado $Bdesde $Bhasta $Btercero_id";

        $valor_deuda = DB::select($cons1);
        $valor_abono = DB::select($cons2);
         //$valor_deuda = CuentasxCobrar::select('cuentas_x_cobrar.valor_deuda')->where('estado_cobro','!=','2')->where('estado_cobro','!=','3')->get();
         //$valor_abono = CuentasxCobrar::select('cuentas_x_cobrar.abono')->where('estado_cobro','!=','2')->where('estado_cobro','!=','3')->get();
         //$valor_saldo = CuentasxCobrar::select('cuentas_x_cobrar.saldo')->get();
        
        $suma_valor_deuda = 0;
        $total_valor = 0;
        foreach($valor_deuda as $v)
        {
            $suma_valor_deuda = $suma_valor_deuda+$v->valor_deuda;
            $total_valor = number_format($suma_valor_deuda,0);
        }
        $suma_abono = 0;
        $total_abono = 0;
        foreach($valor_abono as $a)
        {
            $suma_abono = $suma_abono+$a->abono;
            $total_abono = number_format($suma_abono,0);
            
        }

        $suma_saldo = $suma_valor_deuda - $suma_abono;
        $total_saldo = number_format($suma_saldo,0);

        /*foreach($valor_saldo as $s)
        {
            $suma_saldo = $suma_saldo+$s->saldo;
            $total_saldo = number_format($suma_saldo,0);
        }*/
        
        //print_r($cuentasxcobrar);
        return [
            'cuentas' => $cuentasxcobrar,
            'sumaValor' => $total_valor,
            'sumaAbono' => $total_abono,
            'sumaSaldo' => $total_saldo
        ];
    }

    public function saldo(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $abonoNuevo = $request->abonoPago;
        $abonos = AbonoCobrar::select('id','abono','fecha_cobro','estado_abono')->where('id_empresa','=',$id_empresa)->where('id_pago','=',$request->id)->orderBy('estado_abono','=','desc')->get();
        $abonos2 = AbonoCobrar::select('id','abono','fecha_cobro','estado_abono')->where('id_empresa','=',$id_empresa)->where('id_pago','=',$request->id)->where('estado_abono','=','1')->get();
        
        foreach($abonos as $key=> $aa){
            $abonos[$key]->abonos_tercero_moneda = number_format($aa->abono,0);
           
        }
        
   
        $suma_tercero_abono = 0;
        $total_tercero_abonos = 0;
        foreach($abonos2 as $v)
        {
            $suma_tercero_abono = $suma_tercero_abono+$v->abono;
            $total_tercero_abonos = number_format($suma_tercero_abono,0);
        }
     
        return ['valido' => $abonos,
                'suma_tercero_abonos' => $total_tercero_abonos];
    }

 
    public function store(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;
        $valor = $request->valor_deuda;
        $abono = $request->abono;

        
        $cuenta = new CuentasxCobrar();
        $cuenta->id_tercero = $request->id_tercero;
        $cuenta->valor_deuda = $request->valor_deuda;
        $cuenta->abono = $abono;
        $cuenta->fecha_cobro = $request->fecha;
       
        $saldo_debe = $valor - $abono;
        if($saldo_debe<=0){
            $cuenta->estado_cobro = '3';
        }
        if($saldo_debe>0){
            $cuenta->estado_cobro = '1';
        }
        
        $cuenta->saldo = $saldo_debe;
        $cuenta->sin_factura = '1';
        $cuenta->id_empresa = $id_empresa;
        $cuenta->usu_crea = $id_usuario;
        $cuenta->save();

        $cuenta1 = new AbonoCobrar();
        $cuenta1->num_pago = '1';
        $cuenta1->id_pago = $cuenta->id;
        $cuenta1->abono = $request->abono;
        $cuenta1->estado_abono = '1';
        $cuenta1->fecha_cobro = $request->fecha;
        $cuenta1->id_empresa = $id_empresa;
        $cuenta1->usu_crea = $id_usuario;
        $cuenta1->save();

        $cuenta2 = CuentasxCobrar::findOrFail($cuenta->id);
        $cuenta2->id_pago = $cuenta->id;
        $cuenta2->save();
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
 
    public function abono(Request $request)
    {
         //if (!$request->ajax()) return redirect('/'); 
         
          //print_r( $request->abonoPago); exit;
         $id_empresa = $request->session()->get('id_empresa');
         $id_usuario = Auth::user()->id; 
         $valor = $request->valor_deuda;
         $abono = $request->abono;
         $saldo = $request->saldo;
         $abonoNuevo = $request->abonoPago;
         $abonoActual= ($abonoNuevo + $abono);
         $cuenta = new AbonoCobrar();
         $cuenta->abono = $request->abonoPago;
         $cuenta->fecha_cobro = $request->fecha;
         $cuenta->id_pago = $request->id_pago;
         $cuenta->usu_crea = $id_usuario;
         $cuenta->id_empresa = $id_empresa;
          //Insertar numero consecutivo
          $cuentas = array();
          $cuentas = DB::table('abono_cobrar')->select('num_pago')->where('id_pago','=',$request->id_pago)->orderBy('id','desc')->limit(1)->get();
          
          if(count($cuentas)<=0)
              $num_pago = 1;
          else
              $num_pago = (int) $cuentas[0]->num_pago + 1;
          ///////////////   
         $cuenta->num_pago = $num_pago;
         $cuenta->estado_abono = '1';
         $cuenta->save();

         $abonos = AbonoCobrar::select('abono')->where('id_pago','=',$request->id_pago)->where('estado_abono','=','1')->get();
         $totalAbonos = 0;
         foreach($abonos as $a)
         {
             $totalAbonos = $totalAbonos+$a->abono;
         }
        
         $cuenta2 = CuentasxCobrar::findOrFail($request->id_pago);
         $cuenta2->abono = $totalAbonos;

         $saldo_debe = ($saldo - $abonoNuevo);
         if($saldo_debe<=0){
            $cuenta2->estado_cobro = '3';
        }
        if($saldo_debe>0){
            $cuenta2->estado_cobro = '1';
        }
         $cuenta2->saldo = $saldo_debe;
         $cuenta2->num_pago = '2';
         $cuenta2->sin_factura = '1'; 
         $cuenta2->id_empresa = $id_empresa;
         $cuenta2->usu_crea = $id_usuario;
         $cuenta2->save();
    }

    public function update(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id; 
        $valor = $request->valor_deuda;
        $abono = $request->abono;
        $saldo = $request->saldo;
        $cuenta = CuentasxCobrar::findOrFail($request->id);
        $cuenta->id_tercero = $request->id_tercero;
        $cuenta->valor_deuda = $request->valor_deuda;
        $cuenta->abono = $request->abono;
        $cuenta->fecha_cobro = $request->fecha;
        $saldo_debe = $valor - $abono;
        if($saldo_debe<=0){
            $cuenta->estado_cobro = '3';
        }
        if($saldo_debe>0){
            $cuenta->estado_cobro = '1';
        }
        $cuenta->saldo = $saldo_debe;
        
        $cuenta->sin_factura = '1'; 
        $cuenta->id_empresa = $id_empresa;
        $cuenta->usu_crea = $id_usuario;
        $cuenta->save();
        $idAbono = AbonoCobrar::select('id')->where('id_pago','=',$request->id_pago)->where('num_pago','=','1')->get();
        if(isset($idAbono))
        {
            foreach($idAbono as $d)
            {
                $id = $d['id'];
            }
        }
        
        if(isset($id))
        {
            $cuenta1 = AbonoCobrar::findOrFail($id);
            $cuenta1->abono = $request->abono;
            $cuenta1->fecha_cobro = $request->fecha;
            $cuenta1->save();
        }
        
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $desactivar = AbonoCobrar::select('id')->where('id_pago','=',$request->id)->get();
        if(isset($desactivar))
        {
            foreach($desactivar as $d)
            {   
                $cuentas = AbonoCobrar::findOrFail($d['id']);
                $cuentas->estado_abono = '0';
                $cuentas->save();
            }
        }
        $cuenta = CuentasxCobrar::findOrFail($request->id);
        $cuenta->estado_cobro = '2';
        $cuenta->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $activar = AbonoCobrar::select('id')->where('id_pago','=',$request->id)->get();
        if(isset($activar))
        {
            foreach($activar as $d)
            {   
                $cuentas = AbonoCobrar::findOrFail($d['id']);
                $cuentas->estado_abono = '1';
                $cuentas->save();
            }
        }
        $saldo = CuentasxCobrar::select('saldo')->where('id','=',$request->id)->get();

        $cuenta = CuentasxCobrar::findOrFail($request->id);
        $valorsaldo = (int) $saldo[0]->saldo;
        if($valorsaldo<=0){
            $cuenta->estado_cobro = '3';
        }
        if($valorsaldo>0){
            $cuenta->estado_cobro = '1';
        }
        
        $cuenta->save();
    }
    public function desactivarAbono(Request $request)
    {
       //if (!$request->ajax()) return redirect('/');
       try{
        DB::beginTransaction();
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id; 
        echo $id = $request->id;
        
    // $num = (int) $abonoActual[0]->num_pago - 1;
        $cuenta = AbonoCobrar::findOrFail($request->id);
        $cuenta->estado_abono = '0';
        $cuenta->id_empresa = $id_empresa;
        $cuenta->usu_crea = $id_usuario;
        $cuenta->save();
        echo $abonoD = AbonoCobrar::select('abono','id_pago')->where('id','=',$request->id)->get();
        foreach($abonoD as $a)
        {
            $abono = $a['abono'];
            $id_pago = $a['id_pago'];
        }
        $update = CuentasxCobrar::select('abono','saldo')->where('id','=',$id_pago)->get();
        foreach($update as $up)
        {
            $abonoAnt = $up['abono'];
            $saldo = $up['saldo'];
        }
        $cuenta1 = CuentasxCobrar::findOrFail($id_pago);
        $cuenta1->abono = $abonoAnt - $abono;
        $cuenta1->saldo = $saldo + $abono;
        $cuenta1->id_empresa = $id_empresa;
        $cuenta1->usu_crea = $id_usuario;
        $cuenta1->save();
            

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
}
