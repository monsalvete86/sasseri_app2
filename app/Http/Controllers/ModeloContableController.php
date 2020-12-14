<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\ModeloContable;

class ModeloContableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        
        $modelo_contable = ModeloContable::leftJoin('plan_cuentas as pc1','modelo_contable.idCuentaProductos','pc1.id')
        ->leftJoin('plan_cuentas as pc2','modelo_contable.idCuentaSalidaProductos','pc2.id')
        ->leftJoin('plan_cuentas as pc3','modelo_contable.idCuentaSaldosIniciales','pc3.id')
        ->leftJoin('plan_cuentas as pc4','modelo_contable.idCuentaDonaciones','pc4.id')
        ->leftJoin('plan_cuentas as pc5','modelo_contable.idCuentaDevolucionesVentas','pc5.id')
        ->leftJoin('plan_cuentas as pc6','modelo_contable.idCuentaDevolucionesCompras','pc6.id')
        ->leftJoin('plan_cuentas as pc7','modelo_contable.idCuentaImpuestoConsumoVentas','pc7.id')
        ->leftJoin('iva as ivaCompras','modelo_contable.idIvaCompras','ivaCompras.id')
        ->leftJoin('iva as ivaVentas','modelo_contable.idIvaVentas','ivaVentas.id')
        ->leftJoin('iva as ivaDevolucionCompras','modelo_contable.idIvaDevolucionCompras','ivaDevolucionCompras.id')
        ->leftJoin('iva as ivaDevolucionVentas','modelo_contable.idIvaDevolucionVentas','ivaDevolucionVentas.id')
        ->select('modelo_contable.id','modelo_contable.id as id_modelo_contable','modelo_contable.nombre','modelo_contable.descripcion','modelo_contable.idCuentaProductos','pc1.nombre as cuentaProductos','pc1.codigo as codCuentaProductos','modelo_contable.idCuentaSalidaProductos','pc2.nombre as cuentaSalidaProductos','pc2.codigo as codCuentaSalidaProductos','modelo_contable.idCuentaSaldosIniciales','pc3.nombre as cuentaSaldosIniciales','pc3.codigo as codCuentaSaldosIniciales','modelo_contable.idCuentaDonaciones','pc4.nombre as cuentaDonaciones','pc4.codigo as codCuentaDonaciones','pc5.nombre as cuentaDevolucionesVentas','pc5.codigo as codCuentaDevolucionesVentas','modelo_contable.idCuentaDevolucionesVentas','pc6.nombre as cuentaDevolucionesCompras','pc6.codigo as codCuentaDevolucionesCompras','modelo_contable.idCuentaDevolucionesCompras','pc7.nombre as cuentaImpuestoConsumoVentas','pc7.codigo as codCuentaImpuestoConsumoVentas','modelo_contable.idCuentaImpuestoConsumoVentas','modelo_contable.condicion','modelo_contable.idIvaCompras','modelo_contable.idIvaVentas','modelo_contable.idIvaDevolucionCompras','modelo_contable.idIvaDevolucionVentas','ivaCompras.nombre as nomIvaCompras','ivaVentas.nombre as nomIvaVentas','ivaDevolucionCompras.nombre as nomDevolucionCompras','ivaDevolucionVentas.nombre as nomDevolucionVentas');
        if($buscar!='')
        {
            $modelo_contable = $modelo_contable->where('modelo_contable.nombre', 'like', '%'. $buscar . '%')
            ->orWhere('modelo_contable.descripcion', 'like', '%'. $buscar . '%');
        }
        $modelo_contable = $modelo_contable->where('modelo_contable.id_empresa','=',$id_empresa)
        ->orderBy('modelo_contable.id', 'desc')
        ->paginate(3);
        

        return [
            'pagination' => [
                'total'        => $modelo_contable->total(),
                'current_page' => $modelo_contable->currentPage(),
                'per_page'     => $modelo_contable->perPage(),
                'last_page'    => $modelo_contable->lastPage(),
                'from'         => $modelo_contable->firstItem(),
                'to'           => $modelo_contable->lastItem(),
            ],
            'modelo_contable' => $modelo_contable
        ];
    }

    public function selectModeloContable(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        
        $modelo_contable = ModeloContable::where('condicion','=','1')
        ->select('id','nombre')
        ->where('id_empresa','=',$id_empresa)
        ->orderBy('nombre', 'asc')
        ->get();
        
        return ['modelo_contable' => $modelo_contable];
    }
    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');
        $modelo_contable = new ModeloContable();
        $modelo_contable->nombre = $request->nombre;
        $modelo_contable->descripcion = $request->descripcion;
        $modelo_contable->idIvaCompras = $request->idIvaCompras;
        $modelo_contable->idIvaVentas = $request->idIvaVentas;
        $modelo_contable->idIvaDevolucionCompras = $request->idIvaDevolucionCompras;
        $modelo_contable->idIvaDevolucionVentas = $request->idIvaDevolucionVentas;
        $modelo_contable->idCuentaProductos = $request->idCuentaProductos;
        $modelo_contable->idCuentaSalidaProductos = $request->idCuentaSalidaProductos;
        $modelo_contable->idCuentaSaldosIniciales = $request->idCuentaSaldosIniciales;
        $modelo_contable->idCuentaDonaciones = $request->idCuentaDonaciones;
        $modelo_contable->idCuentaDevolucionesVentas = $request->idCuentaDevolucionesVentas;
        $modelo_contable->idCuentaDevolucionesCompras = $request->idCuentaDevolucionesCompras;
        $modelo_contable->idCuentaImpuestoConsumoVentas = $request->idCuentaImpuestoConsumoVentas;
        $modelo_contable->condicion = '1';
        $modelo_contable->id_empresa = $id_empresa;
        $modelo_contable->save();
    }
  
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $modelo_contable = ModeloContable::findOrFail($request->id);
        $modelo_contable->nombre = $request->nombre;
        $modelo_contable->descripcion = $request->descripcion;
        $modelo_contable->idIvaCompras = $request->idIvaCompras;
        $modelo_contable->idIvaVentas = $request->idIvaVentas;
        $modelo_contable->idIvaDevolucionCompras = $request->idIvaDevolucionCompras;
        $modelo_contable->idIvaDevolucionVentas = $request->idIvaDevolucionVentas;
        $modelo_contable->idCuentaProductos = $request->idCuentaProductos;
        $modelo_contable->idCuentaSalidaProductos = $request->idCuentaSalidaProductos;
        $modelo_contable->idCuentaSaldosIniciales = $request->idCuentaSaldosIniciales;
        $modelo_contable->idCuentaDonaciones = $request->idCuentaDonaciones;
        $modelo_contable->idCuentaDevolucionesVentas = $request->idCuentaDevolucionesVentas;
        $modelo_contable->idCuentaDevolucionesCompras = $request->idCuentaDevolucionesCompras;
        $modelo_contable->idCuentaImpuestoConsumoVentas = $request->idCuentaImpuestoConsumoVentas;
        $modelo_contable->condicion = '1';
        $modelo_contable->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $modelo_contable = ModeloContable::findOrFail($request->id);
        $modelo_contable->condicion = '0';
        $modelo_contable->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $modelo_contable = ModeloContable::findOrFail($request->id);
        $modelo_contable->condicion = '1';
        $modelo_contable->save();
    }

    
}
