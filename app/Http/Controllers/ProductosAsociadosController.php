<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ProductosAsociados;
use App\ProductoTarifario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductosAsociadosController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        
        if ($buscar==''){
            $productos_asociados = ProductosAsociados::leftJoin('presentacion','productos_asociados.id_presentacion','=','presentacion.id')
            ->leftJoin('articulos','productos_asociados.id_producto','articulos.id')
            ->select('productos_asociados.id','productos_asociados.id_presentacion','productos_asociados.codigo','productos_asociados.unidades','productos_asociados.id_producto','productos_asociados.estado','presentacion.nombre as nom_presentacion','articulos.codigo as codigo_articulo','articulos.nombre as nom_articulo')
            ->where('productos_asociados.id_empresa','=',$id_empresa)
            ->orderBy('id', 'desc')
            ->paginate(3);
        }
        else{
            $productos_asociados = ProductosAsociados::leftJoin('presentacion','productos_asociados.id_presentacion','=','presentacion.id')
            ->leftJoin('articulos','productos_asociados.id_producto','articulos.id')
            ->select('productos_asociados.id','productos_asociados.id_presentacion','productos_asociados.codigo','productos_asociados.unidades','productos_asociados.id_producto','productos_asociados.estado','presentacion.nombre as nom_presentacion','articulos.codigo as codigo_articulo','articulos.nombre as nom_articulo')
            ->where('productos_asociados.id_empresa','=',$id_empresa)->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $productos_asociados->total(),
                'current_page' => $productos_asociados->currentPage(),
                'per_page'     => $productos_asociados->perPage(),
                'last_page'    => $productos_asociados->lastPage(),
                'from'         => $productos_asociados->firstItem(),
                'to'           => $productos_asociados->lastItem(),
            ],
            'productos_asociados' => $productos_asociados
        ];
    }

    public function selectProductoAsociado(Request $request){
        // if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_producto = $request->id_producto;

        $productos_asociados = ProductosAsociados::leftJoin('presentacion','productos_asociados.id_presentacion','=','presentacion.id')
        ->leftJoin('articulos','productos_asociados.id_producto','articulos.id')
        ->leftJoin('productos_tarifarios','productos_asociados.id','=','productos_tarifarios.idPresentacionAsociada')
        ->leftJoin('con_tarifarios','productos_tarifarios.id_tarifario','con_tarifarios.id')
        ->select('productos_asociados.id','productos_asociados.id_presentacion','productos_asociados.codigo','productos_asociados.unidades','productos_asociados.id_producto','productos_asociados.estado','presentacion.nombre as nom_presentacion','articulos.codigo as codigo_articulo','articulos.nombre as nom_articulo','productos_tarifarios.id_tarifario','productos_tarifarios.idPresentacionAsociada','con_tarifarios.nombre as nom_tarifario','productos_tarifarios.valor')
        ->where('productos_asociados.id_producto','=',$id_producto)
        ->where('productos_asociados.id_empresa','=',$id_empresa)
        ->orderBy('id', 'desc')
        ->get();
        
        return ['productos_asociados' => $productos_asociados,'id_producto'=>$id_producto];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $id_usuario = Auth::user()->id;

        $productos_asociados = new ProductosAsociados();
        $productos_asociados->codigo = $request->codigo;
        $productos_asociados->id_presentacion = $request->id_presentacion;
        $productos_asociados->id_producto = $request->id_producto;
        $productos_asociados->unidades = $request->unidades;
        $productos_asociados->id_empresa = $id_empresa;
        $productos_asociados->usu_crea = $id_usuario;
        $productos_asociados->save();

        $Tarifarios = $request->arrayTarifarios;
        foreach($Tarifarios as $Tari)
        {

            $productosTarifario = new ProductoTarifario();
            $productosTarifario->id_tarifario = $Tari['id'];
            $productosTarifario->id_producto = $productos_asociados->id_producto;
            
            if($Tari['valor']!=null){
                $productosTarifario->valor = $Tari['valor'];
            }else{
                $productosTarifario->valor = 0;
            }
            $productosTarifario->asociado = 1;
            $productosTarifario->idPresentacionAsociada = $productos_asociados->id;
            $productosTarifario->save();
        }

        $sql = "SELECT stock FROM articulos WHERE id=".$request->id_producto;
        $articulos = DB::select($sql);

        foreach($articulos as $a){
            $sum = (int)$a->stock+$request->unidades;
            $sql2 = "UPDATE articulos SET stock=".$sum." WHERE id=".$request->id_producto;
            $articulos2=DB::update($sql2);
        }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $productos_asociados = ProductosAsociados::findOrFail($request->id);
        $productos_asociados->nombre = $request->nombre;
        $productos_asociados->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $productos_asociados = ProductosAsociados::findOrFail($request->id);
        $productos_asociados->estado = '0';
        $productos_asociados->save();

        $sql = "SELECT stock FROM articulos WHERE id=".$productos_asociados->id_producto;
        $articulos = DB::select($sql);

        foreach($articulos as $a){
            $sum = (int)$a->stock-$productos_asociados->unidades;
            $sql2 = "UPDATE articulos SET stock=".$sum." WHERE id=".$productos_asociados->id_producto;
            $articulos2=DB::update($sql2);
        }
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $productos_asociados = ProductosAsociados::findOrFail($request->id);
        $productos_asociados->estado = '1';
        $productos_asociados->save();
    }
}
