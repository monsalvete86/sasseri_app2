<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CajasAdmin;
use App\User;
use Illuminate\Support\Facades\Auth;

class CajasAdminController extends Controller
{
    /*public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        
        // $cajas_admin = CajasAdmin::where('id_empresa','=',$id_empresa);
        if($buscar!='')
        {
            $cajas_admin = CajasAdmin::where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('id', 'desc')->paginate(3);  
        }
        else
        {
            $cajas_admin = CajasAdmin::orderBy('id', 'desc')->paginate(3);
        }

        return [
            'pagination' => [
                'total'        => $cajas_admin->total(),
                'current_page' => $cajas_admin->currentPage(),
                'per_page'     => $cajas_admin->perPage(),
                'last_page'    => $cajas_admin->lastPage(),
                'from'         => $cajas_admin->firstItem(),
                'to'           => $cajas_admin->lastItem(),
            ],
            'cajas_admin' => $cajas_admin
        ];
    }*/

    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');

        // $users = User::where('empresas_id','=',$id_empresa)->paginate(6);
        $users = CajasAdmin::leftJoin('personas','cajas_admin.id_usuario','personas.id')
        ->select('cajas_admin.id','cajas_admin.id_caja','cajas_admin.id_usuario','personas.nombre as usuario')
        ->groupBy('cajas_admin.id_usuario')
        ->paginate(6);
        
        // $cajas_admin = CajasAdmin::where('id_empresa','=',$id_empresa);
        if($buscar!='')
        {
            $cajas_admin = CajasAdmin::where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('id', 'desc')->paginate(6);  
        }
        else
        {
            $cajas_admin = CajasAdmin::rightJoin('users','cajas_admin.id_usuario','=','users.id')
            ->select('cajas_admin.id','cajas_admin.id_caja','cajas_admin.id_usuario','cajas_admin.usu_crea','users.usuario')
            ->orderBy('id', 'desc')->paginate(6);
        }

        return [
            // 'pagination' => [
            //     'total'        => $cajas_admin->total(),
            //     'current_page' => $cajas_admin->currentPage(),
            //     'per_page'     => $cajas_admin->perPage(),
            //     'last_page'    => $cajas_admin->lastPage(),
            //     'from'         => $cajas_admin->firstItem(),
            //     'to'           => $cajas_admin->lastItem(),
            // ],
            // 'cajas_admin' => $cajas_admin,
            'pagination' => [
                'total'        => $users->total(),
                'current_page' => $users->currentPage(),
                'per_page'     => $users->perPage(),
                'last_page'    => $users->lastPage(),
                'from'         => $users->firstItem(),
                'to'           => $users->lastItem(),
            ],
            'users' => $users,
        ];
    }

    public function selectCajasAdmin(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $cajas_admin = CajasAdmin::select('id','nombre')->where('id_empresa','=',$id_empresa)->orderBy('nombre', 'asc')->get();
        
        return ['cajas_admin' => $cajas_admin];
    }

    public function listarCajasAdmin(Request $request){
        // if(!$request->ajax()) return redirect('/');

        $cajas_admin = CajasAdmin::leftJoin('cajas','cajas_admin.id_caja','cajas.id')
        ->select('cajas.id as id_caja','cajas.nombre as nom_caja')
        ->where('id_usuario','=',$request->id)->get();
        
        return ['cajas_admin' => $cajas_admin];
    }

    public function listarCajerosAdmin(Request $request){
        // if(!$request->ajax()) return redirect('/');

        // $cajas_admin = CajasAdmin::rightJoin('users','cajas_admin.id_usuario','users.id')
        // ->select('users.id','users.usuario','cajas_admin.id_caja')
        // ->where('cajas_admin.id_caja','=',$request->id)
        // ->get();

        $cajas_admin = CajasAdmin::leftJoin('users','cajas_admin.id_usuario','users.id')
        ->select('users.id','cajas_admin.id_caja','cajas_admin.id_usuario','users.usuario as nombre')
        ->where('cajas_admin.id_caja','=',$request->id)->get();
        
        return ['cajas_admin' => $cajas_admin];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        if($request->arrayCajasAdmin)
        {
            foreach($request->arrayCajasAdmin as $ca)
            {
                $cajas_admin = new CajasAdmin();
                $cajas_admin->id_caja = $ca['id_caja'];
                $cajas_admin->id_usuario = $request->id_tercero;
                $cajas_admin->usu_crea = $id_usuario;
                $cajas_admin->id_empresa = $id_empresa;
                $cajas_admin->save();
            }
        }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        if($request->arrayCajasAdmin)
        {
            $borrarCajas = CajasAdmin::where('id_usuario','=',$request->id_tercero)->delete();
            foreach($request->arrayCajasAdmin as $ca)
            {
                $cajas_admin = new CajasAdmin();
                $cajas_admin->id_caja = $ca['id_caja'];
                $cajas_admin->id_usuario = $request->id_tercero;
                $cajas_admin->usu_crea = $id_usuario;
                $cajas_admin->id_empresa = $id_empresa;
                $cajas_admin->save();
            }
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cajas_admin = CajasAdmin::findOrFail($request->id);
        $cajas_admin->estado = '0';
        $cajas_admin->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cajas_admin = CajasAdmin::findOrFail($request->id);
        $cajas_admin->estado = '1';
        $cajas_admin->save();
    }
}
