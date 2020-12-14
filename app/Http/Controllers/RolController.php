<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;
use App\RolPermisos;
use App\Modulo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RolController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $roles = Rol::where('id_empresa','=',$id_empresa)->orderBy('id', 'desc')->get();
        }
        else{
            $roles = Rol::where('id_empresa','=',$id_empresa)->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->get();
        }
        
        $roles2 = Rol::select('id','nombre','estado')->where('id_empresa','=',$id_empresa)->groupBy('nombre')->orderBy('id','desc')->paginate(6);

        return [
            'pagination' => [
                'total'        => $roles2->total(),
                'current_page' => $roles2->currentPage(),
                'per_page'     => $roles2->perPage(),
                'last_page'    => $roles2->lastPage(),
                'from'         => $roles2->firstItem(),
                'to'           => $roles2->lastItem(),
            ],
            // 'page' => $request->page,
            // 'buscar' => $buscar,
            // 'criterio' => $criterio,
            'roles' => $roles,
            'roles2' => $roles2
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        $roles = new Rol();
        $roles->nombre = $request->nombre;
        $roles->id_empresa = $id_empresa;
        $roles->usu_crea = $id_usuario;
        $roles->save();

        $modulos = $request->modulos;

        foreach($modulos as $mod)
        {
            $permisos = new RolPermisos();
            $permisos->id_rol = $roles->id;
            $permisos->id_modulo = $mod['id'];
            $permisos->id_empresa = $id_empresa;
            $ban = 0;

            if(isset($mod['lectura']) && $mod['lectura']==true)
            {
                $permisos->lectura = 1;
                $ban = 1;
            }

            if(isset($mod['escritura']) && $mod['escritura']==true)
            {
                $permisos->escritura = 1;
                $ban = 1;
            }

            if(isset($mod['edicion']) && $mod['edicion']==true)
            {
                $permisos->edicion = 1;
                $ban = 1;
            }

            if(isset($mod['anular']) && $mod['anular']==true)
            {
                $permisos->anular = 1;
                $ban = 1;
            }

            if(isset($mod['imprimir']) && $mod['imprimir']==true)
            {
                $permisos->imprimir = 1;
                $ban = 1;
            }


            $permisos->usu_crea = $id_usuario;

            if($ban==1)
            {
                $permisos->save();
            }

        }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        $roles = Rol::findOrFail($request->id);
        $roles->nombre = $request->nombre;
        $roles->id_empresa = $id_empresa;
        $roles->save();
        
        $borrarPermisos = RolPermisos::where('id_rol','=',$request->id)->delete();

        $modulos = $request->modulos;

        foreach($modulos as $mod)
        {
            $permisos = new RolPermisos();
            $permisos->id_rol = $roles->id;
            $permisos->id_modulo = $mod['id'];
            $permisos->id_empresa = $id_empresa;
            $ban = 0;

            if(isset($mod['lectura']) && $mod['lectura']==true)
            {
                $permisos->lectura = 1;
                $ban = 1;
            }

            if(isset($mod['escritura']) && $mod['escritura']==true)
            {
                $permisos->escritura = 1;
                $ban = 1;
            }

            if(isset($mod['edicion']) && $mod['edicion']==true)
            {
                $permisos->edicion = 1;
                $ban = 1;
            }

            if(isset($mod['anular']) && $mod['anular']==true)
            {
                $permisos->anular = 1;
                $ban = 1;
            }

            if(isset($mod['imprimir']) && $mod['imprimir']==true)
            {
                $permisos->imprimir = 1;
                $ban = 1;
            }


            $permisos->usu_crea = $id_usuario;

            if($ban==1)
            {
                $permisos->save();
            }

        }
    }

    public function listarPermisos(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id_rol = $request->id_rol;
        $id_empresa = $request->session()->get('id_empresa');
        
        $total = array();
        $modu = array();
        $permi = array();
        $permisos = array();

        $modulos = Modulo::join('users','modulos.usu_crea','=','users.id')
        ->select('modulos.id','modulos.nombre','modulos.descripcion','modulos.componente','modulos.menu','modulos.tipo','modulos.icono','modulos.template','modulos.padre','modulos.estado')
        ->where('tipo','=','1')
        ->where('estado','=','1')
        ->orderBy('nombre', 'asc')
        ->get();

        foreach($modulos as $mod)
        {
            $total[] = $mod;
            $modulos2= Modulo::where('tipo','=','2')
            ->where('padre','=',$mod['id'])
            ->where('estado','=','1')
            ->orderBy('nombre','asc')
            ->get();
            foreach($modulos2 as $mod2)
            {
                $total[] = $mod2;
            }
        }

        if($id_rol!='' && $id_rol!=null && $id_rol!=0)
        {
            foreach($total as $t)
            {
                $modu = array(
                    'id' => $t['id'],
                    'nombre' => $t['nombre'],
                    'id_rol' => $id_rol,
                    'tipo' => $t['tipo'],
                );

                $permisos = RolPermisos::where('id_rol','=',$id_rol)
                ->where('id_modulo', '=', $t['id'])
                ->get();
                
                if(count($permisos)!=0)
                {
                    foreach($permisos as $pe)
                    {
                        $permi = array(
                            'lectura' => $pe['lectura'],
                            'escritura' => $pe['escritura'],
                            'edicion' => $pe['edicion'],
                            'anular' => $pe['anular'],
                            'imprimir' => $pe['imprimir'],
                        );
                    }
                }
                else
                {
                    $permi = array(
                        'lectura' => '',
                        'escritura' => '',
                        'edicion' => '',
                        'anular' => '',
                        'imprimir' => '',
                    );
                }

                $respuesta[] = array_merge($modu, $permi);
            }
        }
        else
        {
            $respuesta = $total;
        }
        
        
        return [
            'permisos' => $respuesta,
        ];
    }

    public function selectRol(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $roles = Rol::where('estado', '=', '1')
        ->select('id','nombre')
        ->orderBy('nombre', 'asc')->get();

        return ['roles' => $roles];
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $roles = Rol::findOrFail($request->id);
        $roles->estado = '0';
        $roles->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $roles = Rol::findOrFail($request->id);
        $roles->estado = '1';
        $roles->save();
    }
}
