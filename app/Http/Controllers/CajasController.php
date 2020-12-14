<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Cajas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CajasController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $diaAnterior = Carbon::now('America/Bogota')->subDay()->toDateTimeString();
        $diaActual = Carbon::now('America/Bogota')->toDateTimeString();

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        
        if ($buscar==''){
            $cajas = Cajas::where('id_empresa','=',$id_empresa)->orderBy('id', 'desc')->paginate(15);
        }
        else{
            $cajas = Cajas::where('id_empresa','=',$id_empresa)->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(15);
        }

        if(!empty($cajas))
        {
            foreach($cajas as $c)
            {
                $c['estado_caja'] = '0';
                $c['tiempo_caja'] = '0000-00-00 00:00:00';
                $c['usuario_caja'] = '';

                $sql = "SELECT cajas_cierres.id, cajas_cierres.id_caja, cajas_cierres.vr_inicial, cajas_cierres.obs_inicial, cajas_cierres.vr_gastos, cajas_cierres.obs_gastos, cajas_cierres.vr_software, cajas_cierres.vr_final, cajas_cierres.estado, cajas_cierres.usu_crea, cajas_cierres.id_empresa, cajas_cierres.created_at, cajas_cierres.updated_at, users.usuario as nom_usuario FROM cajas_cierres,users WHERE id_caja=".$c->id." AND cajas_cierres.usu_crea=users.id ORDER BY id desc LIMIT 1";
                $cierres = DB::select($sql);

                if(!empty($cierres))
                {
                    $c['estado_caja'] = $cierres[0]->estado;
                    $c['tiempo_caja'] = $cierres[0]->created_at;
                    $c['usuario_caja'] = $cierres[0]->nom_usuario;
                }
            }
        }
        

        return [
            'pagination' => [
                'total'        => $cajas->total(),
                'current_page' => $cajas->currentPage(),
                'per_page'     => $cajas->perPage(),
                'last_page'    => $cajas->lastPage(),
                'from'         => $cajas->firstItem(),
                'to'           => $cajas->lastItem(),
            ],
            'cajas' => $cajas
        ];
    }

    public function selectCaja(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $cajas = Cajas::select('id','nombre')->where('id_empresa','=',$id_empresa)->orderBy('nombre', 'asc')->get();
        
        $cajas2 = [];
        if(isset($request->id_caja))
        {
            $cajas2 = Cajas::select('id','nombre')->where('id','=',$request->id_caja)->get();
        }
        
        return [
            'cajas' => $cajas,
            'cajas2' => $cajas2
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        $cajas = new Cajas();
        $cajas->nombre = $request->nombre;
        $cajas->id_empresa = $id_empresa;
        $cajas->usu_crea = $id_usuario;
        $cajas->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cajas = Cajas::findOrFail($request->id);
        $cajas->nombre = $request->nombre;
        $cajas->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cajas = Cajas::findOrFail($request->id);
        $cajas->estado = '0';
        $cajas->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cajas = Cajas::findOrFail($request->id);
        $cajas->estado = '1';
        $cajas->save();
    }
}
