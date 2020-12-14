<template>
            <main class="main">
            <!-- Breadcrumb -->
            
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Ingresos
                        <button v-if="permisosUser.crear" type="button" @click="mostrarDetalle()" class="btn btn-primary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                        <button v-else type="button" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <!-- Listado-->
                    <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select v-if="permisosUser.leer" class="form-control col-md-3" v-model="criterio">
                                      <option value="tipo_comprobante">Tipo Comprobante</option>
                                      <option value="num_comprobante">Número Comprobante</option>
                                      <option value="fecha_hora">Fecha-Hora</option>
                                    </select>
                                    <select v-else disabled class="form-control col-md-3" v-model="criterio">
                                      <option value="tipo_comprobante">Tipo Comprobante</option>
                                      <option value="num_comprobante">Número Comprobante</option>
                                      <option value="fecha_hora">Fecha-Hora</option>
                                    </select>

                                    <input v-if="permisosUser.leer" type="text" v-model="buscar" @keyup.enter="listarIngreso(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <input v-else disabled type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar">

                                    <button v-if="permisosUser.leer" type="submit" @click="listarIngreso(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    <button v-else type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm  table-responsive">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Proveedor</th>
                                        <!--
                                        <th>Tipo Comprobante</th>
                                        <th>Serie Comprobante</th>
                                        <th>Número Comprobante</th>
                                        -->
                                        <th>Fecha Hora</th>
                                        <th>Total</th>
                                        <!-- <th>Impuesto</th> -->
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody v-if="permisosUser.leer">
                                    <tr v-for="ingreso in arrayIngreso" :key="ingreso.id">
                                        <td v-text="ingreso.usuario"></td>
                                        <td v-text="ingreso.nombre"></td>
                                        <!--
                                        <td v-text="ingreso.tipo_comprobante"></td>
                                        <td v-text="ingreso.serie_comprobante"></td>
                                        <td v-text="ingreso.num_comprobante"></td>
                                        -->
                                        <td v-text="ingreso.fecha_hora"></td>
                                        <td v-text="ingreso.total"></td>
                                        <!-- <td v-text="ingreso.impuesto"></td> -->
                                        <td v-text="ingreso.estado"></td>
                                        <td>
                                            <button v-if="permisosUser.leer" type="button" @click="verIngreso(ingreso.id)" class="btn btn-success btn-sm">
                                            <i class="icon-eye"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-secondary btn-sm">
                                            <i class="icon-eye"></i>
                                            </button> &nbsp;

                                            <template>
                                                <button v-if="permisosUser.anular && ingreso.estado=='Registrado'" type="button" class="btn btn-danger btn-sm" @click="desactivarIngreso(ingreso.id)">
                                                    <i class="icon-trash"></i>
                                                </button>
                                                <button v-else type="button" class="btn btn-secondary btn-sm">
                                                    <i class="icon-trash"></i>
                                                </button>
                                            </template> &nbsp;

                                            <button type="button" @click="abrirModal3('ver',ingreso)" class="btn btn-info btn-sm">
                                                <i class="fa fa-align-justify"></i>
                                            </button> &nbsp;
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr><td colspan="6">No hay registros para mostrar</td></tr>
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    </template>
                    <!--Fin Listado-->
                    <!-- Detalle-->
                    <template v-else-if="listado==0">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="form-group col-md-3" v-if="tipo_ingreso!='Saldos iniciales'">
                                <label for="">Proveedor(*)</label>
                                <div class="form-inline">
                                    <input type="text" readonly style="max-width: 68%;width: 68%;" class="form-control" name="cuenta_fin" v-model="tercero">
                                    <button @click="abrirModalT()" style="min-width: 30px;" class="btn btn-primary form-control">...</button>
                                    <button @click="quitar(3)" style="min-width: 30px;" class="btn btn-danger form-control">
                                        <i class="icon-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group col-md-3" v-else>
                                <label for="">Proveedor(*)</label>
                                <div class="form-inline">
                                    <input type="text" readonly style="max-width: 68%;width: 68%;" class="form-control" name="cuenta_fin">
                                    <button style="min-width: 30px;" class="btn btn-secondary form-control">...</button>
                                    <button style="min-width: 30px;" class="btn btn-secondary form-control">
                                        <i class="icon-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Tipo ingreso</label>
                                <div>
                                    <select class="form-control" v-model="tipo_ingreso">
                                        <option value="Compras">Compras</option>
                                        <option value="Devoluciones">Devoluciones</option>
                                        <option value="Donaciones">Donaciones</option>
                                        <option value="Saldos iniciales">Saldos iniciales</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label><b>Fuente</b></label>
                                <div>
                                    <select v-if="tipo_ingreso=='Compras'" v-model="forma_pago" class="form-control">
                                        <option value="">NA</option>                                    
                                        <option v-for="fuente in arrayFuentes" :key="fuente.id" :value="fuente.id" v-text="fuente.nombre"></option>
                                    </select>
                                    <select v-else disabled v-model="forma_pago" class="form-control">
                                        <option value="" selected>NA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label><b>Fecha ingreso</b></label>
                                <div>
                                    <input type="date" class="form-control" v-model="fecha_ingreso">
                                </div>
                            </div>
                            <!--
                            <div class="col-md-3">
                                <label for="">Impuesto(*)</label>
                                <input type="text" class="form-control" v-model="impuesto">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo Comprobante(*)</label>
                                    <select class="form-control" v-model="tipo_comprobante">
                                        <option value="0">Seleccione</option>
                                        <option value="BOLETA">Boleta</option>
                                        <option value="FACTURA">Factura</option>
                                        <option value="TICKET">Ticket</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Serie Comprobante</label>
                                    <input type="text" class="form-control" v-model="serie_comprobante" placeholder="000x">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Número Comprobante(*)</label>
                                    <input type="text" class="form-control" v-model="num_comprobante" placeholder="000xx">
                                </div>
                            </div>
                            -->
                        </div>
                        <div class="form-group row border">
                            <div class="form-group col-md-12">
                                <label><b>Detalle</b></label>
                                <div>
                                    <textarea class="form-control" v-model="detalle_ingreso" style="height: 86px; max-height: 2.5em;"></textarea>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="float-left"><b>Saldo parcial</b></label>
                                <div class="float-right">
                                    <input type="checkbox" v-model="saldo_parcial">
                                </div>
                            </div>
                            <div class="form-group col-md-1">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="float-left"><b>Iva incluido</b></label>
                                <div class="float-right">
                                    <input type="checkbox" v-model="iva_incluido">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div v-show="errorIngreso" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjIngreso" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Artículo <span style="color:red;" v-show="idarticulo==0">(*Seleccione)</span></label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control" v-model="codigo" @keyup.enter="buscarArticulo()" placeholder="Ingrese artículo">
                                        <button @click="abrirModal()" class="btn btn-primary">...</button>
                                        <input type="text" readonly class="form-control" v-model="articulo">
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Precio <span style="color:red;" v-show="precio==0">(*Ingrese)</span></label>
                                    <input type="number" :min="1" step="any" class="form-control" v-model="precio">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cantidad <span style="color:red;" v-show="cantidad==0">(*Ingrese)</span></label>
                                    <input type="number" :min="1" class="form-control" v-model="cantidad">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm  table-responsive">
                                    <thead>
                                        <tr>
                                            <th class="col-md-1">Opciones</th>
                                            <th class="col-md-5">Artículo</th>
                                            <th class="col-md-2">Precio</th>
                                            <th class="col-md-2">Cantidad</th>
                                            <th class="col-md-2">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                            <td>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </td>
                                            <td v-text="detalle.articulo">
                                            </td>
                                            <td>
                                                <input v-model="detalle.precio" type="number" value="3" class="form-control">
                                            </td>
                                            <td>
                                                <input v-model="detalle.cantidad" type="number" value="2" class="form-control">
                                            </td>
                                            <td>
                                                {{detalle.precio*detalle.cantidad}}
                                            </td>
                                        </tr>
                                        <!--
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Parcial:</strong></td>
                                            <td>$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Impuesto:</strong></td>
                                            <td>$ {{totalImpuesto=((total*impuesto)/(1+impuesto)).toFixed(2)}}</td>
                                        </tr>
                                        -->
                                        <!--<tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Flete:</strong></td>
                                            <td><input type="number" v-model="flete"></td>
                                        </tr>-->
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                            <td>$ {{total=calcularTotal}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                NO hay artículos agregados
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarIngreso()">Registrar Ingreso</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- Fin Detalle-->
                    <!-- Ver ingreso -->
                    <template v-else-if="listado==2">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="">Proveedor</label>
                                    <p v-text="proveedor"></p>
                                </div>
                            </div>
                            <!--
                            <div class="col-md-3">
                                <label for="">Impuesto</label>
                                <p v-text="impuesto"></p>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo Comprobante</label>
                                    <p v-text="tipo_comprobante"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Serie Comprobante</label>
                                    <p v-text="serie_comprobante"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Número Comprobante</label>
                                    <p v-text="num_comprobante"></p>
                                </div>
                            </div>
                            -->
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm  table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Artículo</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                            <td v-text="detalle.articulo">
                                            </td>
                                            <td v-text="detalle.precio">
                                            </td>
                                            <td v-text="detalle.cantidad">
                                            </td>
                                            <td>
                                                {{detalle.precio*detalle.cantidad}}
                                            </td>
                                        </tr>
                                        <!--
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="3" align="right"><strong>Total Parcial:</strong></td>
                                            <td>$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="3" align="right"><strong>Total Impuesto:</strong></td>
                                            <td>$ {{totalImpuesto=((total*impuesto)).toFixed(2)}}</td>
                                        </tr>
                                        -->
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="3" align="right"><strong>Flete:</strong></td>
                                            <td>$ {{flete}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="3" align="right"><strong>Total Neto:</strong></td>
                                            <td>$ {{total}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="4">
                                                NO hay artículos agregados
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- fin ver ingreso -->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="control-label">Articulo</label>
                                    <div class="input-group">
                                        <input type="text" v-model="buscarA" @keyup="listarArticulo(buscarA,criterioA)" class="form-control" placeholder="Texto a buscar">
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm  table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Categoría</th>
                                            <th>Precio Venta</th>
                                            <th>Stock</th>
                                            <th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                            <td v-text="articulo.codigo" v-if="articulo.condicion==1"></td>
                                            <td v-text="articulo.nombre" v-if="articulo.condicion==1"></td>
                                            <td v-text="articulo.nombre_categoria" v-if="articulo.condicion==1"></td>
                                            <td v-text="articulo.precio_venta" v-if="articulo.condicion==1"></td>
                                            <td v-text="articulo.stock" v-if="articulo.condicion==1"></td>
                                            <td v-if="articulo.condicion==1">
                                                <div v-if="articulo.condicion">
                                                    <span class="badge badge-success">Activo</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger">Desactivado</span>
                                                </div>
                                            </td>
                                            <td v-if="articulo.condicion==1">
                                                <button type="button" @click="agregarDetalleModal(articulo)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                                </button>
                                            </td>
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

            <!-- Modal busqueda tercero-->
                <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal2}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-primary modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" v-text="tituloModal2"></h4>
                                <button type="button" class="close" @click="cerrarModalT()" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group row">
                                    <div style="max-width: 120px !important;" class="col-md-2   ">
                                        <label style='margin-top: 3px; '><b>Tercero</b></label>                                
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="cta_busq" v-model="terc_busq" @keyup="buscarTercero()">
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm  table-responsive">
                                        
                                            <tr><th>Documento</th><th>Nombre</th><th style="    width: 35px;">-</th></tr>
                                        
                                            <tr v-for="tercero in arrayTerceros" :key="tercero.id">
                                                <td v-text="tercero.num_documento"></td>
                                                <td v-if="tercero.nombre && !tercero.nombre1">{{ tercero.nombre }}  </td>
                                                <td v-else>{{ tercero.nombre1 + ' ' + validarUnder(tercero.nombre2)+' '+tercero.apellido1+' '+validarUnder(tercero.apellido2) }} </td>
                                                <td>
                                                    <button type="button" style=" margin-right: -8px;" @click="cargarTercero(tercero)" class="btn btn-success btn-sm" title='Ver formato'>
                                                        <i class="icon-check"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Fin Modal buscar proveedores -->

            <!-- Modal de evidencias -->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal3}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document" style="max-width: 800px !important">
                    <div class="modal-content" >
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal3"></h4>
                            <button v-if="permisosUser.crear && tipoAccion3==0" type="button" @click="abrirModal3('nuevo')" class="btn btn-default float-left">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>

                            <button type="button" class="close" @click="cerrarModal3()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" v-if="tipoAccion3==1">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label class="form-control-label col-md-1 flota-left">Nombre</label>
                                        <div class="col-md-11 float-right">
                                            <input type="text" class="form-control float-right" v-model="evidencia">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-control-label col-md-3 flota-left">Observacion</label>
                                        <div class="col-md-9 float-right">
                                            <textarea class="form-control" v-model="observacionEvidencia"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-control-label col-md-3 flota-left">Link</label>
                                        <div class="col-md-9 float-right">
                                            <input type="text" class="form-control" v-model="link">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row bordered">
                                    <div class="form-group col-md-6">
                                        <button v-if="tipoAccion3==1" type="button" class="btn btn-secondary float-right" @click="tipoAccion3=0">Cerrar</button>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <button v-if="tipoAccion3==1" type="button" class="btn btn-primary float-left" @click="registrarEvidencia()">Guardar</button>
                                    </div>
                                </div>
                            </form>
                            <!--<ul>
                                <li v-for="novedades in arrayNovedades" :key="novedades.id" v-text="novedades.nombre"></li>
                            </ul>-->
                            <table v-if="tipoAccion3==0" class="table table-bordered table-striped table-sm  table-responsive" style="display: block;border: none;overflow-y: auto;height: 26.2em;">
                                <thead>
                                    <th class="col-md-4">Nombre</th>
                                    <th>Observacion</th>
                                    <th class="col-md-1">Link</th>
                                    <th class="col-md-1">Opciones</th>
                                </thead>
                                <tbody v-if="arrayEvidencias.length">
                                    <tr v-for="evidencias in arrayEvidencias" :key="evidencias.id">
                                        <td v-text="evidencias.nombre"></td>
                                        <td><p v-text="evidencias.observacion" style="max-height: 6em !important;overflow-y: auto;"></p></td>
                                        <td><a :href="evidencias.link" target="_blank" class="icon-link"></a></td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" @click="eliminarEvidencia(evidencias.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr><td colspan="4">No hay evidencias regitradas</td></tr>
                                </tbody>
                            </table>
                            <nav v-if="tipoAccion3==0">
                                <ul class="pagination">
                                    <li class="page-item" v-if="pagination_evidencias.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent="cambiarPaginaEvidencias(pagination_evidencias.current_page - 1,buscar,criterio)">Ant</a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumberEvidencias" :key="page" :class="[page == isActivedEvidencias ? 'active' : '']">
                                        <a class="page-link" href="#" @click.prevent="cambiarPaginaEvidencias(page,buscar,criterio)" v-text="page"></a>
                                    </li>
                                    <li class="page-item" v-if="pagination_evidencias.current_page < pagination_evidencias.last_page">
                                        <a class="page-link" href="#" @click.prevent="cambiarPaginaEvidencias(pagination_evidencias.current_page + 1,buscar,criterio)">Sig</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal3()">Cerrar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    import vSelect from 'vue-select';
    export default {
        props : ['ruta','permisosUser'],
        data (){
            return {
                ingreso_id: 0,
                idproveedor:0,
                proveedor:'',
                nombre : '',
                tipo_comprobante : 'BOLETA',
                serie_comprobante : '',
                num_comprobante : '',
                impuesto: 0.18,
                total:0.0,
                totalImpuesto: 0.0,
                totalParcial: 0.0, 
                arrayIngreso : [],
                arrayProveedor: [],
                arrayDetalle : [],
                listado:1,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorIngreso : 0,
                errorMostrarMsjIngreso : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'num_comprobante',
                buscar : '',
                criterioA:'nombre',
                buscarA: '',
                arrayArticulo: [],
                idarticulo: 0,
                codigo: '',
                articulo: '',
                precio: 1,
                cantidad:1,

                // variables modal buscar tercero
                modal2 : '',
                tercero :'',
                id_tercero : '',
                tituloModal2 : '',
                buscar : '',   
                ctn_ban : 0,       
                tipo_cta : '',    
                cta_busq : '',  
                terc_busq : '',
                tipo_ingreso: '',
                arrayTerceros : [],

                cuenta_ini : '',
                id_cuenta_ini : '',
                cuenta_fin : '',
                id_cuenta_fin : '',

                forma_pago : '',
                flete : 0,
                fecha_ingreso : '',
                detalle_ingreso : '',
                arrayFuentes : [],

                // modal de evidencias
                modal3 : 0,
                tipoAccion3 : 0,
                tituloModal3 : '',
                evidencia : '',
                observacionEvidencia : '',
                link : '',
                arrayEvidencias : [],
                pagination_evidencias : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset_evidencias : 3,

                tipo_formato : '',
                arrayTiposFormatos : [],
                numero : 0,
                tipo_f_nom : '',

                saldo_parcial : '',
                iva_incluido : '',
            }
        },
        components: {
            vSelect
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
            isActivedEvidencias: function(){
                return this.pagination_evidencias.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumberEvidencias: function() {
                if(!this.pagination_evidencias.to) {
                    return [];
                }
                
                var from = this.pagination_evidencias.current_page - this.offset_evidencias; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset_evidencias * 2); 
                if(to >= this.pagination_evidencias.last_page){
                    to = this.pagination_evidencias.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
            calcularTotal: function(){
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)
                }
                return resultado;
            }
        },
        methods : {
            listarIngreso (page,buscar,criterio){
                let me=this;
                var url= this.ruta +'/ingreso?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayIngreso = respuesta.ingresos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectProveedor(search,loading){
                let me=this;
                loading(true)

                var url= this.ruta +'/proveedor/selectProveedor?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayProveedor=respuesta.proveedores;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarEvidencias(page,id){
                let me=this;
                var url=  this.ruta +'/evidencias/listarEvidencias?page='+page+'&id='+id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayEvidencias = respuesta.evidencias.data;
                    me.pagination_evidencias= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosProveedor(val1){
                let me = this;
                me.loading = true;
                me.idproveedor = val1.id;
            },
            buscarArticulo(){
                let me=this;
                var url= this.ruta +'/articulo/buscarArticulo?filtro=' + me.codigo;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos;

                    if (me.arrayArticulo.length>0){
                        me.articulo=me.arrayArticulo[0]['nombre'];
                        me.idarticulo=me.arrayArticulo[0]['id'];
                        me.precio = 1;
                        me.cantidad = 1;
                        // me.cantidad=me.arrayArticulo[0]['stock'];
                    }
                    else{
                        me.articulo='No existe artículo';
                        me.idarticulo=0;
                        me.precio = 0;
                        me.cantidad = 0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectFuentes(){ 
                let me=this;
                var url= this.ruta +'/cuentas/get_fuentes2';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayFuentes = respuesta.fuentes;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiar_tipo_f(){
                let me=this;            
                if(me.tipo_formato!='')
                {
                    var url= this.ruta +'/conf_formatos/get_filt_tipo?id_formato=' + me.tipo_formato;

                    axios.get(url).then(function (response) {
                        var respuesta= response.data;
                        me.tipo_f_nom = respuesta.tipo;
                        me.getNumeroNext();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
                else{
                    me.tipo_f_nom = '';
                }
            },
            selectTipoFormato(){ 
                let me=this;
                var url= this.ruta +'/conf_formatos/get_tipos_formatos';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayTiposFormatos = respuesta.conf_formatos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getNumeroNext(){
                let me = this;
                console.log('tipo formato. '+me.tipo_formato);
                // if(me.formato)
                // {
                    var url = this.ruta +'/formatos/numero_next?tipo_formato='+me.tipo_formato;
                    axios.get(url).then(function (response) {
                        var respuesta= response.data;
                        me.numero = respuesta.numero;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                // }
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarIngreso(page,buscar,criterio);
            },
            cambiarPaginaEvidencias(page,id_ingreso){
                let me = this;
                //Actualiza la página actual
                me.pagination_evidencias.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarEvidencias(page,me.ingreso_id);
            },
            encuentra(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].idarticulo==id){
                        sw=true;
                    }
                }
                return sw;
            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index, 1);
            },
            agregarDetalle(){
                let me=this;
                if(me.idarticulo==0 || me.cantidad==0 || me.precio==0){
                }
                else{
                    if(me.encuentra(me.idarticulo)){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese artículo ya se encuentra agregado!',
                            })
                    }
                    else{
                       me.arrayDetalle.push({
                            idarticulo: me.idarticulo,
                            articulo: me.articulo,
                            cantidad: me.cantidad,
                            precio: me.precio
                        });
                        me.codigo="";
                        me.idarticulo=0;
                        me.articulo="";
                        me.cantidad=0;
                        me.precio=0; 
                    }
                    
                }

                

            },
            agregarDetalleModal(data =[]){
                let me=this;
                if(me.encuentra(data['id'])){
                    swal({
                        type: 'error',
                        title: 'Error...',
                        text: 'Ese artículo ya se encuentra agregado!',
                        })
                }
                else{
                    me.arrayDetalle.push({
                        idarticulo: data['id'],
                        articulo: data['nombre'],
                        cantidad: 1,
                        precio: 1
                    }); 
                    me.cerrarModal();
                }
            },
            listarArticulo (buscar,criterio){
                let me=this;
                var url= this.ruta +'/articulo/listarArticulo?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                    console.log('buscar: '+buscar);
                    console.log(me.arrayArticulo);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarIngreso(){
                // if (this.validarIngreso()){
                //     return;
                // }
                
                let me = this;
                me.tipo_comprobante = null;
                me.serie_comprobante = null;
                me.num_comprobante = null;
                me.impuesto = null;

                axios.post(this.ruta +'/ingreso/registrar',{
                    'idproveedor': this.id_tercero,
                    'tipo_comprobante': this.tipo_comprobante,
                    'serie_comprobante' : this.serie_comprobante,
                    'num_comprobante' : this.num_comprobante,
                    'tipo_ingreso' : this.tipo_ingreso,
                    'impuesto' : this.impuesto,
                    'total' : this.total,
                    'forma_pago' : this.forma_pago,
                    'flete' : this.flete,
                    'fecha_ingreso' : this.fecha_ingreso,
                    'detalle' : this.detalle_ingreso,
                    'data': this.arrayDetalle,
                    'tipo_movimiento' : 2,
                    'saldo_parcial' : this.saldo_parcial,
                    'iva_incluido' : this.iva_incluido,
                    'sumatoria' : 0
                }).then(function (response) {
                    me.listado=1;
                    me.listarIngreso(1,'','num_comprobante');
                    me.id_tercero=0;
                    // me.tipo_comprobante='BOLETA';
                    me.tipo_comprobante='';
                    me.serie_comprobante='';
                    me.num_comprobante='';
                    me.impuesto='';
                    me.total=0.0;
                    me.idarticulo=0;
                    me.articulo='';
                    me.cantidad=0;
                    me.precio=0;
                    me.arrayDetalle=[];
                    me.id_tercero = 0,
                    me.tipo_ingreso = 0,
                    me.arrayTerceros=[];
                    me.tipo_movimiento = '';
                    me.saldo_parcial = '';
                    me.iva_incluido = '';
                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarIngreso(){
                this.errorIngreso=0;
                this.errorMostrarMsjIngreso =[];

                if (this.idproveedor==0) this.errorMostrarMsjIngreso.push("Seleccione un Proveedor");
                if (this.tipo_comprobante==0) this.errorMostrarMsjIngreso.push("Seleccione el comprobante");
                if (!this.num_comprobante) this.errorMostrarMsjIngreso.push("Ingrese el número de comprobante");
                if (!this.impuesto) this.errorMostrarMsjIngreso.push("Ingrese el impuesto de compra");
                if (this.arrayDetalle.length<=0) this.errorMostrarMsjIngreso.push("Ingrese detalles");

                if (this.errorMostrarMsjIngreso.length) this.errorIngreso = 1;

                return this.errorIngreso;
            },
            mostrarDetalle(){
                let me=this;
                me.listado=0;

                me.idproveedor=0;
                me.tipo_comprobante='BOLETA';
                me.serie_comprobante='';
                me.num_comprobante='';
                me.impuesto=0.18;
                me.total=0.0;
                me.idarticulo=0;
                me.articulo='';
                me.cantidad=0;
                me.precio=0;
                me.arrayDetalle=[];
                me.arrayFuentes=[];
                me.saldo_parcial = '';
                me.iva_incluido = '';

                me.selectFuentes();
                me.selectTipoFormato();
            },
            ocultarDetalle(){
                let me=this;
                me.listado=1;
                me.idproveedor=0;
                me.tipo_comprobante='BOLETA';
                me.serie_comprobante='';
                me.num_comprobante='';
                me.impuesto=0.18;
                me.total=0.0;
                me.idarticulo=0;
                me.articulo='';
                me.cantidad=0;
                me.precio=0;
                me.forma_pago=0;
                me.flete = 0;
                me.arrayDetalle=[];
                me.arrayFuentes=[];
                me.id_tercero = 0;
                me.tercero = '';
                me.num_documento = '';
                me.fuente = 0;
                me.detalle = '';
            },
            verIngreso(id){
                let me=this;
                me.listado=2;
                
                //Obtener los datos del ingreso
                var arrayIngresoT=[];
                var url= this.ruta +'/ingreso/obtenerCabecera?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayIngresoT = respuesta.ingreso;

                    me.proveedor = arrayIngresoT[0]['nombre'];
                    me.tipo_comprobante=arrayIngresoT[0]['tipo_comprobante'];
                    me.serie_comprobante=arrayIngresoT[0]['serie_comprobante'];
                    me.num_comprobante=arrayIngresoT[0]['num_comprobante'];
                    me.impuesto=arrayIngresoT[0]['impuesto'];
                    me.flete=arrayIngresoT[0]['flete'];
                    me.total=arrayIngresoT[0]['total'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles 
                var urld= this.ruta +'/ingreso/obtenerDetalles?id=' + id;
                
                axios.get(urld).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalles;
                })
                .catch(function (error) {
                    console.log(error);
                });               
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            }, 
            abrirModal(){               
                this.arrayArticulo=[];
                this.modal = 1;
                this.tituloModal = 'Seleccione uno o varios artículos';
            },
            cerrarModal3(){
                this.modal3=0;
                this.tituloModal3='';
                this.tipoAccion3=0;
                this.evidencia='';
                this.observacionEvidencia='';
                this.link='';
                this.ingreso_id=0;
                this.tipoAccion3=0;
                this.arrayEvidencias = [];
                this.pagination_evidencias = [];
            }, 
            abrirModal3(accion,data){

                switch(accion){
                    case 'ver':{
                        this.modal3 = 1;
                        this.tituloModal3 = 'Evidencias';
                        this.ingreso_id = data['id'];
                        // this.persona_id=data['id'];
                        this.listarEvidencias(1,data['id']);
                        break;
                    }
                    case 'nuevo':{
                        this.tipoAccion3 = 1;
                        break;
                    }
                }
            },
            registrarEvidencia(){
                // if (this.validarPersona()){
                //     return;
                // }
                
                let me = this;

                axios.post( this.ruta +'/evidencias/registrar',{
                    'id_ingreso' : this.ingreso_id,
                    'nombre': this.evidencia,
                    'observacion' : this.observacionEvidencia,
                    'link' : this.link,
                }).then(function (response) {
                    me.tipoAccion3=0;
                    me.listarEvidencias(1,me.ingreso_id);
                }).catch(function (error) {
                    console.log(error); 
                });
            },
            eliminarEvidencia(id){
                let me = this;

                axios.put( this.ruta +'/evidencias/eliminarEvidencia',{
                    'id': id,
                }).then(function (response) {
                    me.listarEvidencias(1,me.ingreso_id);
                }).catch(function (error) {
                    console.log(error); 
                });
            },
            desactivarIngreso(id){
               swal({
                title: 'Esta seguro de anular este ingreso?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put(this.ruta +'/ingreso/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarIngreso(1,'','num_comprobante');
                        swal(
                        'Anulado!',
                        'El ingreso ha sido anulado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },

            // funcion abrir modal proveedores
            abrirModalT(tipo_cta){               
                this.arrayTerceros=[];
                this.modal2 = 1;
                this.tipo_cta = tipo_cta;
                this.tituloModal = 'Seleccione un tercero';
            },
            cerrarModalT(){
                this.modal2=0;
                this.tituloModal2='';
                this.terc_busq = '';
            },
            cargarTercero(tercero){
                
                this.tercero = tercero['num_documento']+' - '+tercero['nombre1']+' '+tercero['apellido1'];
                this.id_tercero = tercero['id'];                
                this.cerrarModalT();
            },
            buscarTercero(){
                let me=this;
                var search = this.terc_busq;
                var url= this.ruta +'/cliente/selectCliente?filtro='+search;
                 axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayTerceros = respuesta.clientes;                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validarUnder(valor)
            {
                if(valor == "undefined" || valor=="" || !valor)
                    return "";
                else
                    return valor;
            },
            quitar(opc){
                //alert(opc);
                if(opc==1){
                    this.id_cuenta_ini = '';
                    this.cuenta_ini = '';
                }
                if(opc==2){
                    this.id_cuenta_fin = '';
                    this.cuenta_fin = '';
                }
                if(opc==3){
                    this.id_tercero = '';
                    this.tercero = '';
                }
            }
        },
        mounted() {
            let me= this;
            var d = new Date();
            
            
            var dd = d.getDate();
            var mm = d.getMonth()+1;
            var yyyy = d.getFullYear();
            var h = d.getHours();
            var min = d.getMinutes();
            var sec = d.getSeconds();
            
            if(dd<10){
                dd='0'+dd;
            } 
            if(mm<10){
                mm='0'+mm;
            } 
            d = yyyy+'-'+mm+'-'+dd;
            me.fecha_ingreso= d;

            this.listarIngreso(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
    .modal-content{       
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
