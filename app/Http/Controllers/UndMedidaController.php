<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UndMedida;
use Illuminate\Support\Facades\Auth;

class UndMedidaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        
        $und_medida = UndMedida::where('id_empresa','=',$id_empresa);
        if($buscar!=''){$und_medida = $und_medida->where($criterio, 'like', '%'. $buscar . '%');}
        $und_medida = $und_medida->orderBy('id', 'desc')->paginate(3);
        

        return [
            'pagination' => [
                'total'        => $und_medida->total(),
                'current_page' => $und_medida->currentPage(),
                'per_page'     => $und_medida->perPage(),
                'last_page'    => $und_medida->lastPage(),
                'from'         => $und_medida->firstItem(),
                'to'           => $und_medida->lastItem(),
            ],
            'und_medida' => $und_medida
        ];
    }

    public function selectUndMedida(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $und_medida = UndMedida::select('id','nombre')->where('id_empresa','=',$id_empresa)->orderBy('nombre', 'asc')->get();
        
        return ['unidades' => $und_medida];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        $und_medida = new UndMedida();
        $und_medida->nombre = $request->nombre;
        $und_medida->id_empresa = $id_empresa;
        $und_medida->usu_crea = $id_usuario;
        $und_medida->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $und_medida = UndMedida::findOrFail($request->id);
        $und_medida->nombre = $request->nombre;
        $und_medida->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $und_medida = UndMedida::findOrFail($request->id);
        $und_medida->estado = '0';
        $und_medida->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $und_medida = UndMedida::findOrFail($request->id);
        $und_medida->estado = '1';
        $und_medida->save();
    }
}
