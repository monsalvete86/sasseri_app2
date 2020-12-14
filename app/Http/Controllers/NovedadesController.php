<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Novedades;
use Illuminate\Support\Facades\Auth;

class NovedadesController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $novedades = Novedades::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $novedades = Novedades::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $novedades->total(),
                'current_page' => $novedades->currentPage(),
                'per_page'     => $novedades->perPage(),
                'last_page'    => $novedades->lastPage(),
                'from'         => $novedades->firstItem(),
                'to'           => $novedades->lastItem(),
            ],
            'novedades' => $novedades
        ];
    }

    public function listarNovedades(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $novedades = Novedades::where('id_tercero','=', $request->id)->get();

        return ['novedades' => $novedades];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        $novedades = new Novedades();
        $novedades->nombre = $request->nombre;
        $novedades->observacion = $request->observacion;
        $novedades->link = $request->link;
        $novedades->id_tercero = $request->id_tercero;
        $novedades->usu_crea = $id_usuario;
        $novedades->id_empresa = $id_empresa;

        $novedades->save();
    }

    public function eliminarNovedad(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $novedades = Novedades::findOrFail($request->id)->delete();
    }
}
