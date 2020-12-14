<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DetalleEgreso;
use Illuminate\Support\Facades\Auth;

class DetalleEgresoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        
        if ($buscar==''){
            $detalle_egreso = DetalleEgreso::where('id_empresa','=',$id_empresa)->orderBy('id', 'desc')->paginate(3);
        }
        else{
            $detalle_egreso = DetalleEgreso::where('id_empresa','=',$id_empresa)->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $detalle_egreso->total(),
                'current_page' => $detalle_egreso->currentPage(),
                'per_page'     => $detalle_egreso->perPage(),
                'last_page'    => $detalle_egreso->lastPage(),
                'from'         => $detalle_egreso->firstItem(),
                'to'           => $detalle_egreso->lastItem(),
            ],
            'detalle_egreso' => $detalle_egreso
        ];
    }

    public function selectDetalleegreso(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $detalle_egreso = DetalleEgreso::leftJoin('articulos','detalle_egresos.idarticulo','=','articulos.id')
        ->select('detalle_egresos.id','detalle_egresos.idegreso','detalle_egresos.idarticulo','detalle_egresos.cantidad','detalle_egresos.precio','detalle_egresos.porcentaje_iva','detalle_egresos.porcentaje_iva as porcentaje','detalle_egresos.id_usuario','articulos.nombre as articulo')
        ->where('idegreso','=',$request->id)
        ->orderBy('id', 'desc')
        ->get();
        
        return ['detalle_egreso' => $detalle_egreso];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        $detalle_egreso = new DetalleEgreso();
        $detalle_egreso->nombre = $request->nombre;
        $detalle_egreso->id_empresa = $id_empresa;
        $detalle_egreso->usu_crea = $id_usuario;
        $detalle_egreso->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $detalle_egreso = DetalleEgreso::findOrFail($request->id);
        $detalle_egreso->nombre = $request->nombre;
        $detalle_egreso->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $detalle_egreso = DetalleEgreso::findOrFail($request->id);
        $detalle_egreso->estado = '0';
        $detalle_egreso->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $detalle_egreso = DetalleEgreso::findOrFail($request->id);
        $detalle_egreso->estado = '1';
        $detalle_egreso->save();
    }
}
