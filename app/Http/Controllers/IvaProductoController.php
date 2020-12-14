<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\IvaProducto;
use Illuminate\Support\Facades\Auth;

class IvaProductoController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $iva_producto = IvaProducto::leftJoin('iva','productos_iva.id_iva','=','iva.id')
            ->select('productos_iva.id','productos_iva.id_iva','productos_iva.id_producto','productos_iva.tipo_iva as tipo','iva.nombre as nom_iva','iva.tipo as tipo_iva','iva.porcentaje as porcentaje_iva')
            ->orderBy('productos_iva.id', 'desc')->paginate(3);
        }
        else{
            $iva_producto = IvaProducto::leftJoin('iva','productos_iva.id_iva','=','iva.id')
            ->select('productos_iva.id','productos_iva.id_iva','productos_iva.id_producto','productos_iva.tipo_iva as tipo','iva.nombre as nom_iva','iva.tipo as tipo_iva','iva.porcentaje as porcentaje_iva')
            ->where('productos_iva.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos_iva.id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $iva_producto->total(),
                'current_page' => $iva_producto->currentPage(),
                'per_page'     => $iva_producto->perPage(),
                'last_page'    => $iva_producto->lastPage(),
                'from'         => $iva_producto->firstItem(),
                'to'           => $iva_producto->lastItem(),
            ],
            'iva_producto' => $iva_producto,
        ];
    }

    public function selectIvaProducto(Request $request){
        // if (!$request->ajax()) return redirect('/');
        $id_producto = $request->id_producto;

        $iva_producto = IvaProducto::leftJoin('iva','productos_iva.id_iva','=','iva.id')
        ->select('productos_iva.id','productos_iva.id_iva','productos_iva.id_producto','productos_iva.tipo_iva as tipo','iva.nombre as nom_iva','iva.tipo as tipo_iva','iva.porcentaje as porcentaje_iva')
        ->where('id_producto','=',$id_producto)
        ->orderBy('productos_iva.id', 'asc')
        ->get();
        
        return [
            'iva_producto' => $iva_producto,
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        $borrarAnteriores = IvaProducto::where('id_producto','=',$request->id_producto)->delete();

        $iva_producto = new IvaProducto();
        $iva_producto->id_iva = $request->idIvaCompra;
        $iva_producto->tipo_iva = 'Compra';
        $iva_producto->id_producto = $request->id_producto;
        $iva_producto->usu_crea = $id_usuario;
        $iva_producto->save();

        $iva_producto = new IvaProducto();
        $iva_producto->id_iva = $request->idIvaVenta;
        $iva_producto->tipo_iva = 'Venta';
        $iva_producto->id_producto = $request->id_producto;
        $iva_producto->usu_crea = $id_usuario;
        $iva_producto->save();

        $iva_producto = new IvaProducto();
        $iva_producto->id_iva = $request->idIvaDevolucionCompra;
        $iva_producto->tipo_iva = 'Devoluciones compra';
        $iva_producto->id_producto = $request->id_producto;
        $iva_producto->usu_crea = $id_usuario;
        $iva_producto->save();

        $iva_producto = new IvaProducto();
        $iva_producto->id_iva = $request->idIvaDevolucionVenta;
        $iva_producto->tipo_iva = 'Devoluciones Venta';
        $iva_producto->id_producto = $request->id_producto;
        $iva_producto->usu_crea = $id_usuario;
        $iva_producto->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $iva_producto = IvaProducto::findOrFail($request->id);
        $iva_producto->id_iva = $request->id_iva;
        $iva_producto->id_producto = $request->id_producto;
        $iva_producto->save();
    }

    /*public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $iva_producto = IvaProducto::findOrFail($request->id);
        $iva_producto->estado = '0';
        $iva_producto->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $iva_producto = IvaProducto::findOrFail($request->id);
        $iva_producto->estado = '1';
        $iva_producto->save();
    }*/

    public function eliminarIvaProducto(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $iva_producto = IvaProducto::findOrFail($request->id)->delete();
    }
}
