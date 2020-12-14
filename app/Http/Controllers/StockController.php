<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Stock;

class StockController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $id_articulo = $request->id_articulo;
        $fecIni = $request->fecIni.' 00:00:00';
        $fecFin = $request->fecFin.' 23:59:59';
        $id_empresa = $request->session()->get('id_empresa');

        $stock = Stock::join('articulos','stock.id_producto','=','articulos.id')
        ->join('users','stock.id_usuario','=','users.id')
        ->select('stock.id','stock.id_producto','stock.id_usuario','articulos.nombre as nombre_producto', 'articulos.codigo as codigo_producto','users.usuario as nombre_usuario','stock.fec_crea','stock.cantidad','stock.tipo_movimiento','stock.sumatoria','stock.condicion');
        if($request->id_articulo!='' && $request->id_articulo!=0)
        {
            $stock = $stock->where('id_producto','like', $id_articulo);
        }
        if($request->fecIni!='' && $request->fecFin!=''){
            $stock = $stock->whereBetween('stock.fec_crea', [$fecIni, $fecFin]);
        };
        if($request->buscar!=''){
            $stock = $stock->where('articulos.'.$request->criterio, 'like', '%'. $request->buscar . '%')
            ->orWhere('articulos.codigo', 'like', '%'. $request->buscar . '%');
        };
        $stock = $stock->where('stock.id_empresa','=',$id_empresa)->orderBy('stock.fec_crea', 'desc')->paginate(12);

        // return [
        //     'pagination_stock' => [
        //         'total_stock'        => $stock->total(),
        //         'current_page_stock' => $stock->currentPage(),
        //         'per_page_stock'     => $stock->perPage(),
        //         'last_page_stock'    => $stock->lastPage(),
        //         'from_stock'         => $stock->firstItem(),
        //         'to_stock'           => $stock->lastItem(),
        //     ],
        //     'stock' => $stock
        // ];

        return [
            'pagination' => [
                'total'        => $stock->total(),
                'current_page' => $stock->currentPage(),
                'per_page'     => $stock->perPage(),
                'last_page'    => $stock->lastPage(),
                'from'         => $stock->firstItem(),
                'to'           => $stock->lastItem(),
            ],
            'stock' => $stock
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        $stock = new Stock();
        $stock->id_producto = $request->id_producto;
        $stock->id_usuario = $id_usuario;
        $stock->cantidad = $request->cantidad;
        $stock->tipo_movimiento = $request->tipo_movimiento;
        $stock->sumatoria = $request->sumatoria;
        $stock->id_empresa = $id_empresa;
        
        $stock->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->idcategoria = $request->idcategoria;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->stock = $request->stock;
        $articulo->descripcion = $request->descripcion;
        $articulo->cod_invima = $request->cod_invima;
        $articulo->lote = $request->lote;
        $articulo->fec_vence = $request->fec_vence;
        $articulo->minimo = $request->minimo;
        $articulo->tipo_articulo = $request->tipo_articulo;
        $articulo->iva = $request->iva;
        $articulo->id_und_medida = $request->id_und_medida;
        $articulo->id_concentracion = $request->id_concentracion;
        $articulo->id_presentacion = $request->id_presentacion;
        $articulo->condicion = '1';
        $articulo->save();
    }

}
