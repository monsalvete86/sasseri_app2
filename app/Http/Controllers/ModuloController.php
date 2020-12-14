<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modulo;
use App\RolPermisos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ModuloController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $usu_crea = Auth::user()->id;
        
        if ($buscar=='' && $buscar==null){
            $total = array();
            $modulos = Modulo::join('users','modulos.usu_crea','=','users.id')->select('modulos.id','modulos.nombre','modulos.descripcion','modulos.componente','modulos.menu','modulos.tipo','modulos.icono','modulos.template','modulos.padre','modulos.estado')->where('tipo','=','1')->orderBy('nombre', 'asc')->get();
            foreach($modulos as $mod)
            {   
                $total[] = $mod;
                $modulos2= Modulo::where('tipo','=','2')->where('padre','=',$mod['id'])->orderBy('nombre','asc')->get();
                foreach($modulos2 as $mod2)
                {
                    $total[] = $mod2;
                }
            }
        }
        else{
            $total = Modulo::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->get();
        }
        

        return [
            'modulos' => $total,
        ];
    }
    // public function selectModulo(Request $request)
    // {
    //     $modulos = Rol::where('condicion', '=', '1')
    //     ->select('id','nombre')
    //     ->orderBy('nombre', 'asc')->get();

    //     return ['modulos' => $modulos];
    // }

    public function store(Request $request){
        if (!$request->ajax()) return redirect('/');
        $usu_crea = Auth::user()->id;
        $modulo = new Modulo();
        $modulo->nombre = $request->nombre;
        $modulo->descripcion = $request->descripcion;
        $modulo->estado = '1';
        $modulo->usu_crea = $usu_crea;
        $modulo->componente = $request->componente;
        $modulo->menu = $request->menu;
        $modulo->tipo = $request->tipo;
        $modulo->icono = $request->icono;
        $modulo->template = $request->template;
        $modulo->padre = $request->padre;
        $modulo->save();
    }
    public function update(Request $request){
        $tipo = $request->tipo;

        $usu_crea = Auth::user()->id;
        $modulo = Modulo::findOrFail($request->id);
        $modulo->nombre = $request->nombre;
        $modulo->descripcion = $request->descripcion;
        $modulo->estado = '1';
        $modulo->usu_crea = $usu_crea;
        $modulo->componente = $request->componente;
        $modulo->menu = $request->menu;
        // $id = $request->id;
        if($request->tipo=='1'){
        $modulo->padre = null;
        $modulo->tipo = $request->tipo;
        }

        if($request->tipo=='2'){
            $modulo->padre = $request->padre;
            $modulo->tipo = $request->tipo;
        }
        
        $modulo->icono = $request->icono;
        $modulo->template = $request->template;
        $modulo->save();
    }

    public function cambiarHijos(Request $request){

        
        $tipo = $request->tipo;
        if($tipo=='2'){
            $buscarHijos= Modulo::where('padre','=',$request->id)->get();
            if($buscarHijos)
            {
                foreach($buscarHijos as $bh)
                {
                    $cambiarPadres = Modulo::findOrFail($bh['id']);
                 
                    $cambiarPadres->padre = null;
                    $cambiarPadres->tipo = '1';
                    $cambiarPadres->save();
                }
            } 
        }
    }
    
    public function selectPadre(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $modulos = Modulo::where('estado', '=', '1')->where('tipo','=','1')
        ->select('id','nombre')
        ->orderBy('nombre', 'asc')->get();

        return ['modulos' => $modulos];
    }
    public function desactivarHijos(Request $request)
    {
        $buscarHijos= Modulo::where('padre','=',$request->id)->get();
        if($buscarHijos)
        {
            foreach($buscarHijos as $bh)
            {
                $desactivar = Modulo::findOrFail($bh['id']);
                $desactivar->estado = '0';
                $desactivar->save();
            }
        }
    }
    public function activarHijos(Request $request)
    {
        $buscarHijos= Modulo::where('padre','=',$request->id)->get();
        if($buscarHijos)
        {
            foreach($buscarHijos as $bh)
            {
                $activar = Modulo::findOrFail($bh['id']);
                $activar->estado = '1';
                $activar->save();
            }
        }
    }
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $modulo = Modulo::findOrFail($request->id);
        $modulo->estado = '0';
        $modulo->save();

        $roles = RolPermisos::where('id_modulo','=',$request->id)->get();
        foreach($roles as $r)
        {
            $roles2 = RolPermisos::findOrFail($r['id']);
            $roles2->estado = '0';
            $roles2->save();
        }

        $cons="UPDATE `modulos_empresas` SET `estado` = '0' WHERE `modulos_id` = $request->id";
        $modulos_empresas = DB::update($cons);
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $modulo = Modulo::findOrFail($request->id);
        $modulo->estado = '1';
        $modulo->save();

        $roles = RolPermisos::where('id_modulo','=',$request->id)->get();
        foreach($roles as $r)
        {
            $roles2 = RolPermisos::findOrFail($r['id']);
            $roles2->estado = '1';
            $roles2->save();
        }

        $cons="UPDATE `modulos_empresas` SET `estado` = '1' WHERE `modulos_id` = $request->id";
        $modulos_empresas = DB::update($cons);
    }
}
