<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Plancuentas_model;
use App\PlanCuentasCategorias;
use Illuminate\Support\Facades\Auth;


class PlanCuentas extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        // echo "criterio=$criterio buscar=$buscar"; exit;     
        if ($buscar==''){
            $planCuenta = Plancuentas_model::leftJoin('plan_cuentas as cuentas2','plan_cuentas.id_cuenta_cierre','=','cuentas2.id')
            ->leftJoin('personas','plan_cuentas.id_tercero','=','personas.id')
            ->select('plan_cuentas.id','plan_cuentas.codigo','plan_cuentas.nombre','plan_cuentas.naturaleza','plan_cuentas.tipo','plan_cuentas.corriente','plan_cuentas.banco','plan_cuentas.diferido','plan_cuentas.tercero','plan_cuentas.niif','plan_cuentas.id_empresa','plan_cuentas.condicion','plan_cuentas.anio','plan_cuentas.id_cuenta_cierre','plan_cuentas.evitar_saldo_negativo','cuentas2.nombre as cuenta_cierre','cuentas2.codigo as codigo_cuenta_cierre','plan_cuentas.id_tercero','plan_cuentas.tipo_cuenta_compra','plan_cuentas.tipo_cuenta_salida_almacen','personas.nombre2 as nom_tercero','personas.apellido1 as apellido_tercero','personas.num_documento as num_doc_tercero','plan_cuentas.orden')
            ->where('plan_cuentas.id_empresa','=',$id_empresa)->orderBy('plan_cuentas.codigo', 'asc')->paginate(10);
        }
        else{
            $planCuenta = Plancuentas_model::leftJoin('plan_cuentas as cuentas2','plan_cuentas.id_cuenta_cierre','=','cuentas2.id')
            ->leftJoin('personas','plan_cuentas.id_tercero','=','personas.id')
            ->select('plan_cuentas.id','plan_cuentas.codigo','plan_cuentas.nombre','plan_cuentas.naturaleza','plan_cuentas.tipo','plan_cuentas.corriente','plan_cuentas.banco','plan_cuentas.diferido','plan_cuentas.tercero','plan_cuentas.niif','plan_cuentas.id_empresa','plan_cuentas.condicion','plan_cuentas.anio','plan_cuentas.id_cuenta_cierre','plan_cuentas.evitar_saldo_negativo','cuentas2.nombre as cuenta_cierre','cuentas2.codigo as codigo_cuenta_cierre','plan_cuentas.id_tercero','plan_cuentas.tipo_cuenta_compra','plan_cuentas.tipo_cuenta_salida_almacen','personas.nombre2 as nom_tercero','personas.apellido1 as apellido_tercero','personas.num_documento as num_doc_tercero','plan_cuentas.orden')
            ->where('plan_cuentas.id_empresa','=',$id_empresa)
            ->where('plan_cuentas.'.$criterio, 'like',  $buscar . '%')
            ->orderBy('plan_cuentas.codigo', 'asc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $planCuenta->total(),
                'current_page' => $planCuenta->currentPage(),
                'per_page'     => $planCuenta->perPage(),
                'last_page'    => $planCuenta->lastPage(),
                'from'         => $planCuenta->firstItem(),
                'to'           => $planCuenta->lastItem(),
            ],
            'planCuentas' => $planCuenta
        ];
    }

    public function selectCuenta(Request $request){
        //if (!$request->ajax()) return redirect('/');
        //print_r($request);
        $filtro = $request->filtro;
       // echo "filtro=$filtro";
        if($filtro){
           
            $condicion="codigo"; $valor="$filtro%";
        }
        else{
            $condicion='condicion'; $valor='1';
        }
        $planCuenta = Plancuentas_model::where('condicion','=','1')->where($condicion,'like',$valor)
        ->select('id','codigo','nombre')->orderBy('nombre', 'asc')->get();
        return ['cuentas' => $planCuenta];
    }


    public function selectCuenta2(Request $request){
        //if (!$request->ajax()) return redirect('/');
        //print_r($request);
        $filtro = $request->filtro;
       // echo "filtro=$filtro";
        if($filtro){
           
            $condicion="codigo"; $valor="$filtro%";
        }
        else{
            $condicion='condicion'; $valor='1';
        }
        $planCuenta = Plancuentas_model::where('tipo','=','Detalle')->where('condicion','=','1')->where($condicion,'like',$valor)
        ->select('id','codigo','nombre','tipo','naturaleza')->orderBy('anio', 'desc')->orderBy('nombre', 'asc')->get();
        return ['cuentas' => $planCuenta];
    }

    public function selectCuentaInfo(Request $request){
        //if (!$request->ajax()) return redirect('/');
        //print_r($request);
        $busqueda = $request->busqueda;
        
       // echo "filtro=$filtro";
        
        $planCuenta = Plancuentas_model::where('condicion','=','1')->where('codigo','like',$busqueda.'%')->orWhere('nombre','like','%'.$busqueda.'%')
        ->select('id','codigo','nombre','tipo','naturaleza')->orderBy('nombre', 'asc')->get();
        return ['cuentas' => $planCuenta];
    }
   
    public function store(Request $request)
    {

        if (!$request->ajax()) return redirect('/');
        $planCuenta = new Plancuentas_model();
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;
        
        $planCuenta->codigo = $request->codigo;
        $planCuenta->nombre = $request->nombre;
        $planCuenta->naturaleza = $request->naturaleza;
        $planCuenta->tipo = $request->tipo;
        $planCuenta->corriente = $request->corriente;
        $planCuenta->diferido = $request->diferido;
        $planCuenta->tercero = $request->tercero;
        $planCuenta->niif = $request->niif;
        $planCuenta->id_empresa = $id_empresa;
        $planCuenta->anio = $request->anio;
        $planCuenta->id_cuenta_cierre = $request->id_cuenta_cierre;
        $planCuenta->evitar_saldo_negativo = $request->evitar_saldo_negativo;
        $planCuenta->id_tercero = $request->id_tercero;
        $planCuenta->tipo_cuenta_compra = $request->tipo_cuenta_compra;
        $planCuenta->tipo_cuenta_salida_almacen = $request->tipo_cuenta_salida_almacen;
        $planCuenta->condicion = $request->condicion; 
        $planCuenta->orden = $request->orden; 
        if($request->banco)
            $planCuenta->banco = 1;
        $planCuenta->save();
        //echo "lleggaaaaa ".$request->nombre;

        $id_categorias = $request->id_categorias;
        foreach($id_categorias as $id_cat){
            $categorias = new PlanCuentasCategorias();
            $categorias->id_plan_cuentas = $planCuenta->id;
            $categorias->id_categoria = $id_cat['id'];
            $categorias->usu_crea = $id_usuario;
            $categorias->save();
        }

    }
  

  
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;
        $planCuenta = Plancuentas_model::findOrFail($request->id);
        
        //return "request = ".$request->banco; 
        $planCuenta->codigo = $request->codigo;
        $planCuenta->nombre = $request->nombre;
        $planCuenta->naturaleza = $request->naturaleza;
        $planCuenta->tipo = $request->tipo;
        $planCuenta->corriente = $request->corriente;
        $planCuenta->diferido = $request->diferido;
        $planCuenta->tercero = $request->tercero;
        $planCuenta->niif = $request->niif;
        $planCuenta->id_empresa = $id_empresa;
        $planCuenta->anio = $request->anio;
        $planCuenta->id_cuenta_cierre = $request->id_cuenta_cierre;
        $planCuenta->evitar_saldo_negativo = $request->evitar_saldo_negativo;
        if($request->banco == 1) 
            $planCuenta->banco = '1';
        $planCuenta->tipo_cuenta_compra = $request->tipo_cuenta_compra;
        $planCuenta->tipo_cuenta_salida_almacen = $request->tipo_cuenta_salida_almacen;
        $planCuenta->id_tercero = $request->id_tercero;  
        $planCuenta->orden = $request->orden;        
        $planCuenta->condicion = '1';
        $planCuenta->save();

        $borrar = PlanCuentasCategorias::where('id_plan_cuentas','=',$planCuenta->id)->delete();

        $id_categorias = $request->id_categorias;
        foreach($id_categorias as $id_cat){
            $categorias = new PlanCuentasCategorias();
            $categorias->id_plan_cuentas = $planCuenta->id;
            $categorias->id_categoria = $id_cat['id'];
            $categorias->usu_crea = $id_usuario;
            $categorias->save();
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $planCuenta = Plancuentas_model::findOrFail($request->id);
        $planCuenta->condicion = '0';
        $planCuenta->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $planCuenta = Plancuentas_model::findOrFail($request->id);
        $planCuenta->condicion = '1';
        $planCuenta->save();
    }
    
}
