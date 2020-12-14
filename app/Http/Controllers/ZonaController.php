<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zona;
use Illuminate\Support\Facades\Auth;


class ZonaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $zona = Zona::where('id_empresa','=',$id_empresa)->orderBy('id', 'desc')->paginate(3);
        }
        else{
            $zona = Zona::where($criterio, 'like', '%'. $buscar . '%')->where('id_empresa','=',$id_empresa)->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $zona->total(),
                'current_page' => $zona->currentPage(),
                'per_page'     => $zona->perPage(),
                'last_page'    => $zona->lastPage(),
                'from'         => $zona->firstItem(),
                'to'           => $zona->lastItem(),
            ],
            'zona' => $zona
        ];
    }

    public function selectZona(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $zona = Zona::select('id','zona')->where('id_empresa','=',$id_empresa)->where('estado','=','1')->orderBy('zona', 'asc')->get();
        
        return ['zona' => $zona];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        $zona = new zona();
        $zona->zona = $request->zona;
        $zona->observacion = $request->observacion;
        $zona->id_empresa = $id_empresa;
        $zona->usu_crea = $id_usuario;
        $zona->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $zona = Zona::findOrFail($request->id);
        $zona->zona = $request->zona;
        $zona->observacion = $request->observacion;
        $zona->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $zona = Zona::findOrFail($request->id);
        $zona->estado = '0';
        $zona->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $zona = Zona::findOrFail($request->id);
        $zona->estado = '1';
        $zona->save();
    }
}
