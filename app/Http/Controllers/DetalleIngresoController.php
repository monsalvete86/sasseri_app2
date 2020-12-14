<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DetalleIngreso;
use Illuminate\Support\Facades\Auth;

class DetalleIngresoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        
        if ($buscar==''){
            $detalle_ingreso = DetalleIngreso::where('id_empresa','=',$id_empresa)->orderBy('id', 'desc')->paginate(3);
        }
        else{
            $detalle_ingreso = DetalleIngreso::where('id_empresa','=',$id_empresa)->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $detalle_ingreso->total(),
                'current_page' => $detalle_ingreso->currentPage(),
                'per_page'     => $detalle_ingreso->perPage(),
                'last_page'    => $detalle_ingreso->lastPage(),
                'from'         => $detalle_ingreso->firstItem(),
                'to'           => $detalle_ingreso->lastItem(),
            ],
            'detalle_ingreso' => $detalle_ingreso
        ];
    }

    public function selectDetalleIngreso(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $detalle_ingreso = DetalleIngreso::leftJoin('articulos','detalle_ingresos.idarticulo','=','articulos.id')
        ->select('detalle_ingresos.id','detalle_ingresos.idingreso','detalle_ingresos.idarticulo','detalle_ingresos.cantidad','detalle_ingresos.precio','detalle_ingresos.porcentaje_iva','detalle_ingresos.porcentaje_iva as porcentaje','detalle_ingresos.id_usuario','articulos.nombre as articulo')
        ->where('idingreso','=',$request->id)
        ->orderBy('id', 'desc')
        ->get();
        
        return ['detalle_ingreso' => $detalle_ingreso];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        $detalle_ingreso = new DetalleIngreso();
        $detalle_ingreso->nombre = $request->nombre;
        $detalle_ingreso->id_empresa = $id_empresa;
        $detalle_ingreso->usu_crea = $id_usuario;
        $detalle_ingreso->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $detalle_ingreso = DetalleIngreso::findOrFail($request->id);
        $detalle_ingreso->nombre = $request->nombre;
        $detalle_ingreso->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $detalle_ingreso = DetalleIngreso::findOrFail($request->id);
        $detalle_ingreso->estado = '0';
        $detalle_ingreso->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $detalle_ingreso = DetalleIngreso::findOrFail($request->id);
        $detalle_ingreso->estado = '1';
        $detalle_ingreso->save();
    }
}
