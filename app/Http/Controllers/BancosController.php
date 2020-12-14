<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bancos;
use Illuminate\Support\Facades\Auth;


class BancosController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $bancos = Bancos::where('id_empresa','=',$id_empresa)->orderBy('id', 'desc')->paginate(3);
        }
        else{
            $bancos = Bancos::where($criterio, 'like', '%'. $buscar . '%')->where('id_empresa','=',$id_empresa)->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $bancos->total(),
                'current_page' => $bancos->currentPage(),
                'per_page'     => $bancos->perPage(),
                'last_page'    => $bancos->lastPage(),
                'from'         => $bancos->firstItem(),
                'to'           => $bancos->lastItem(),
            ],
            'bancos' => $bancos
        ];
    }

    public function selectBancos(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $bancos = Bancos::select('id','nombre')->where('id_empresa','=',$id_empresa)->where('estado','=','1')->orderBy('nombre', 'asc')->get();
        
        return ['bancos' => $bancos];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');
        
        $bancos = new Bancos();
        $bancos->nombre = $request->nombre;
        $bancos->id_empresa = $id_empresa;
        $bancos->usu_crea = $id_usuario;
        $bancos->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');
        
        $bancos = Bancos::findOrFail($request->id);
        $bancos->nombre = $request->nombre;
        $bancos->id_empresa = $id_empresa;
        $bancos->usu_crea = $id_usuario;
        $bancos->estado = $request->estado;
        $bancos->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $bancos = Bancos::findOrFail($request->id);
        $bancos->estado = '0';
        $bancos->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $bancos = Bancos::findOrFail($request->id);
        $bancos->estado = '1';
        $bancos->save();
    }
}
