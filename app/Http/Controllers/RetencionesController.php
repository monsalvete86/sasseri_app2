<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Retencion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RetencionesController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        
        if ($buscar==''){
            $retenciones = Retencion::join('plan_cuentas','retenciones.cuenta','plan_cuentas.id')
            ->select('retenciones.id','retenciones.retencion','retenciones.cuenta as id_cuenta','plan_cuentas.nombre as cuenta','plan_cuentas.naturaleza','plan_cuentas.codigo as codigo_cuenta','retenciones.autoretenedor','retenciones.declarante','retenciones.monto_base','retenciones.tipo_mov','retenciones.porcentaje','retenciones.estado')
            ->where('retenciones.id_empresa','=',$id_empresa)
            ->orderBy('id', 'desc')
            ->paginate(6);
        }
        else{
            $retenciones = Retencion::join('plan_cuentas','retenciones.cuenta','plan_cuentas.id')
            ->select('retenciones.id','retenciones.retencion','retenciones.cuenta as id_cuenta','plan_cuentas.nombre as cuenta','plan_cuentas.naturaleza','plan_cuentas.codigo as codigo_cuenta','retenciones.autoretenedor','retenciones.declarante','retenciones.monto_base','retenciones.tipo_mov','retenciones.porcentaje','retenciones.estado')
            ->where('retenciones.id_empresa','=',$id_empresa)
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('id', 'desc')
            ->paginate(6);
        }
        
        return [
            'pagination' => [
                'total'        => $retenciones->total(),
                'current_page' => $retenciones->currentPage(),
                'per_page'     => $retenciones->perPage(),
                'last_page'    => $retenciones->lastPage(),
                'from'         => $retenciones->firstItem(),
                'to'           => $retenciones->lastItem(),
            ],
            'retenciones' => $retenciones,
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        $retenciones = new Retencion();
        $retenciones->retencion = $request->retencion;
        $retenciones->cuenta = $request->cuenta;
        $retenciones->tipo_cuenta = $request->tipo_cuenta;
        $retenciones->autoretenedor = $request->autoretenedor;
        $retenciones->declarante = $request->declarante;
        $retenciones->monto_base = $request->monto_base;
        $retenciones->tipo_mov = $request->tipo_mov;
        $retenciones->porcentaje = $request->porcentaje;
        $retenciones->usu_crea = $id_usuario;
        $retenciones->id_empresa = $id_empresa;
        // $retenciones->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;

        $retenciones = Retencion::findOrFail($request->id);
        $retenciones->retencion = $request->retencion;
        $retenciones->cuenta = $request->cuenta;
        $retenciones->tipo_cuenta = $request->tipo_cuenta;
        $retenciones->autoretenedor = $request->autoretenedor;
        $retenciones->declarante = $request->declarante;
        $retenciones->monto_base = $request->monto_base;
        $retenciones->tipo_mov = $request->tipo_mov;
        $retenciones->porcentaje = $request->porcentaje;
        // $retenciones->save();
    }

    public function selectReteInfo(Request $request){
        //if (!$request->ajax()) return redirect('/');
        
        $busqueda = $request->busqueda;
        $id_empresa = $request->session()->get('id_empresa');
        
        $retenciones = Retencion::join('plan_cuentas','retenciones.cuenta','plan_cuentas.id')
        ->select('retenciones.id','retenciones.retencion','retenciones.cuenta as id_cuenta','plan_cuentas.nombre as cuenta','plan_cuentas.naturaleza','plan_cuentas.codigo as codigo_cuenta','retenciones.autoretenedor','retenciones.declarante','retenciones.monto_base','retenciones.tipo_mov','retenciones.porcentaje','retenciones.estado')->where('retenciones.id_empresa','=',$id_empresa)->orderBy('retencion', 'asc')->get();
        return ['retenciones' => $retenciones];
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $retenciones = Retencion::findOrFail($request->id);
        $retenciones->estado = '0';
        $retenciones->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $retenciones = Retencion::findOrFail($request->id);
        $retenciones->estado = '1';
        $retenciones->save();
    }
}
