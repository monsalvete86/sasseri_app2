<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Concentracion;
use Illuminate\Support\Facades\Auth;

class ConcentracionController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        
        $concentracion = Concentracion::where('id_empresa','=',$id_empresa);
        if($buscar!=''){$concentracion = $concentracion->where($criterio, 'like', '%'. $buscar . '%');}
        $concentracion = $concentracion->orderBy('id', 'desc')->paginate(3);        

        return [
            'pagination' => [
                'total'        => $concentracion->total(),
                'current_page' => $concentracion->currentPage(),
                'per_page'     => $concentracion->perPage(),
                'last_page'    => $concentracion->lastPage(),
                'from'         => $concentracion->firstItem(),
                'to'           => $concentracion->lastItem(),
            ],
            'concentracion' => $concentracion
        ];
    }

    public function selectConcentracion(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $concentracion = Concentracion::select('id','nombre')->where('id_empresa','=',$id_empresa)->orderBy('nombre', 'asc')->get();
        
        return ['concentracion' => $concentracion];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        $concentracion = new Concentracion();
        $concentracion->nombre = $request->nombre;
        $concentracion->id_empresa = $id_empresa;
        $concentracion->usu_crea = $id_usuario;
        $concentracion->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $concentracion = Concentracion::findOrFail($request->id);
        $concentracion->nombre = $request->nombre;
        $concentracion->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $concentracion = Concentracion::findOrFail($request->id);
        $concentracion->estado = '0';
        $concentracion->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $concentracion = Concentracion::findOrFail($request->id);
        $concentracion->estado = '1';
        $concentracion->save();
    }
}
