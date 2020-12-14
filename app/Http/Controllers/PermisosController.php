<?php

namespace App\Http\Controllers;

use App\Rol;
use App\Modulo;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PermisosController extends Controller
{
    public function listarPermisosLogueado()
    {   
        $permisos = DB::table('modulos_empresas_usuarios')
        ->join('modulos_empresas', 'modulos_empresas_usuarios.modulos_empresas_id', '=', 'modulos_empresas.id')
        ->join('modulos', 'modulos_empresas.modulos_id', '=', 'modulos.id')
        ->where('modulos_empresas_usuarios.usuarios_id', '=', Auth::user()->id)
        ->select(
            'modulos.template',
            'modulos_empresas_usuarios.crear',
            'modulos_empresas_usuarios.leer',
            'modulos_empresas_usuarios.actualizar',
            'modulos_empresas_usuarios.anular',
            'modulos_empresas_usuarios.imprimir'
        )->get();

        $permisosLogueado = array();
        foreach ($permisos as $permiso) {
            $permisosLogueado [$permiso->template] = array(
                'crear' => $permiso->crear,
                'leer' => $permiso->leer,
                'actualizar' => $permiso->actualizar,
                'anular' => $permiso->anular,
                'imprimir' => $permiso->imprimir
            );
        }

        return ['permisosLogueado' => $permisosLogueado];
    }
    
    private static function obtenerModulos($tipo, $empresas_id)
    {
        return DB::table('modulos_empresas')
        ->join('modulos', 'modulos_empresas.modulos_id', '=', 'modulos.id')
        ->where([
            ['modulos_empresas.empresas_id', '=', $empresas_id],
            ['modulos.tipo', '=', $tipo],
            ['modulos_empresas.estado', '=', 1]
        ])
        ->select('modulos_empresas.modulos_id',
        'modulos_empresas.id',
        'modulos.nombre',
        'modulos.tipo',
        'modulos.padre')->orderBy('modulos.nombre')->get();
    }
    public function listarPermisos(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $empresa_id = Auth::user()->empresas_id;
        $modulosPadre = self::obtenerModulos(1, $empresa_id);
        $modulosHijo = self::obtenerModulos(2, $empresa_id);

        $modulosEmpresa = [];
        foreach ($modulosPadre as $padre) {
            $modulosEmpresa[] = $padre;
            foreach ($modulosHijo as $hijo) {
                if ($hijo->padre == $padre->modulos_id) {
                    $modulosEmpresa[] = $hijo;                
                }
            }
        }

        $permisos = DB::table('modulos_empresas_usuarios')
        ->join('users', 'modulos_empresas_usuarios.usu_crea', '=', 'users.id')
        ->rightJoin('modulos_empresas', 'modulos_empresas_usuarios.modulos_empresas_id', '=', 'modulos_empresas.id')
        ->join('modulos', 'modulos_empresas.modulos_id', '=', 'modulos.id')
        ->where([
            ['modulos_empresas_usuarios.usuarios_id', '=', $request->usuario_id],
            ['modulos_empresas.estado', '=', 1]
        ])
        ->select('modulos_empresas_usuarios.id',
            'modulos_empresas_usuarios.modulos_empresas_id',
            'modulos_empresas_usuarios.crear',
            'modulos_empresas_usuarios.leer',
            'modulos_empresas_usuarios.actualizar',
            'modulos_empresas_usuarios.anular',
            'modulos_empresas_usuarios.imprimir')->get();
        
        $clavePadre = 0;
        foreach ($modulosEmpresa as $claveModEmp => $modulo) {
            $modulo->id_modulos_empresas_usuarios = null;
            $modulo->crear = 0;
            $modulo->leer = 0;
            $modulo->actualizar = 0;
            $modulo->anular = 0;
            $modulo->imprimir = 0;

            if ($modulo->padre == null) {
                $clavePadre = $claveModEmp;
            }
            foreach ($permisos as $claveP => $permiso) {
                if ($permiso->modulos_empresas_id == $modulo->id) {
                    $modulo->id_modulos_empresas_usuarios = $permiso->id;
                    $modulo->crear = $permiso->crear;
                    $modulo->leer = $permiso->leer;
                    $modulo->actualizar = $permiso->actualizar;
                    $modulo->anular = $permiso->anular;
                    $modulo->imprimir = $permiso->imprimir;

                    if ($modulosEmpresa[$clavePadre]->crear == 0) {$modulosEmpresa[$clavePadre]->crear = $modulo->crear;}
                    if ($modulosEmpresa[$clavePadre]->leer == 0) {$modulosEmpresa[$clavePadre]->leer = $modulo->leer;}
                    if ($modulosEmpresa[$clavePadre]->actualizar == 0) {$modulosEmpresa[$clavePadre]->actualizar = $modulo->actualizar;}
                    if ($modulosEmpresa[$clavePadre]->anular == 0) {$modulosEmpresa[$clavePadre]->anular = $modulo->anular;}
                    if ($modulosEmpresa[$clavePadre]->imprimir == 0) {$modulosEmpresa[$clavePadre]->imprimir = $modulo->imprimir;}
                }
            }
        }

        # REORDENA LOS MODULOS DE MENOR A MAYOR
        # $arrModulosEmpresa = json_decode(json_encode($modulosEmpresa), true);
        /*$arrModulosPermisos = $modulosEmpresa->toArray();
        usort($arrModulosPermisos, function ($a, $b) {
            return $a->menu - $b->menu;
        });*/

        $respuesta = ['permisos' => $modulosEmpresa];

        if ($request->cargarSelector == 1) {
            $respuesta['roles'] = Rol::where('estado', '=', '1')->select('id','nombre')->get();

            $respuesta['rolesPermisos']  = DB::table('roles_permisos')
            ->join('modulos', 'roles_permisos.id_modulo', '=', 'modulos.id')
            ->whereIn('id_rol', $respuesta['roles']->pluck('id'))
            ->whereIn('id_modulo', $modulosHijo->pluck('modulos_id'))
            ->select(
                'roles_permisos.id_rol',
                'roles_permisos.id_modulo',
                'modulos.padre',
                'roles_permisos.escritura',
                'roles_permisos.lectura',
                'roles_permisos.edicion',
                'roles_permisos.anular',
                'roles_permisos.imprimir')->orderBy('modulos.nombre')->get();
        }

        return $respuesta;
    }

    public function listarPermisos2(Request $request)
    {
        $empresas_id = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;
        $resultado=array();
        //$modulosPadre = self::obtenerModulos(1, $empresas_id);
        $cons="SELECT * FROM modulos_empresas_usuarios,modulos_empresas,modulos WHERE usuarios_id=$id_usuario and modulos_empresas.empresas_id=$empresas_id and modulos_empresas_id = modulos_empresas.id and modulos_id=modulos.id AND tipo=1 ";
        $respuesta = DB::select($cons);
        foreach($respuesta as $res){
            
            $hijos = array();
            
            $cons2="SELECT * FROM modulos_empresas_usuarios,modulos_empresas,modulos WHERE usuarios_id=$id_usuario and modulos_empresas.empresas_id=$empresas_id and modulos_empresas_id = modulos_empresas.id and modulos_id=modulos.id AND padre =  ".$res->id;
            $respuesta2 = DB::select($cons2);

            foreach($respuesta2 as $res2){
                $hijos[] = ["modulo"=>$res2->nombre,"icono"=>$res2->nombre,"menu"=>$res2->menu, "lectura"=>$res2->leer, "escritura"=>$res2->crear, "editar"=>$res2->actualizar, "anular"=>$res2->anular, "imprimir"=>$res2->imprimir,"hijos" =>array(),"template_menu"=>$res2->template];
            }
            
            $resultado[] = ["modulo"=>$res->nombre,"icono"=>$res->nombre,"menu"=>$res->menu, "lectura"=>$res->leer, "escritura"=>$res->crear, "editar"=>$res->actualizar, "anular"=>$res->anular, "imprimir"=>$res->imprimir,"hijos" =>$hijos,"template_menu"=>$res->template];
        }
        return [
            $resultado,
            // $request->session()->get('menu_usu'),
        ];
    }

    public function insertar(Request $request)
    {
        $permisos = $request->all();
        $usuarioId = current($permisos)['usuarios_id'];
        $creadoPor = Auth::user()->id;

        $arrNuevosPermisos = $arrPermisosExistentes = [];
        foreach ($permisos as $indice => $permiso) {
            # VERIFICA SI ES MODULO PADRE
            if ($permiso['padre'] == null) {
                # VERIFICA QUE EL MODULO PADRE NO ESTÉ REGISTRADO
                if ($permiso['id_modulos_empresas_usuarios'] == null) {
                    $insertarPadre = false;
                    # VERIFICA LA PRIMERA VEZ, QUE HAYA AL MENOS UN MODULO HIJO PARA REGISTRAR...
                    for ($i = $indice + 1; $i < count($permisos) && $permisos[$i]['padre'] != null; $i++) { 
                        if ($permisos[$i]['crear'] == 1 || $permisos[$i]['leer'] == 1 || $permisos[$i]['actualizar'] == 1 || $permisos[$i]['anular'] == 1 || $permisos[$i]['imprimir'] == 1) {
                            $insertarPadre = true;
                            break;
                        }
                    }
                    # ...SOLO SI LOS HAY, TAMBIEN SE REGISTRA EL MODULO PADRE...
                    if ($insertarPadre) {
                        $arrNuevosPermisos[] = [
                            'modulos_empresas_id' => $permiso['id'],
                            'usuarios_id' => $permiso['usuarios_id'],
                            'crear' => 0,
                            'leer' => 0,
                            'actualizar' => 0,
                            'anular' => 0,
                            'imprimir' => 0,
                            'usu_crea' => $creadoPor
                        ];
                    }
                    # ...UNA VEZ REGISTRADO EL MODULO PADRE, ESTE SE MANTENDRA INCLUSO SI TODOS SUS MODULOS HIJOS SON ELIMINADOS
                }
            } else {
                # VERIFICA SI EXISTE EL REGISTRO DEL MODULO HIJO, ENTONCES TOMA SU ID PARA ELIMINARLO MAS ADELANTE
                if ($permiso['id_modulos_empresas_usuarios'] != null) {
                    $arrPermisosExistentes[] = $permiso['id_modulos_empresas_usuarios'];
                }
                # VERIFICA SI EL HIJO TIENE AL MENOS UN PERMISO MARCADO
                if ($permiso['crear'] == 1 || $permiso['leer'] == 1 || $permiso['actualizar'] == 1 || $permiso['anular'] == 1 || $permiso['imprimir'] == 1) {
                    $arrNuevosPermisos[] = [
                        'modulos_empresas_id' => $permiso['id'],
                        'usuarios_id' => $permiso['usuarios_id'],
                        'crear' => $permiso['crear'],
                        'leer' => $permiso['leer'],
                        'actualizar' => $permiso['actualizar'],
                        'anular' => $permiso['anular'],
                        'imprimir' => $permiso['imprimir'],
                        'usu_crea' => $creadoPor
                    ];
                }
            }
        }

        try{
            DB::beginTransaction();
            //DB::enableQueryLog();
            DB::table('modulos_empresas_usuarios')->whereIn('id', $arrPermisosExistentes)->delete();
            //echo '<pre>'. response()->json(DB::getQueryLog()) .'</pre>';exit;
            if (count($arrNuevosPermisos) > 0) {
                DB::table('modulos_empresas_usuarios')->insert($arrNuevosPermisos);
            }
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }  
    }
}