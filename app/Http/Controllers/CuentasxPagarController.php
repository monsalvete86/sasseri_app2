<?php

namespace App\Http\Controllers;
use App\CuentasxPagar;
use App\AbonoPagar;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CuentasxPagarController extends Controller
{   
    public function index(Request $request)
    {
    if (!$request->ajax()) return redirect('/');
    $id_empresa = $request->session()->get('id_empresa');

    $Btercero_id = "";
    $Bestado ="";
    $Bdesde ="";
    $Bhasta ="";  
         
    if($request->tercero_id_filtro!='') $Btercero_id="and cuentas_x_pagar.id_tercero =".$request->tercero_id_filtro;
    if($request->Bestado!='') $Bestado="and cuentas_x_pagar.estado_pago = ".$request->Bestado;  
    if($request->Bdesde!='') $Bdesde="and cuentas_x_pagar.fecha_pago >='".$request->Bdesde."'";   
    if($request->Bhasta!='') $Bhasta="and cuentas_x_pagar.fecha_pago <='".$request->Bhasta."'";   
    

    /*$cons="SELECT cuentas_x_pagar.id, cuentas_x_pagar.id_tercero,cuentas_x_pagar.valor_deuda,cuentas_x_pagar.abono,cuentas_x_pagar.saldo,cuentas_x_pagar.fecha_pago,cuentas_x_pagar.estado_pago,cuentas_x_pagar.id_empresa,personas.num_documento,personas.nombre1,personas.nombre2,personas.apellido1,personas.apellido2,abono_pagar.id as id_abono,abono_pagar.num_pago,abono_pagar.id_pago,abono_pagar.abono,abono_pagar.estado_abono FROM cuentas_x_pagar JOIN personas on personas.id = cuentas_x_pagar.id_tercero LEFT JOIN abono_pagar on cuentas_x_pagar.id = abono_pagar.id_pago where cuentas_x_pagar.id_empresa = $id_empresa $Bestado  $Bdesde $Bhasta $Btercero_id";*/
    $cons="SELECT cuentas_x_pagar.id, cuentas_x_pagar.id_tercero,cuentas_x_pagar.id_pago,cuentas_x_pagar.num_pago,cuentas_x_pagar.valor_deuda,cuentas_x_pagar.abono,cuentas_x_pagar.saldo,cuentas_x_pagar.fecha_pago,cuentas_x_pagar.estado_pago,cuentas_x_pagar.id_empresa,personas.num_documento,personas.nombre1,personas.nombre2,personas.apellido1,personas.apellido2 FROM cuentas_x_pagar JOIN personas on personas.id = cuentas_x_pagar.id_tercero  where cuentas_x_pagar.id_empresa = $id_empresa $Bestado  $Bdesde $Bhasta $Btercero_id";

    $cuentasxpagar = DB::select($cons);

    foreach($cuentasxpagar as $key=> $cc){
        $cuentasxpagar[$key]->valor_deuda_moneda = number_format($cc->valor_deuda,0);
        $cuentasxpagar[$key]->abono_moneda = number_format($cc->abono,0);
        $cuentasxpagar[$key]->saldo_moneda = number_format($cc->saldo,0);
    }

    $cons1="SELECT cuentas_x_pagar.valor_deuda FROM cuentas_x_pagar where cuentas_x_pagar.id_empresa = $id_empresa $Bestado $Bdesde $Bhasta $Btercero_id";
    $cons2="SELECT cuentas_x_pagar.abono FROM cuentas_x_pagar where cuentas_x_pagar.id_empresa = $id_empresa  $Bestado $Bdesde $Bhasta $Btercero_id";

    $valor_deuda = DB::select($cons1);
    $valor_abono = DB::select($cons2);
    //$valor_deuda = CuentasxPagar::select('cuentas_x_pagar.valor_deuda')->where('pago_ante','=','0')->where('estado_pago','!=','2')->where('estado_pago','!=','3')->get();
    //$valor_abono = CuentasxPagar::select('cuentas_x_pagar.abono')->where('estado_abono','=','0')->where('estado_pago','!=','2')->where('estado_pago','!=','3')->get();
   //$valor_saldo = CuentasxPagar::select('cuentas_x_pagar.saldo')->where('pago_ante','=','0')->where('estado_pago','!=','2')->where('estado_abono','=','0')->get();
   
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

    return [
        'cuentaspagar' => $cuentasxpagar,
        'sumaValor' => $total_valor,
        'sumaAbono' => $total_abono,
        'sumaSaldo' => $total_saldo
    ];
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

        $cuenta = new CuentasxPagar();
        $cuenta->id_tercero = $request->id_tercero;
        $cuenta->valor_deuda = $request->valor_deuda;
        $cuenta->abono = $abono;
        $cuenta->fecha_pago = $request->fecha;
       
        $saldo_debe = $valor - $abono;
        if($saldo_debe<=0){
            $cuenta->estado_pago = '3';
        }
        if($saldo_debe>0){
            $cuenta->estado_pago = '1';
        }
        
        $cuenta->saldo = $saldo_debe;
        $cuenta->id_empresa = $id_empresa;
        $cuenta->usu_crea = $id_usuario;
        $cuenta->save();

        $cuenta1 = new AbonoPagar();
        $cuenta1->num_pago = '1';
        $cuenta1->id_pago = $cuenta->id;
        $cuenta1->abono = $request->abono;
        $cuenta1->estado_abono = '1';
        $cuenta1->fecha_pago = $request->fecha;
        $cuenta1->id_empresa = $id_empresa;
        $cuenta1->usu_crea = $id_usuario;
        $cuenta1->save();

        $cuenta2 = CuentasxPagar::findOrFail($cuenta->id);
        $cuenta2->id_pago = $cuenta->id;
        $cuenta2->save();

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
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
            $cuenta = CuentasxPagar::findOrFail($request->id);
            $cuenta->id_tercero = $request->id_tercero;
            $cuenta->valor_deuda = $request->valor_deuda;
            $cuenta->abono = $request->abono;
            $cuenta->fecha_pago = $request->fecha;
            $saldo_debe = $valor - $abono;
            if($saldo_debe<=0){
                $cuenta->estado_pago = '3';
            }
            if($saldo_debe>0){
                $cuenta->estado_pago = '1';
            }
            $cuenta->saldo = $saldo_debe;
            
            $cuenta->id_empresa = $id_empresa;
            $cuenta->usu_crea = $id_usuario;
            $cuenta->save();

            $idAbono = AbonoPagar::select('id')->where('id_pago','=',$request->id_pago)->where('num_pago','=','1')->get();
            if(isset($idAbono))
            {
                foreach($idAbono as $d)
                {
                    $id = $d['id'];
                }
            }

            if(isset($id))
            {
                $cuenta1 = AbonoPagar::findOrFail($request->id_abono);
                $cuenta1->abono = $request->abono;
                $cuenta1->fecha_pago = $request->fecha;
                $cuenta1->save();
            }
            

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function saldo(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $abonoNuevo = $request->abonoPago;
        $abonos = AbonoPagar::select('id','abono','fecha_pago','estado_abono','id_pago')->where('id_empresa','=',$id_empresa)->where('id_pago','=',$request->id)->orderBy('estado_abono','=','desc')->get();
        $abonos2 = AbonoPagar::select('id','abono','fecha_pago','estado_abono')->where('id_empresa','=',$id_empresa)->where('id_pago','=',$request->id)->where('estado_abono','=','1')->get();
        
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
                'suma_tercero_abonos' => $total_tercero_abonos ];
    }
   
    public function abono(Request $request)
    {
         //if (!$request->ajax()) return redirect('/'); 
         try{
            DB::beginTransaction();
         $id_empresa = $request->session()->get('id_empresa');
         $id_usuario = Auth::user()->id; 
         $saldo = $request->saldo;
         $abonoNuevo = $request->abonoPago;
       
       
         
         $cuenta = new AbonoPagar();
         $cuenta->abono = $request->abonoPago;
         $cuenta->fecha_pago = $request->fecha;
         $cuenta->id_pago = $request->id_pago;
         $cuenta->id_empresa = $id_empresa;
         $cuenta->usu_crea = $id_usuario;
          //Insertar numero consecutivo
          $cuentas = array();
          $cuentas = DB::table('abono_pagar')->select('num_pago')->where('id_pago','=',$request->id_pago)->orderBy('id','desc')->limit(1)->get();
          
          if(count($cuentas)<=0)
              $num_pago = 1;
          else
              $num_pago = (int) $cuentas[0]->num_pago + 1;
          ///////////////   
         $cuenta->num_pago = $num_pago;
         $cuenta->estado_abono = '1';
         $cuenta->save();
         $abonos = AbonoPagar::select('abono')->where('id_pago','=',$request->id_pago)->where('estado_abono','=','1')->get();
         $totalAbonos = 0;
         foreach($abonos as $a)
         {
             $totalAbonos = $totalAbonos+$a->abono;
         }
         $cuenta2 = CuentasxPagar::findOrFail($request->id_pago);
         $cuenta2->abono = $totalAbonos;
         $saldo_debe = ($saldo - $abonoNuevo);
         if($saldo_debe<=0){
            $cuenta2->estado_pago = '3';
        }
        if($saldo_debe>0){
            $cuenta2->estado_pago = '1';
        }
         $cuenta2->saldo = $saldo_debe;
         $cuenta2->num_pago = '2';
         $cuenta2->id_empresa = $id_empresa;
         $cuenta2->usu_crea = $id_usuario;
         $cuenta2->save();
         DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $desactivar = AbonoPagar::select('id')->where('id_pago','=',$request->id)->get();
        if(isset($desactivar))
        {
            foreach($desactivar as $d)
            {   
                $cuentas = AbonoPagar::findOrFail($d['id']);
                $cuentas->estado_abono = '0';
                $cuentas->save();
            }
        }
        $cuenta = CuentasxPagar::findOrFail($request->id);
        $cuenta->estado_pago = '2';
        $cuenta->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $activar = AbonoPagar::select('id')->where('id_pago','=',$request->id)->get();
        if(isset($activar))
        {
            foreach($activar as $d)
            {   
                $cuentas = AbonoPagar::findOrFail($d['id']);
                $cuentas->estado_abono = '1';
                $cuentas->save();
            }
        }
        $saldo = CuentasxPagar::select('saldo')->where('id','=',$request->id)->get();

        $cuenta = CuentasxPagar::findOrFail($request->id);
        $valorsaldo = (int) $saldo[0]->saldo;
        if($valorsaldo<=0){
            $cuenta->estado_pago = '3';
        }
        if($valorsaldo>0){
            $cuenta->estado_pago = '1';
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
        $cuenta = AbonoPagar::findOrFail($request->id);
        $cuenta->estado_abono = '0';
        $cuenta->id_empresa = $id_empresa;
        $cuenta->usu_crea = $id_usuario;
        $cuenta->save();
        echo $abonoD = AbonoPagar::select('abono','id_pago')->where('id','=',$request->id)->get();
        foreach($abonoD as $a)
        {
            $abono = $a['abono'];
            $id_pago = $a['id_pago'];
        }
        $update = CuentasxPagar::select('abono','saldo')->where('id','=',$id_pago)->get();
        foreach($update as $up)
        {
            $abonoAnt = $up['abono'];
            $saldo = $up['saldo'];
        }
        $cuenta1 = CuentasxPagar::findOrFail($id_pago);
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
