<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PlanCuentasCategorias;
use Illuminate\Support\Facades\Auth;


class PlanCuentasCategoriasController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $planCuentasCategorias = PlanCuentasCategorias::orderBy('id', 'desc')->paginate(6);
        }
        else{
            $planCuentasCategorias = PlanCuentasCategorias::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(6);
        }
        

        return [
            'pagination' => [
                'total'        => $planCuentasCategorias->total(),
                'current_page' => $planCuentasCategorias->currentPage(),
                'per_page'     => $planCuentasCategorias->perPage(),
                'last_page'    => $planCuentasCategorias->lastPage(),
                'from'         => $planCuentasCategorias->firstItem(),
                'to'           => $planCuentasCategorias->lastItem(),
            ],
            'planCuentasCategorias' => $planCuentasCategorias
        ];
    }

    public function selectPlanCuentasCategorias(Request $request){
        if (!$request->ajax()) return redirect('/');
        $planCuentasCategorias = PlanCuentasCategorias::join('categorias','plan_cuentas_categorias.id_categoria','=','categorias.id')
        ->select('id_categoria as id','categorias.nombre')
        ->where('plan_cuentas_categorias.id_plan_cuentas','=',$request->id_plan_cuentas)
        ->orderBy('plan_cuentas_categorias.id', 'asc')
        ->get();
        
        return ['planCuentasCategorias' => $planCuentasCategorias];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        $planCuentasCategorias = new PlanCuentasCategorias();
        $planCuentasCategorias->colaborador = $request->colaborador;
        $planCuentasCategorias->observacion = $request->observacion;
        $planCuentasCategorias->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $planCuentasCategorias = PlanCuentasCategorias::findOrFail($request->id);
        $planCuentasCategorias->colaborador = $request->colaborador;
        $planCuentasCategorias->observacion = $request->observacion;
        $planCuentasCategorias->vendedor = $request->vendedor;
        $planCuentasCategorias->cobrador = $request->cobrador;
        $planCuentasCategorias->save();
    }
}
