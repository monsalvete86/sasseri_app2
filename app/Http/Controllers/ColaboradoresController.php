<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Colaboradores;
use Illuminate\Support\Facades\Auth;


class ColaboradoresController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $colaboradores = Colaboradores::where('id_empresa','=',$id_empresa)->orderBy('id', 'desc')->paginate(3);
        }
        else{
            $colaboradores = Colaboradores::where($criterio, 'like', '%'. $buscar . '%')->where('id_empresa','=',$id_empresa)->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $colaboradores->total(),
                'current_page' => $colaboradores->currentPage(),
                'per_page'     => $colaboradores->perPage(),
                'last_page'    => $colaboradores->lastPage(),
                'from'         => $colaboradores->firstItem(),
                'to'           => $colaboradores->lastItem(),
            ],
            'colaboradores' => $colaboradores
        ];
    }

    public function selectColaborador(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $colaboradores = Colaboradores::select('id','colaborador')->where('id_empresa','=',$id_empresa)->where('estado','=','1')->orderBy('colaborador', 'asc')->get();
        
        return ['colaboradores' => $colaboradores];
    }

    public function selectColaboradorVendedor(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $colaboradores = Colaboradores::select('id','colaborador')->where('id_empresa','=',$id_empresa)->where('vendedor','=','1')->where('estado','=','1')->orderBy('colaborador', 'asc')->get();
        
        return ['colaboradores' => $colaboradores];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        $colaboradores = new Colaboradores();
        $colaboradores->colaborador = $request->colaborador;
        $colaboradores->observacion = $request->observacion;
        $colaboradores->vendedor = $request->vendedor;
        $colaboradores->cobrador = $request->cobrador;
        $colaboradores->id_empresa = $id_empresa;
        $colaboradores->usu_crea = $id_usuario;
        $colaboradores->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $colaboradores = Colaboradores::findOrFail($request->id);
        $colaboradores->colaborador = $request->colaborador;
        $colaboradores->observacion = $request->observacion;
        $colaboradores->vendedor = $request->vendedor;
        $colaboradores->cobrador = $request->cobrador;
        $colaboradores->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $colaboradores = Colaboradores::findOrFail($request->id);
        $colaboradores->estado = '0';
        $colaboradores->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $colaboradores = Colaboradores::findOrFail($request->id);
        $colaboradores->estado = '1';
        $colaboradores->save();
    }
}
