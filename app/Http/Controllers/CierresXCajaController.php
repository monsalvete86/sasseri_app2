<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CierresXCaja;
use App\Facturacion;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CierresXCajaController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        if($request->fec_desde!=''){$fec_desde = $request->fec_desde.' 00:00:00';}else{$fec_desde=$request->fec_desde;}
        if($request->fec_hasta){$fec_hasta = $request->fec_hasta.' 23:59:59';}else{$fec_hasta=$request->fec_hasta;}
        
        $cierres_caja = CierresXCaja::leftJoin('cajas','cajas_cierres.id_caja','=','cajas.id')
        ->leftJoin('users','cajas_cierres.usu_crea','users.id')
        ->select('cajas_cierres.id','cajas_cierres.id_caja','cajas_cierres.vr_inicial','cajas_cierres.obs_inicial','cajas_cierres.vr_gastos','cajas_cierres.obs_gastos','cajas_cierres.vr_software','cajas_cierres.vr_final','cajas_cierres.estado','cajas.nombre','cajas_cierres.created_at','cajas_cierres.usu_crea','users.usuario as nom_cajero')
        ->where('.cajas_cierres.id_empresa','=',$id_empresa);
        if($fec_desde!="" && $fec_hasta!="")
        {
            $cierres_caja = $cierres_caja->whereBetween('cajas_cierres.created_at', [$fec_desde, $fec_hasta]);
        }

        if($buscar!="")
        {
            $cierres_caja = $cierres_caja->where('cajas.nombre','like','%'.$buscar.'%');
        }
        $cierres_caja = $cierres_caja->orderBy('id', 'desc')
        ->paginate(15);
        

        return [
            'pagination' => [
                'total'        => $cierres_caja->total(),
                'current_page' => $cierres_caja->currentPage(),
                'per_page'     => $cierres_caja->perPage(),
                'last_page'    => $cierres_caja->lastPage(),
                'from'         => $cierres_caja->firstItem(),
                'to'           => $cierres_caja->lastItem(),
            ],
            'cierres_caja' => $cierres_caja,
            'id_usuario' =>  Auth::user()->id,
            'fec_desde'=>$fec_desde,
            'fec_hasta'=>$fec_hasta,
        ];
    }

    public function SelectCierreXCaja(Request $request){
        // if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        $cierres_caja = CierresXCaja::where('id_empresa','=',$id_empresa)->where('usu_crea','=',$id_usuario)->where('estado','!=','0')->orderBy('id', 'desc')->limit(1)->get();
        
        return ['cierres_caja' => $cierres_caja];
    }

    public function consultarCierreXCaja(Request $request){
        // if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        $cierres_caja = CierresXCaja::where('id_caja','=',$request->id)->orderBy('id','desc')->limit(1)->get();
        
        return ['cierres_caja' => $cierres_caja];
    }

    public function consultarCajas(Request $request){
        // if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        $cierres_caja = CierresXCaja::where('id_empresa','=',$id_empresa)->get();

        if(empty($cierres_caja))
        {
            return;
        }
        else
        {
            $ban = 0;
            $arrayCajasUsuario = array();
            foreach($cierres_caja as $cc)
            {
                if($cc['usu_crea']==$id_usuario && $cc['estado']==1){
                    $ban = 1;
                    $arrayCajasUsuario[] = $cc;
                }
            }
            return $arrayCajasUsuario;
        }
        
        // return ['cierres_caja' => $cierres_caja];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        $cierres_caja = new CierresXCaja();
        $cierres_caja->id_caja = $request->id_caja;
        $cierres_caja->vr_inicial = $request->vr_inicial;
        $cierres_caja->obs_inicial = $request->obs_inicial;
        $cierres_caja->vr_gastos = $request->vr_gastos;
        $cierres_caja->obs_gastos = $request->obs_gastos;
        $cierres_caja->vr_software = 0;
        $cierres_caja->vr_final = $request->vr_final;
        $cierres_caja->usu_crea = $request->id_cajero;
        $cierres_caja->id_empresa = $id_empresa;
        $cierres_caja->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        $cierres_caja = CierresXCaja::findOrFail($request->id);
        $cierres_caja->id_caja = $request->id_caja;
        $cierres_caja->vr_inicial = $request->vr_inicial;
        $cierres_caja->obs_inicial = $request->obs_inicial;
        $cierres_caja->vr_gastos = $request->vr_gastos;
        $cierres_caja->obs_gastos = $request->obs_gastos;
        $cierres_caja->vr_software = 0;
        $cierres_caja->vr_final = $request->vr_final;
        $cierres_caja->usu_crea = $id_usuario;
        $cierres_caja->id_empresa = $id_empresa;
        $cierres_caja->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cierres_caja = CierresXCaja::findOrFail($request->id);
        $cierres_caja->estado = '0';
        $cierres_caja->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cierres_caja = CierresXCaja::findOrFail($request->id);
        $cierres_caja->estado = '1';
        $cierres_caja->save();
    }

    public function cerrar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;
        $valor_abonos = 0;

        $cierres_caja = CierresXCaja::findOrFail($request->id);
        $cierres_caja->id_caja = $request->id_caja;
        $cierres_caja->obs_inicial = $request->obs_inicial;
        $cierres_caja->vr_gastos = $request->vr_gastos;
        $cierres_caja->obs_gastos = $request->obs_gastos;

        $facturas = Facturacion::select('abono')->where('id_cierre_caja','=',$request->id)->get();
        if(count($facturas)>0)
        {
            foreach($facturas as $fc)
            {
                $valor_abonos = $valor_abonos+$fc['abono'];
            }
        }
        $cierres_caja->vr_software = $valor_abonos;

        $cierres_caja->vr_final = $request->vr_final;
        $cierres_caja->estado = 2;
        $cierres_caja->usu_crea = $id_usuario;
        $cierres_caja->id_empresa = $id_empresa;
        $cierres_caja->save();
    }

    public function selectValorInicialCaja(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        $cierres_caja = CierresXCaja::where('id_caja','=',$request->id)->where('estado','=','2')->orderBy('id','desc')->limit(1)->get();

        return ['cierres_caja' => $cierres_caja];
    }

    public function validarCierreCaja(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        $carbon = Carbon::now('America/Bogota')->subDay()->toDateTimeString();

        $cierres_caja = CierresXCaja::leftJoin('cajas','cajas_cierres.id_caja','=','cajas.id')
        ->select('cajas_cierres.id','cajas_cierres.id_caja','cajas_cierres.vr_inicial','cajas_cierres.obs_inicial','cajas_cierres.vr_gastos','cajas_cierres.obs_gastos','cajas_cierres.vr_software','cajas_cierres.vr_final','cajas_cierres.estado','cajas.nombre','cajas_cierres.created_at','cajas_cierres.usu_crea','cajas_cierres.created_at')
        ->where('.cajas_cierres.id_empresa','=',$id_empresa)
        ->where('cajas_cierres.usu_crea','=',$id_usuario)
        ->orderBy('cajas_cierres.id','desc')->limit(1)->get();

        $ban = 0;

        if(!empty($cierres_caja) && count($cierres_caja)>0)
        {
            if($cierres_caja[0]->estado!=1){$ban = 1;} /*caja cerrada*/
            else if($cierres_caja[0]->estado==1){
                if($cierres_caja[0]->created_at->lessThan($carbon))
                { $ban = 2; } /*Caja abierta pero vencida */
                else
                { $ban = 3; } /*Caja abierta y vigente*/
            }
        }

        return [
            'carbon'=>$carbon,
            'cierres_cajas'=>$cierres_caja,
            'ban'=>$ban,
            'usu_crea'=>$id_usuario,
        ];
    }
}
