<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;
use App\Stock;
use App\ProductoTarifario;
use App\ConTarifario;
use App\IvaProducto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticuloController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');
        
        if ($buscar=='' || $buscar==null){
            $articulos = Articulo::leftJoin('modelo_contable','articulos.idcategoria','=','modelo_contable.id')
            ->leftJoin('presentacion','articulos.id_presentacion','=','presentacion.id')
            ->select('articulos.id','articulos.id as id_articulo','articulos.idcategoria','articulos.idcategoria2','articulos.codigo','articulos.nombre','modelo_contable.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','id_und_medida','id_concentracion','articulos.cod_invima','articulos.lote','articulos.fec_vence','articulos.minimo','tipo_articulo','articulos.descripcion','articulos.condicion','articulos.id_presentacion','articulos.talla','articulos.marca','articulos.linea','articulos.img','articulos.id_empresa','presentacion.nombre as nom_presentacion')
            ->where('articulos.id_empresa','=',$id_empresa)
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        else{
            $articulos = Articulo::leftJoin('modelo_contable','articulos.idcategoria','=','modelo_contable.id')
            ->leftJoin('presentacion','articulos.id_presentacion','=','presentacion.id')
            ->select('articulos.id','articulos.id as id_articulo','articulos.idcategoria','articulos.idcategoria2','articulos.codigo','articulos.nombre','modelo_contable.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','id_und_medida','id_concentracion','articulos.cod_invima','articulos.lote','articulos.fec_vence','articulos.minimo','tipo_articulo','articulos.descripcion','articulos.condicion','articulos.id_presentacion','articulos.talla','articulos.marca','articulos.linea','articulos.img','articulos.id_empresa','presentacion.nombre as nom_presentacion')
            ->where('articulos.id_empresa','=',$id_empresa)
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orWhere('articulos.codigo', 'like', '%'. $buscar . '%')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $articulos->total(),
                'current_page' => $articulos->currentPage(),
                'per_page'     => $articulos->perPage(),
                'last_page'    => $articulos->lastPage(),
                'from'         => $articulos->firstItem(),
                'to'           => $articulos->lastItem(),
            ],
            'articulos' => $articulos,
            'buscar' => $buscar,
        ];
    }

    public function listarArticulo(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');

        if(isset($request->categoria) && $request->categoria!='' && $request->categoria!=0)
        {           
           
            $cons_categoria = 'AND articulos.idcategoria2 IN ('.$request->categoria.')';
        }
        else
        {
            $cons_categoria = '';
        }

        if(isset($request->id_tarifario) && $request->id_tarifario!='' && $request->id_tarifario!=0)
        {
            $cons_tarifario = 'AND productos_tarifarios.id_tarifario='.$request->id_tarifario;
        }
        else
        {
            $cons_tarifario = '';
        }

        $cons = "SELECT articulos.id,articulos.id as id_articulo,'' as id_asociado,articulos.idcategoria,articulos.idcategoria2,articulos.codigo,articulos.nombre,modelo_contable.nombre as nom_modelo_contable,modelo_contable.idIvaCompras,modelo_contable.idIvaVentas,modelo_contable.idIvaDevolucionCompras,modelo_contable.idIvaDevolucionVentas,categorias.nombre as nom_categoria,productos_tarifarios.valor as precio_venta,articulos.stock,articulos.descripcion,articulos.cod_invima,articulos.lote,articulos.minimo,articulos.tipo_articulo,articulos.condicion,articulos.id_presentacion,articulos.talla,articulos.marca,articulos.linea,articulos.img,articulos.id_empresa,presentacion.nombre as nom_presentacion,'' as padre FROM `articulos`,`modelo_contable`,`categorias`,`presentacion`,`productos_tarifarios` WHERE articulos.idcategoria=modelo_contable.id AND articulos.condicion = 1 AND articulos.idcategoria2=categorias.id AND articulos.id_presentacion=presentacion.id AND productos_tarifarios.id_producto=articulos.id ".$cons_tarifario." AND productos_tarifarios.asociado=0 AND (articulos.nombre LIKE '%".$buscar."%' OR articulos.codigo LIKE '%".$buscar."%') ".$cons_categoria." AND articulos.id_empresa=".$id_empresa." GROUP BY articulos.id ORDER BY articulos.id DESC";

        $articulos = DB::select($cons);

        $total = [];
        if(!empty($articulos))
        {
            foreach($articulos as $a)
            {
                $consIvas= "SELECT productos_iva.id_iva,productos_iva.tipo_iva,productos_iva.id_producto,iva.porcentaje FROM productos_iva,iva WHERE productos_iva.id_producto=".$a->id." AND productos_iva.id_iva=iva.id";
                $a->productos_iva = DB::select($consIvas);

                $total[] = $a;
                $articulos2 = array();
                $cons2 = "SELECT * FROM productos_asociados WHERE id_producto = ".$a->id_articulo;
                $articulos2 = DB::select($cons2);

                if(!empty($articulos2))
                {
                    foreach($articulos2 as $a2)
                    {
                        $cons3 = "SELECT articulos.id,articulos.id as id_articulo,productos_asociados.id as id_asociado,articulos.idcategoria,articulos.idcategoria2,productos_asociados.codigo,articulos.nombre,modelo_contable.nombre as nom_modelo_contable,modelo_contable.idIvaCompras,modelo_contable.idIvaVentas,modelo_contable.idIvaDevolucionCompras,modelo_contable.idIvaDevolucionVentas,categorias.nombre as nom_categoria,productos_tarifarios.valor as precio_venta,productos_asociados.unidades, articulos.stock,articulos.descripcion,articulos.cod_invima,articulos.lote,articulos.minimo,articulos.tipo_articulo,articulos.condicion,productos_asociados.id_presentacion,articulos.talla,articulos.marca,articulos.linea,articulos.img,articulos.id_empresa,iva.nombre as nombre_iva,iva.porcentaje,iva.porcentaje as iva,presentacion.nombre as nom_presentacion, articulos.id as padre FROM `articulos`,`modelo_contable`,`categorias`,`presentacion`,`iva`,`productos_tarifarios`,`productos_asociados` WHERE articulos.idcategoria=modelo_contable.id AND articulos.condicion = 1 AND articulos.idcategoria2=categorias.id AND productos_asociados.id_presentacion=presentacion.id AND productos_tarifarios.id_producto=articulos.id ".$cons_tarifario." AND productos_asociados.id=$a2->id AND (articulos.nombre LIKE '%".$buscar."%' OR productos_asociados.codigo LIKE '%".$buscar."%') ".$cons_categoria." AND articulos.id=".$a->id_articulo." AND articulos.id_empresa=".$id_empresa." GROUP BY articulos.id ORDER BY articulos.id DESC";

                        $articulos3 = DB::select($cons3);

                        if(!empty($articulos3))
                        {
                            foreach($articulos3 as $a3)
                            {
                                $consIvas2= "SELECT productos_iva.id_iva,productos_iva.tipo_iva,productos_iva.id_producto,iva.porcentaje FROM productos_iva,iva WHERE productos_iva.id_producto=".$a3->id." AND productos_iva.id_iva=iva.id";
                                $a3->productos_iva = DB::select($consIvas2);
                            }

                            $total[] = $articulos3[0];
                        }

                        // $a[] = $articulos3[0];
                    }
                }
            }
        }

        return ['cons'=>$cons,'articulos' => $total];
    }
 
    public function listarArticuloVenta(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        
        if ($buscar==''){
            $articulos = Articulo::join('modelo_contable','articulos.idcategoria','=','modelo_contable.id')
            ->select('articulos.id','articulos.idcategoria','articulos.idcategoria2','articulos.codigo','articulos.nombre','modelo_contable.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion','articulos.id_presentacion','articulos.talla','articulos.marca','articulos.linea','articulos.img','articulos.id_empresa')
            ->where('articulos.id_empresa','=',$id_empresa)
            ->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        else{
            $articulos = Articulo::join('modelo_contable','articulos.idcategoria','=','modelo_contable.id')
            ->select('articulos.id','articulos.idcategoria','articulos.idcategoria2','articulos.codigo','articulos.nombre','modelo_contable.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion','articulos.id_presentacion','articulos.talla','articulos.marca','articulos.linea','articulos.img','articulos.id_empresa')
            ->where('articulos.id_empresa','=',$id_empresa)
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        

        return ['articulos' => $articulos];
    }

    public function buscarArticulo(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $filtro = $request->filtro;

        
        $cons = "SELECT articulos.id,'' as id_asociado,articulos.idcategoria,articulos.idcategoria2,articulos.nombre,articulos.codigo,articulos.precio_venta,articulos.stock,articulos.descripcion,articulos.cod_invima,articulos.lote,articulos.fec_vence,articulos.minimo,articulos.tipo_articulo,articulos.iva,articulos.talla,articulos.marca,articulos.linea,articulos.id_und_medida,articulos.id_concentracion,articulos.id_presentacion,articulos.id_usuario,articulos.id_empresa,presentacion.nombre as nom_presentacion FROM articulos,presentacion WHERE articulos.id_presentacion=presentacion.id AND articulos.codigo='".$filtro."' AND articulos.id_empresa=".$id_empresa;
        $articulos = DB::select($cons);
        if(count($articulos)>0)
        {
            $cons2= "SELECT productos_iva.id_iva,productos_iva.tipo_iva,productos_iva.id_producto,iva.porcentaje FROM productos_iva,iva WHERE productos_iva.id_producto=".$articulos[0]->id." AND productos_iva.id_iva=iva.id";
            $articulos[0]->productos_iva = DB::select($cons2);
            $cons3 = "SELECT *,id as id_asociado FROM productos_asociados WHERE id_producto=".$articulos[0]->id;
            $articulos[0]->productos_asociados = DB::select($cons3);
        
        }
        else
        {
            $articulos['productos_iva'] = [];
            $articulos['productos_asociados'] = [];
        }

        return [$cons, 'articulos' => $articulos];
    }
    
    public function buscarArticuloVenta(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id_empresa = $request->session()->get('id_empresa');

        $filtro = $request->filtro;
        $articulos = Articulo::where('codigo','=', $filtro)
        ->select('id','nombre','stock','precio_venta')
        ->where('id_empresa','=',$id_empresa)
        ->where('stock','>','0')
        ->orderBy('nombre', 'asc')
        ->take(1)->get();

        return ['articulos' => $articulos];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        try{
            $carpetaEmpresa = $id_empresa .'_empresa'; 
            $dirEmpresa = public_path("Empresas/$carpetaEmpresa/ImgProductos");
            if (!file_exists($dirEmpresa)) mkdir($dirEmpresa, 0777);
            
            $arrayExtensiones = array('image/jpg','image/jpeg','image/png','jpg','jpeg','png');
            if($request->hasFile('img'))
            {
                if($request->file('img')->isValid())
                {
                    $nombreImg = $request->img->getClientOriginalName();
                    if(in_array($request->img->extension(), $arrayExtensiones))
                    {
                        $request->img->move($dirEmpresa,$request->img->getClientOriginalName());
                    }
                    else { return false; }
                }
            }
            else
            {
                $dirEmpresa = public_path("img_productos");
                $nombreImg = 'default.png';
            }

            $archivo = [
                'idcategoria' => $request->idcategoria,
                'idcategoria2' => $request->idcategoria2,
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'precio_venta' => $request->precio_venta,
                'stock' => $request->stock,
                'descripcion' => $request->descripcion,
                'cod_invima' => $request->cod_invima,
                'lote' => $request->lote,
                'fec_vence' => $request->fec_vence,
                'minimo' => $request->minimo,
                'tipo_articulo' => $request->tipo_articulo,
                'iva' => $request->iva,
                'talla' => $request->talla,
                'marca' => $request->marca,
                'linea' => $request->linea,
                'id_und_medida' => $request->id_und_medida,
                'id_concentracion' => $request->id_concentracion,
                'id_presentacion' => $request->id_presentacion,
                'id_usuario' => $id_usuario,
                'id_empresa' => $id_empresa,
                'condicion' => '1',
                'img' => $nombreImg,
            ];
           
            $tarifarios = ConTarifario::select('con_tarifarios.id','con_tarifarios.nombre','con_tarifarios.favorito')
            ->where('con_tarifarios.id_empresa','=',$id_empresa)
            ->where('con_tarifarios.estado','=','1')
            ->orderBy('favorito', 'desc')
            ->get();

            $articulo = Articulo::create($archivo);

            //$tarifarios = $request->arrayTarifarios;
            //$tarifarios = json_decode($tarifarios);
           
            
            
            for($i=0; $i<count($tarifarios); $i++)
            {
                $nuevoTarifario = new ProductoTarifario();
                $nuevoTarifario->id_tarifario = $tarifarios[$i]->id;
                $nuevoTarifario->id_producto = $articulo->id;
                //if(isset($tarifarios[$i]->valor)){
                    $nuevoTarifario->valor = $request->precio_venta;
                //} else { $nuevoTarifario->valor = 0;}
                $nuevoTarifario->asociado = 0;

                $nuevoTarifario->save();
            }

            $stock = new Stock();
            $stock->id_producto = $articulo->id;
            $stock->id_facturacion = null;
            $stock->id_usuario = $id_usuario;
            if($articulo->stock!=null){$cantidadStock=$articulo->stock;}else{$cantidadStock=0;}
            $stock->cantidad = $cantidadStock;
            $stock->tipo_movimiento = $request->tipo_movimiento;
            $stock->sumatoria = $cantidadStock;
            $stock->id_empresa = $id_empresa;
            
            $stock->save();

            $consIvasModeloContable = "SELECT * FROM modelo_contable WHERE id=".$request->idcategoria;
            $ivasModeloContable = DB::select($consIvasModeloContable);

            $iva_producto = new IvaProducto();
            $iva_producto->id_iva = $ivasModeloContable[0]->idIvaCompras;
            $iva_producto->tipo_iva = 'Compra';
            $iva_producto->id_producto = $articulo->id;
            $iva_producto->usu_crea = $id_usuario;
            $iva_producto->save();

            $iva_producto = new IvaProducto();
            $iva_producto->id_iva = $ivasModeloContable[0]->idIvaVentas;
            $iva_producto->tipo_iva = 'Venta';
            $iva_producto->id_producto = $articulo->id;
            $iva_producto->usu_crea = $id_usuario;
            $iva_producto->save();

            $iva_producto = new IvaProducto();
            $iva_producto->id_iva = $ivasModeloContable[0]->idIvaDevolucionCompras;
            $iva_producto->tipo_iva = 'Devoluciones compra';
            $iva_producto->id_producto = $articulo->id;
            $iva_producto->usu_crea = $id_usuario;
            $iva_producto->save();

            $iva_producto = new IvaProducto();
            $iva_producto->id_iva = $ivasModeloContable[0]->idIvaDevolucionVentas;
            $iva_producto->tipo_iva = 'Devoluciones Venta';
            $iva_producto->id_producto = $articulo->id;
            $iva_producto->usu_crea = $id_usuario;
            $iva_producto->save();
        } catch (Exception $e){
            report($e);
            return false;
        }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        try{
            $articulo = Articulo::findOrFail($request->id);

            $carpetaEmpresa = $id_empresa .'_empresa'; 
            $dirEmpresa = public_path("Empresas/$carpetaEmpresa/ImgProductos");
            if (!file_exists($dirEmpresa)) mkdir($dirEmpresa, 0777);

            /*if(isset($request->img) && $request->img != null){
                if(is_uploaded_file($_FILES['img']['tmp_name']))
                {
                    $nombreImg = $_FILES['img']['name'];
                    if($_FILES['img']['type'] == "image/jpg" || $_FILES['img']['type'] == "image/jpeg" || $_FILES['img']['type'] == "image/png")
                    {
                        // copy($_FILES['img']['tmp_name'],$dirEmpresa.'/'.$_FILES['img']['name']);
                    }
                }else{ $nombreImg = $articulo->img; }
            }
            else
            {
                $nombreImg = $articulo->img;
            }*/

            $arrayExtensiones = array('image/jpg','image/jpeg','image/png','jpg','jpeg','png');
            if($request->hasFile('img'))
            {
                if($request->file('img')->isValid())
                {
                    $nombreImg = $request->img->getClientOriginalName();
                    if(in_array($request->img->extension(), $arrayExtensiones))
                    {
                        $request->img->move($dirEmpresa,$request->img->getClientOriginalName());
                    }
                    else { return false; }
                }
            }
            else
            {
                $nombreImg = $articulo->img;
            }

            $archivo = [
                'idcategoria' => $request->idcategoria,
                'idcategoria2' => $request->idcategoria2,
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'precio_venta' => $request->precio_venta,
                'stock' => $request->stock,
                'descripcion' => $request->descripcion,
                'cod_invima' => $request->cod_invima,
                'lote' => $request->lote,
                'fec_vence' => $request->fec_vence,
                'minimo' => $request->minimo,
                'tipo_articulo' => $request->tipo_articulo,
                'talla' => $request->talla,
                'marca' => $request->marca,
                'linea' => $request->linea,
                'id_und_medida' => $request->id_und_medida,
                'id_concentracion' => $request->id_concentracion,
                'id_presentacion' => $request->id_presentacion,
                'img' => $nombreImg,
                'condicion' => '1',
            ];

            $articulo->update($archivo);

            $borrarTarifarios = ProductoTarifario::where('id_producto','=',$request->id)->where('asociado','=',0)->delete();

            $tarifarios = $request->arrayTarifarios;
            $tarifarios = json_decode($tarifarios);

            for($i=0; $i<count($tarifarios); $i++)
            {
                $nuevoTarifario = new ProductoTarifario();
                $nuevoTarifario->id_tarifario = $tarifarios[$i]->id;
                $nuevoTarifario->id_producto = $articulo->id;
                if(isset($tarifarios[$i]->valor))
                {
                    $nuevoTarifario->valor = $tarifarios[$i]->valor;
                } else { $nuevoTarifario->valor = 0;}
                $nuevoTarifario->asociado = 0;
                $nuevoTarifario->idPresentacionAsociada=null;

                $nuevoTarifario->save();
            }

            $borrarIvas = IvaProducto::where('id_producto','=',$request->id)->delete();

            $consIvasModeloContable = "SELECT * FROM modelo_contable WHERE id=".$request->idcategoria;
            $ivasModeloContable = DB::select($consIvasModeloContable);

            $iva_compras = new IvaProducto();
            $iva_compras->id_iva = $ivasModeloContable[0]->idIvaCompras;
            $iva_compras->tipo_iva = 'Compra';
            $iva_compras->id_producto = $articulo->id;
            $iva_compras->usu_crea = $id_usuario;
            $iva_compras->save();

            $iva_ventas = new IvaProducto();
            $iva_ventas->id_iva = $ivasModeloContable[0]->idIvaVentas;
            $iva_ventas->tipo_iva = 'Venta';
            $iva_ventas->id_producto = $articulo->id;
            $iva_ventas->usu_crea = $id_usuario;
            $iva_ventas->save();

            $iva_dev_compras = new IvaProducto();
            $iva_dev_compras->id_iva = $ivasModeloContable[0]->idIvaDevolucionCompras;
            $iva_dev_compras->tipo_iva = 'Devoluciones compra';
            $iva_dev_compras->id_producto = $articulo->id;
            $iva_dev_compras->usu_crea = $id_usuario;
            $iva_dev_compras->save();

            $iva_dev_ventas = new IvaProducto();
            $iva_dev_ventas->id_iva = $ivasModeloContable[0]->idIvaDevolucionVentas;
            $iva_dev_ventas->tipo_iva = 'Devoluciones Venta';
            $iva_dev_ventas->id_producto = $articulo->id;
            $iva_dev_ventas->usu_crea = $id_usuario;
            $iva_dev_ventas->save();
        } catch (Exception $e){
            report($e);
            return false;
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '0';
        $articulo->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '1';
        $articulo->save();
    }

}
