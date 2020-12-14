<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Formatos;
use App\Plancuentas_model;
use App\Cuentas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FormatoController extends Controller
{
    public function index(Request $request)
    {
       // if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $ND = getdate();    $C1="";
        if($ND['mon']<10){$C1="0";}
        $anio = $request->anio; if(!$anio){$anio= $ND['year'];;}
        $mes = $request->mes;   if(!$mes){$mes=$C1.$ND['mon'];}
        $tipo_formato = $request->tipo_formato;

        if($tipo_formato){$Filtro_tf="="; $val_tf=$tipo_formato;}
        else{$Filtro_tf="!="; $val_tf="-1";}

        $criterio = $request->criterio;     $valor = $request->valor;
        
        if(!isset($request->criterio)||$criterio==null||$criterio==''||$criterio=='0'){ 
            $Campo="formatos.id"; $op="!="; $valor=" 0"; 
        }
        elseif($criterio=="tercero"){   $Campo="personas.num_documento"; $op="like"; $valor=$valor."%"; }
        elseif($criterio=="nom_tercero"){   $Campo="personas.nombre"; $op="like"; $valor="%".$valor."%"; }
        elseif($criterio=="numero"){   $Campo="formatos.numero"; $op="like"; $valor= $valor."%"; }
        elseif($criterio=="dia"){   
            $Campo="formatos.fecha"; $op="="; 
            if($valor>31){ //validacion en el caso que se mande un numero mayor al ultimo del mes en curso
                $a_date = $anio."-".$mes."-01";
                $valor = date("Y-m-t", strtotime($a_date));                
            }
            $valor= $anio."-".$mes."-".$valor; 
        }

       
        $dateToTest = $anio."-".$mes."-01";
        $L_d_m = date('t',strtotime($dateToTest));
       
       
            $formatos = Formatos::join('personas','formatos.tercero','=','personas.id')
            ->join('users','formatos.usuario','=','users.id')
            ->join('conf_formatos','formatos.formato','=','conf_formatos.id')
            ->select('formatos.id','conf_formatos.nombre_formato','formatos.numero','formatos.fecha','formatos.detalle', 'formatos.condicion','personas.nombre','personas.num_documento','personas.id as id_persona','users.usuario',
            'conf_formatos.tipo','formatos.haberes','formatos.debes', 'subtotal','impuesto', 'vr_impuesto', 'total', 'cerrado','forma_pago', 'nombre1', 'nombre2', 'apellido1', 'apellido2')
            ->where('formatos.fecha', '>=', $anio.'-'.$mes.'-01')
            ->where('formatos.fecha', '<=', $anio.'-'.$mes.'-'.$L_d_m)
            ->where('formatos.formato',$Filtro_tf,$val_tf)
            ->where('formatos.id_empresa','=',$id_empresa)
            ->where($Campo , $op, $valor)->orderBy('formatos.id', 'desc')->paginate(10);
       
        return [
            'pagination' => [
                'total'        => $formatos->total(),
                'current_page' => $formatos->currentPage(),
                'per_page'     => $formatos->perPage(),
                'last_page'    => $formatos->lastPage(),
                'from'         => $formatos->firstItem(),
                'to'           => $formatos->lastItem(),
            ],
            'valor' => $valor,
            'Campo' => $Campo,
            'registros' => $formatos,
        ];
    
    }

    public function numero_next(Request $request)
    {
        
       // $formatos = DB::table('formatos')->get()->orderBy('id','desc')->limit('1');
        $formato = $request->tipo_formato;
        $formatos = DB::table('formatos')->where('formato','=',$formato)->orderBy('id','desc')->limit(1)->get();
        
        $Numero = $formatos[0]->numero + 1;
        
        return [
            'numero' => $Numero,
            'formatos' => $formatos,
            'tipo_foramto' => $formato,
        ];
    }
   

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
       
        try{
            DB::beginTransaction();

            $mytime = Carbon::now('America/Lima');

            $tipo_formato = array();

            $tipo_formato = DB::table('conf_formatos')->select('tipo')->where('id','=',$request->formato)->limit(1)->get();
            
            $t_f = $tipo_formato[0]->tipo;
            //echo "t_f=$t_f";
            //print_r($tipo_formato); 
            //exit;

            $formatos = array();

            $formatos = DB::table('formatos')->select('numero')->where('formato','=',$request->formato)->orderBy('id','desc')->limit(1)->get();
            
            if(count($formatos)<=0) 
                $Numero=1;
            else           
                $Numero = (int) $formatos[0]->numero + 1;
                
            if(strlen($Numero)==1){ $Numero = "0000".$Numero;}
            if(strlen($Numero)==2){ $Numero = "000".$Numero;}
            if(strlen($Numero)==3){ $Numero = "00".$Numero;}
            if(strlen($Numero)==4){ $Numero = "0".$Numero;}
            
            $formatos = new formatos();
            //$NumFormato = self::numero_next2($request->formato);
            
            $formatos->numero = $Numero;


            $formatos->tercero = $request->id_tercero;
            $formatos->formato = $request->formato;
            $formatos->fecha = $request->fecha;
            $formatos->subtotal = $request->subtotal;
            $formatos->total = $request->total;
            $formatos->impuesto = $request->impuesto;
            $formatos->vr_impuesto = $request->vr_impuesto;
            $formatos->detalle = $request->detalle;
            $formatos->debes = $request->debitos;
            $formatos->haberes = $request->creditos;
            $formatos->usuario = \Auth::user()->id;
            $formatos->updated_at = $mytime;       
            $formatos->banco = $request->banco;
            $formatos->forma_pago = $request->forma_pago;
            $formatos->num_cheque = $request->num_cheque;
            $formatos->doc_afecta_long = $request->doc_afecta_long; 
            $formatos->id_empresa = $id_empresa;
            $formatos->id_retencion = $request->id_retencion;
            $formatos->save();

            $cuents = $request->data;
                //print_r($cuents); eixt;
            foreach($cuents as $ep=>$cue )
            {
                $cuenta = new Cuentas();
                $cuenta->id_formato = $formatos->id;
                $cuenta->numero =  $formatos->numero;
                $cuenta->tercero = $cue['id_tercero'];
                $cuenta->debe = $cue['debito'];
                $cuenta->haber = $cue['credito'];
                $cuenta->detalle = $request->detalle;
                $cuenta->fecha = $formatos->fecha;                
                $cuenta->num_cuenta = $cue['num_cuenta'];
                $cuenta->cuenta = $cue['id_cuenta'];
                $cuenta->usuario = \Auth::user()->id;
                $cuenta->doc_afecta_long = $cue['doc_afecta_long'];
                $cuenta->doc_externo = $cue['doc_externo'];
                
                if($t_f=='Cuentas'&&$cuenta->num_cuenta[0]=='2'){
                    $cuenta->saldo_cuent = $cue['credito'];
                }
                else{
                    if(isset($cue['id_afectado'])&&$cue['id_afectado']!=''&&$cue['id_afectado']!=$formatos->id){
                        $cuenta2 =   Cuentas::findOrFail($cue['id_afectado']);
                        $cuenta2->saldo_cuent = $cue['saldo_cuent'];
                        $cuenta2->save();
                    }
                }
                $cuenta->save();



            }

            $afectados = $request->afectados;
            if(count($afectados)>0)
            {
                foreach($afectados as $afects)
                {
                    $formato_afec = formatos::findOrFail($afects->id_afectado);
                    $formato_afec->doc_afecta = $formatos->id;
                    $formato_afec->save();
                }
            }
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        try{
            DB::beginTransaction();
            
            $tipo_formato = array();

            $tipo_formato = DB::table('conf_formatos')->select('tipo')->where('id','=',$request->formato)->limit(1)->get();
            
            $t_f = $tipo_formato[0]->tipo;

            $formatos = Formatos::findOrFail($request->id);
            $mytime = Carbon::now('America/Lima');
            
            

            $formatos->tercero = $request->id_tercero;
            $formatos->formato = $request->formato;
            $formatos->fecha = $request->fecha;
            $formatos->subtotal = $request->subtotal;
            $formatos->total = $request->total;
            $formatos->impuesto = $request->impuesto;
            $formatos->vr_impuesto = $request->vr_impuesto;
            $formatos->detalle = $request->detalle;
            $formatos->debes = $request->debitos;
            $formatos->haberes = $request->creditos;
            $formatos->usuario = \Auth::user()->id;
            $formatos->updated_at = $mytime;       
            $formatos->banco = $request->banco;
            $formatos->forma_pago = $request->forma_pago;
            $formatos->num_cheque = $request->num_cheque;
            $formatos->doc_afecta_long = $request->doc_afecta_long;
            $formatos->id_empresa = $id_empresa;
            $formatos->id_retencion = $request->id_retencion;
            $formatos->save();

            $cuents = $request->data;
            
            DB::table('cuentas')->where('id_formato', '=', $formatos->id)->delete();

            $cuents = $request->data;

            foreach($cuents as $ep=>$cue )
            {
                $cuenta = new Cuentas();
                $cuenta->id_formato = $formatos->id;
                $cuenta->numero =  $formatos->numero;
                $cuenta->tercero = $cue['id_tercero'];
                $cuenta->debe = $cue['debito'];
                $cuenta->haber = $cue['credito'];
                $cuenta->detalle = $request->detalle;
                $cuenta->fecha = $formatos->fecha;                
                $cuenta->num_cuenta = $cue['num_cuenta'];
                $cuenta->cuenta = $cue['id_cuenta'];
                $cuenta->usuario = \Auth::user()->id;
                $cuenta->doc_afecta_long = $cue['doc_afecta_long'];
                $cuenta->doc_externo = $cue['doc_externo'];
                // $cuenta->saldo_cuent = $cue['saldo_cuent'];
                if($t_f=='Cuentas'&&$cuenta->num_cuenta[0]=='2'){
                    $cuenta->saldo_cuent = $cue['credito'];
                }
                $cuenta->save();
            }

            $afectados = $request->afectados;
            if(count($afectados)>0)
            {
                foreach($afectados as $afects)
                {
                    $formato_afec = formatos::findOrFail($afects->id_afectado);
                    $formato_afec->doc_afecta = $formatos->id;
                    $formato_afec->save();
                }
            }
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $formatos = Formatos::findOrFail($request->id);
        $formatos->condicion = '0';
        $formatos->save();
    }
    public function cerrar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $formatos = Formatos::findOrFail($request->id);
        $formatos->cerrado = '1';
        $formatos->save();
    }
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $formatos = Formatos::findOrFail($request->id);
        $formatos->condicion = '1';
        $formatos->save();

        
    }

    public function obtenerCabecera(Request $request){
       //if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $formatos = Formatos::join('personas','formatos.tercero','=','personas.id')
        ->join('users','formatos.usuario','=','users.id')
        ->join('conf_formatos','formatos.formato','=','conf_formatos.id')
        ->join('retenciones','formatos.id_retencion','=','retenciones.id')
        ->select('formatos.id','conf_formatos.nombre_formato','formatos.numero','formatos.fecha','formatos.detalle', 'formatos.condicion','personas.nombre','personas.num_documento','personas.id as id_persona','personas.nombre1','personas.apellido1','users.usuario',
        'conf_formatos.tipo','formatos.haberes','formatos.debes', 'subtotal','impuesto', 'vr_impuesto', 'total', 'cerrado','forma_pago','formatos.formato','formatos.id_retencion','retenciones.retencion')
        ->where('formatos.id','=',$id)->orderBy('formatos.id', 'desc')->take(1)->get();
        
        return ['formato' => $formatos];
    }
    public function obtenerDetalles(Request $request){
        //if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $detalles = Cuentas::join('plan_cuentas','cuentas.cuenta','=','plan_cuentas.id')
        ->leftJoin('personas','cuentas.tercero','=','personas.id')
        ->select('cuenta as id_cuenta','num_cuenta','debe as debito','haber as credito','cuentas.tercero as id_tercero','personas.num_documento as doc_tercero','doc_afecta_long','doc_externo','naturaleza','plan_cuentas.nombre as plan_cuentas_nom')
        ->where('cuentas.id_formato','=',$id)
        ->orderBy('cuentas.id', 'desc')->take(10000)->get();
        
        return ['detalles' => $detalles];
    }
    public function Pdf(Request $request, $id)
    {
        
        $formato = Formatos::join('personas','formatos.tercero','=','personas.id')
        ->join('users','formatos.usuario','=','users.id')
        ->join('conf_formatos','formatos.formato','=','conf_formatos.id')
        ->join('empresas', 'formatos.id_empresa','=','empresas.id')
        ->select('formatos.id','conf_formatos.nombre_formato','formatos.numero','formatos.fecha','formatos.detalle', 'formatos.condicion','personas.nombre','personas.tipo_documento','email','personas.telefono','personas.direccion','personas.num_documento','personas.id as id_persona','users.usuario',
        'conf_formatos.tipo','formatos.haberes','formatos.debes', 'subtotal','impuesto', 'vr_impuesto', 'total', 'cerrado'
        ,'personas.nombre1','personas.nombre2','personas.apellido1','personas.apellido2',
        'empresas.id as id_empresa','empresas.nombre as nom_empresa', 'empresas.nit as nit_empresa','empresas.celular as cel_empresa', 'empresas.correo as correo_empresa', 'empresas.direccion as direccion_empresa', 'empresas.telefono as telefono_empresa','empresas.logo as logo_empresa')
        ->where('formatos.id','=',$id)->orderBy('formatos.id', 'desc')->take(1)->get();

        $detalles = Cuentas::join('plan_cuentas','cuentas.cuenta','=','plan_cuentas.id')
        ->leftJoin('personas','cuentas.tercero','=','personas.id')
        ->select('cuentas.debe','cuentas.haber','personas.num_documento','plan_cuentas.nombre','plan_cuentas.codigo','cuentas.doc_afecta_long')
        ->where('cuentas.id_formato','=',$id)
        ->orderBy('cuentas.id', 'desc')->get();

        $numformato=Formatos::select('numero')->where('id',$id)->get();
        return view('pdf.formato')->with('formato', $formato)->with('detalles', $detalles);
        //$pdf = \PDF::loadView('pdf.formato',['formato'=>$formato,'detalles'=>$detalles]);
        //return $pdf->download('formato-'.$numformato[0]->numero.'.pdf');


    }

    /*public function Pdf(Request $request, $id)
    {
        
        $formato = Formatos::join('personas','formatos.tercero','=','personas.id')
        ->join('users','formatos.usuario','=','users.id')
        ->join('conf_formatos','formatos.formato','=','conf_formatos.id')
        ->select('formatos.id','conf_formatos.nombre_formato','formatos.numero','formatos.fecha','formatos.detalle', 'formatos.condicion','personas.nombre','personas.tipo_documento','email','telefono','direccion','personas.num_documento','personas.id as id_persona','users.usuario',
        'conf_formatos.tipo','formatos.haberes','formatos.debes', 'subtotal','impuesto', 'vr_impuesto', 'total', 'cerrado'
        ,'personas.nombre1','personas.nombre2','personas.apellido1','personas.apellido2')
        ->where('formatos.id','=',$id)->orderBy('formatos.id', 'desc')->take(1)->get();

        $detalles = Cuentas::join('plan_cuentas','cuentas.cuenta','=','plan_cuentas.id')
        ->leftJoin('personas','cuentas.tercero','=','personas.id')
        ->select('cuentas.debe','cuentas.haber','personas.num_documento','plan_cuentas.nombre','plan_cuentas.codigo','cuentas.doc_afecta_long')
        ->where('cuentas.id_formato','=',$id)
        ->orderBy('cuentas.id', 'desc')->get();

        $numformato=Formatos::select('numero')->where('id',$id)->get();
        return view('pdf.formato')->with('formato', $formato)->with('detalles', $detalles);
        //$pdf = \PDF::loadView('pdf.formato',['formato'=>$formato,'detalles'=>$detalles]);
        //return $pdf->download('formato-'.$numformato[0]->numero.'.pdf');


    }*/
}
