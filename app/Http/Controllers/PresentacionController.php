<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Presentacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PresentacionController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        
        $presentacion = Presentacion::where('id_empresa','=',$id_empresa);
        if($buscar!='')
        {
            $presentacion = $presentacion->where('nombre', 'like', '%'. $buscar . '%');
        }
        $presentacion = $presentacion->orderBy('id', 'desc')->paginate(3);        

        return [
            'pagination' => [
                'total'        => $presentacion->total(),
                'current_page' => $presentacion->currentPage(),
                'per_page'     => $presentacion->perPage(),
                'last_page'    => $presentacion->lastPage(),
                'from'         => $presentacion->firstItem(),
                'to'           => $presentacion->lastItem(),
            ],
            'presentacion' => $presentacion
        ];
    }

    public function selectPresentacion(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        if(isset($request->idProductoPresentacionAsociada))
        {
            $sql = "SELECT id_presentacion FROM productos_asociados WHERE id_producto=".$request->idProductoPresentacionAsociada;
            $cons = DB::select($sql);
            if(!empty($cons))
            {
                $presentacionesAsociadas = [];
                foreach($cons as $c)
                {
                    $presentacionesAsociadas[] = $c->id_presentacion;
                }
            }
        }

        $presentacion = Presentacion::select('id','nombre')
        ->where('id_empresa','=',$id_empresa);
        if(isset($request->idPresentacionAsociada))
        {
            $presentacion = $presentacion->where('presentacion.id','!=',$request->idPresentacionAsociada);
        }
        if(isset($presentacionesAsociadas) && !empty($presentacionesAsociadas) && $presentacionesAsociadas!='')
        {
            $presentacion = $presentacion->whereNotIn('presentacion.id',$presentacionesAsociadas);
        }
        $presentacion = $presentacion->orderBy('nombre', 'asc')->get();
        
        return ['presentacion' => $presentacion];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        $presentacion = new Presentacion();
        $presentacion->nombre = $request->nombre;
        $presentacion->id_empresa = $id_empresa;
        $presentacion->usu_crea = $id_usuario;
        $presentacion->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $presentacion = Presentacion::findOrFail($request->id);
        $presentacion->nombre = $request->nombre;
        $presentacion->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $presentacion = Presentacion::findOrFail($request->id);
        $presentacion->estado = '0';
        $presentacion->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $presentacion = Presentacion::findOrFail($request->id);
        $presentacion->estado = '1';
        $presentacion->save();
    }
}
