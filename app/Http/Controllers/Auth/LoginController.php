<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('auth.login');
    }
    public function index(){
        
        //return redirect('/');
    }
    public function login(Request $request){
        //if(!isset($request->usuario)||$request->password) return redirect('/');
        $menu_usu=array();
		$hijos1=array();
        //if (!$request->post()) return redirect('/');
		
        $this->validateLogin($request);        

        if (Auth::attempt(['usuario' => $request->usuario,'password' => $request->password,'condicion'=>1])){
            /*$hijos[0] = ["modulo"=>"hijo11","icono"=>"icon-home","menu"=>"17", "lectura"=>1, "escritura"=>1, "editar"=>1, "anular"=>1, "imprimir"=>1,
				"hijos" =>array(),"template_menu"=>"user"];
			$hijos[1] = ["modulo"=>"hijo12","icono"=>"icon-home","menu"=>"2", "lectura"=>1, "escritura"=>1, "editar"=>1, "anular"=>1, "imprimir"=>1,
				"hijos" =>array(),"template_menu"=>"component1"];
			$menu_usu[0] = ["modulo"=>"modulo1","icono"=>"icon-list","menu"=>"", "lectura"=>1, "escritura"=>1, "editar"=>1, "anular"=>1, "imprimir"=>1,
				"hijos" =>$hijos,"template_menu"=>""];
			
			
			$hijos1[0] = ["modulo"=>"hijo21","icono"=>"icon-home","menu"=>"3", "lectura"=>1, "escritura"=>1, "editar"=>1, "anular"=>1, "imprimir"=>1,
				"hijos" =>array(),"template_menu"=>"component1"];
			$hijos1[1] = ["modulo"=>"hijo22","icono"=>"icon-home","menu"=>"4", "lectura"=>1, "escritura"=>1, "editar"=>1, "anular"=>1, "imprimir"=>1,
				"hijos" =>array(),"template_menu"=>"component1"];
			$menu_usu[1] = ["modulo"=>"modulo2","icono"=>"icon-list","menu"=>"", "lectura"=>1, "escritura"=>1, "editar"=>1, "anular"=>1, "imprimir"=>1,
                "hijos" =>$hijos1,"template_menu"=>""];*/
            
			
            $request->session()->put('id_empresa', Auth::user()->empresas_id);
            // $request->session()->put('id_empresa', 1);

            $empresas_id = $request->session()->get('id_empresa');
            $id_usuario = Auth::user()->id;
            $resultado=array();
            //$modulosPadre = self::obtenerModulos(1, $empresas_id);
            $cons="SELECT * FROM modulos_empresas_usuarios,modulos_empresas,modulos WHERE usuarios_id=$id_usuario and modulos_empresas.empresas_id=$empresas_id and modulos_empresas_id = modulos_empresas.id and modulos_id=modulos.id AND tipo=1 AND modulos.estado=1";
            $respuesta = DB::select($cons);
            foreach($respuesta as $res){
                
                $hijos = array();
                
                $cons2="SELECT * FROM modulos_empresas_usuarios,modulos_empresas,modulos WHERE usuarios_id=$id_usuario and modulos_empresas.empresas_id=$empresas_id and modulos_empresas_id = modulos_empresas.id and modulos_id=modulos.id AND padre =  ".$res->id." AND modulos.estado=1";
                $respuesta2 = DB::select($cons2);

                foreach($respuesta2 as $res2){
                    $hijos[] = ["modulo"=>$res2->nombre,"icono"=>$res2->icono,"menu"=>$res2->menu, "lectura"=>$res2->leer, "escritura"=>$res2->crear, "editar"=>$res2->actualizar, "anular"=>$res2->anular, "imprimir"=>$res2->imprimir,"hijos" =>array(),"template_menu"=>$res2->template];
                }
                
                $resultado[] = ["modulo"=>$res->nombre,"icono"=>$res->icono,"menu"=>$res->menu, "lectura"=>$res->leer, "escritura"=>$res->crear, "editar"=>$res->actualizar, "anular"=>$res->anular, "imprimir"=>$res->imprimir,"hijos" =>$hijos,"template_menu"=>$res->template];
            }

            $request->session()->put('menu_usu', $resultado);
            return redirect()->route('main');
        }
	
        return back()
        ->withErrors(['usuario' => trans('auth.failed')])
        ->withInput(request(['usuario']));

    }

    protected function validateLogin(Request $request){
        $this->validate($request,[
            'usuario' => 'required|string',
            'password' => 'required|string'
        ]);

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
