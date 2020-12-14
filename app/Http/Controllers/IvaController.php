<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Iva;
use Illuminate\Support\Facades\Auth;

class IvaController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        
        if ($buscar==''){
            $iva = Iva::where('id_empresa','=',$id_empresa)->orderBy('id', 'desc')->paginate(6);
        }
        else{
            $iva = Iva::where('id_empresa','=',$id_empresa)->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(6);
        }

        
        $ivaCompra = Iva::select('id','nombre','porcentaje','estado')->where('tipo','=','compras')->where('id_empresa','=',$id_empresa)->where('estado','=','1')->orderBy('nombre', 'asc')->get();

        $ivaVenta = Iva::select('id','nombre','porcentaje','estado')->where('tipo','=','ventas')->where('id_empresa','=',$id_empresa)->where('estado','=','1')->orderBy('nombre', 'asc')->get();

        $ivaDevolucionCompra = Iva::select('id','nombre','porcentaje','estado')->where('tipo','=','devoluciones_compras')->where('id_empresa','=',$id_empresa)->where('estado','=','1')->orderBy('nombre', 'asc')->get();

        $ivaDevolucionVenta = Iva::select('id','nombre','porcentaje','estado')->where('tipo','=','devoluciones_ventas')->where('id_empresa','=',$id_empresa)->where('estado','=','1')->orderBy('nombre', 'asc')->get();
        

        return [
            'pagination' => [
                'total'        => $iva->total(),
                'current_page' => $iva->currentPage(),
                'per_page'     => $iva->perPage(),
                'last_page'    => $iva->lastPage(),
                'from'         => $iva->firstItem(),
                'to'           => $iva->lastItem(),
            ],
            'iva' => $iva,
            
            'ivaCompra' => $ivaCompra,
            'ivaVenta' => $ivaVenta,
            'ivaDevolucionCompra' => $ivaDevolucionCompra,
            'ivaDevolucionVenta' => $ivaDevolucionVenta,
        ];
    }

    public function selectIva(Request $request){
        // if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $iva = Iva::select('id','nombre')->where('id_empresa','=',$id_empresa)->orderBy('nombre', 'asc')->get();
        
        return [
            'iva' => $iva,
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        $iva = new Iva();
        $iva->nombre = $request->nombre;
        $iva->tipo = $request->tipo;
        $iva->porcentaje = $request->porcentaje;
        $iva->id_empresa = $id_empresa;
        $iva->usu_crea = $id_usuario;
        $iva->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $iva = Iva::findOrFail($request->id);
        $iva->nombre = $request->nombre;
        $iva->tipo = $request->tipo;
        $iva->porcentaje = $request->porcentaje;
        $iva->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $iva = Iva::findOrFail($request->id);
        $iva->estado = '0';
        $iva->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $iva = Iva::findOrFail($request->id);
        $iva->estado = '1';
        $iva->save();
    }
}
