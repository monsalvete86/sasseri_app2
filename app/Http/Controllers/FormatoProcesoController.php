<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\FormatoProceso;
use App\Conf_formatos;
use Illuminate\Support\Facades\Auth;

class FormatoProcesoController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        
        if ($buscar==''){
            $formato_proceso = FormatoProceso::where('id_empresa','=',$id_empresa)
            ->orderBy('id', 'desc')
            ->paginate(3);
        }
        else{
            $formato_proceso = FormatoProceso::where('id_empresa','=',$id_empresa)->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }        

        return [
            'pagination' => [
                'total'        => $formato_proceso->total(),
                'current_page' => $formato_proceso->currentPage(),
                'per_page'     => $formato_proceso->perPage(),
                'last_page'    => $formato_proceso->lastPage(),
                'from'         => $formato_proceso->firstItem(),
                'to'           => $formato_proceso->lastItem(),
            ],
            'formato_proceso' => $formato_proceso
        ];
    }

    public function selectFormatoProceso(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $formato_proceso = FormatoProceso::select('id','nombre')->where('id_empresa','=',$id_empresa)->orderBy('nombre', 'asc')->get();
        
        return ['formato_proceso' => $formato_proceso];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        if($request->idFormatoCompras!=0){$idFormatoCompras=$request->idFormatoCompras;}else{$idFormatoCompras=0;}
        if($request->idFormatoVentas!=0){$idFormatoVentas=$request->idFormatoVentas;}else{$idFormatoVentas=0;}
        if($request->idFormatoSalidas!=0){$idFormatoSalidas=$request->idFormatoSalidas;}else{$idFormatoSalidas=0;}

        $borrar_formato_proceso = FormatoProceso::where('id_empresa','=',$id_empresa)->delete();

        $formato_proceso = new FormatoProceso();
        $formato_proceso->idFormatoCompras = $idFormatoCompras;
        $formato_proceso->idFormatoVentas = $idFormatoVentas;
        $formato_proceso->idFormatoSalidas = $idFormatoSalidas;
        $formato_proceso->id_empresa = $id_empresa;
        $formato_proceso->usu_crea = $id_usuario;
        $formato_proceso->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        if($request->idFormatoCompras!=0){$idFormatoCompras=$request->idFormatoCompras;}else{$idFormatoCompras=0;}
        if($request->idFormatoVentas!=0){$idFormatoVentas=$request->idFormatoVentas;}else{$idFormatoVentas=0;}
        if($request->idFormatoSalidas!=0){$idFormatoSalidas=$request->idFormatoSalidas;}else{$idFormatoSalidas=0;}

        $formato_proceso = FormatoProceso::where('id_empresa','=',$id_empresa)->get();
        // return $formato_proceso;

        if($formato_proceso)
        {
            $formato_proceso->idFormatoCompras = $idFormatoCompras;
            $formato_proceso->idFormatoVentas = $idFormatoVentas;
            $formato_proceso->idFormatoSalidas = $idFormatoSalidas;
            $formato_proceso->save();
        }
        else
        {
            $crear_formato_proceso = new FormatoProceso();
            $crear_formato_proceso->idFormatoCompras = $idFormatoCompras;
            $crear_formato_proceso->idFormatoVentas = $idFormatoVentas;
            $crear_formato_proceso->idFormatoSalidas = $idFormatoSalidas;
            $crear_formato_proceso->id_empresa = $id_empresa;
            $crear_formato_proceso->id_usuario = $id_usuario;
            $crear_formato_proceso->save();
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $formato_proceso = FormatoProceso::findOrFail($request->id);
        $formato_proceso->estado = '0';
        $formato_proceso->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $formato_proceso = FormatoProceso::findOrFail($request->id);
        $formato_proceso->estado = '1';
        $formato_proceso->save();
    }
}
