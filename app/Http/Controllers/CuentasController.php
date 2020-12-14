<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuentasController extends Controller
{
    
    public function saldo(Request $request){
        $id_cuenta = $request->id_cuenta;
        //echo "id_cuenta=$id_cuenta";   
        $cons="SELECT cuenta,sum(debe) as debe,sum(haber) as haber from cuentas where  condicion=1 and cuenta = ".$id_cuenta." group by cuenta";        
        
        $aux_saldos = DB::select($cons);     
        $aux_saldos = $aux_saldos[0];
       // print_r($aux_saldos);
        $saldo = $aux_saldos->debe - $aux_saldos->haber;
        $saldo = number_format($saldo,2);
        return ['saldo'=>$saldo];
    }
    public function get_fuentes(Request $request){
        $id_cuenta = $request->id_cuenta;
        //echo "id_cuenta=$id_cuenta";   
        $cons="SELECT id,nombre from plan_cuentas where  condicion=1 and banco = 1 order by nombre";        
        
        $fuentes = DB::select($cons);     
        $aux_f = array();
        foreach($fuentes as $a){
            //print_r($a);
            $aux_f[$a->id]=$a;
        }
        return ['fuentes'=>$aux_f];
    }
    public function get_fuentes2(Request $request){
        $id_cuenta = $request->id_cuenta;
        //echo "id_cuenta=$id_cuenta";   
        $cons="SELECT id,nombre from plan_cuentas where  condicion=1 and tipo_cuenta_compra = 1 order by nombre";
        $cons2="SELECT id,nombre from plan_cuentas where  condicion=1 and tipo_cuenta_salida_almacen = 1 order by nombre";
        
        $fuentes = DB::select($cons);     
        $fuentes2 = DB::select($cons2);
        $aux_f = array();
        foreach($fuentes as $a){
            //print_r($a);
            $aux_f[$a->id]=$a;
        }
        $aux_f2 = array();
        foreach($fuentes2 as $a2){
            //print_r($a);
            $aux_f2[$a2->id]=$a2;
        }
        return ['fuentes'=>$aux_f,'fuentes2'=>$aux_f2];
    }

    public function get_x_afectar(Request $request){
        $id_tercero = $request->id_tercero;
        $cons="select *,cuentas.cuenta as id_cuenta, cuentas.id as id_afectado from cuentas,formatos,conf_formatos where cuentas.tercero=$id_tercero and cuentas.condicion=1 and formatos.id=cuentas.id_formato and conf_formatos.id = formatos.formato and num_cuenta like '2%' and saldo_cuent is not null and saldo_cuent>0 "; 
        // echo $cons; exit;
        $afectados = DB::select($cons);  
        
        return ['afectados'=>$afectados];
    }

}
