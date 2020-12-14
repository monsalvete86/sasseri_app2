<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Egreso
                    <button v-if="permisosUser.crear && tipoAccion==0 && listado!=2" type="button" @click="mostrarDetalle()" class="btn btn-primary">
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
                                <!--<select v-if="permisosUser.leer" class="form-control col-md-3" v-model="criterio" @change="listarEgreso(1,buscar,criterio)">
                                    <option value="tipo_comprobante">Tipo Comprobante</option>
                                    <option value="num_comprobante">Número Comprobante</option>
                                    <option value="fecha_hora">Fecha-Hora</option>
                                </select>
                                <select v-else disabled class="form-control col-md-3" v-model="criterio">
                                </select>-->

                                <!--<input v-if="permisosUser.leer" type="text" v-model="buscar" @keyup="listarEgreso(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <input v-else disabled type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar">-->

                                <label class="col-md-3">Tipo Egreso</label>
                                <select class="form-control col-md-4" v-model="tipo_egreso_filtro" @change="listarEgreso(1,tipo_egreso_filtro,'tipo_egreso')">
                                    <option value=''>Seleccione</option>
                                    <option value="Bajas">Bajas</option>
                                    <option value="Ajuste inventario">Ajuste inventario</option>
                                    <option value="Devoluciones">Devoluciones</option>
                                </select>

                                <!--<button v-if="permisosUser.leer" type="submit" @click="listarEgreso(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                <button v-else type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> Buscar</button>-->
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
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
                            <tbody v-if="permisosUser.leer && arrayEgreso.length">
                                <tr v-for="egreso in arrayEgreso" :key="egreso.id">
                                    <td v-text="egreso.usuario"></td>
                                    <td v-text="egreso.nombre"></td>
                                    <!--
                                    <td v-text="egreso.tipo_comprobante"></td>
                                    <td v-text="egreso.serie_comprobante"></td>
                                    <td v-text="egreso.num_comprobante"></td>
                                    -->
                                    <td v-text="egreso.fecha_hora"></td>
                                    <td v-text="egreso.total"></td>
                                    <!-- <td v-text="egreso.impuesto"></td> -->
                                    <td v-text="egreso.estado"></td>
                                    <td>
                                        <button v-if="permisosUser.leer" type="button" @click="verEgreso(egreso.id)" class="btn btn-success btn-sm" title="Ver detalles">
                                        <i class="icon-eye"></i>
                                        </button>
                                        <button v-else type="button" class="btn btn-secondary btn-sm" title="Ver detalles">
                                        <i class="icon-eye"></i>
                                        </button> &nbsp;

                                        <button v-if="permisosUser.actualizar && egreso.estado=='Registrado'" type="button" @click="abrirModalActualizarEgreso(egreso)" class="btn btn-warning btn-sm" title="Actualizar"><i class="icon-pencil"></i></button>
                                        <button v-else type="button" class="btn btn-secondary btn-sm" title="Actualizar (Deshabilitado)"><i class="icon-pencil"></i></button> &nbsp;

                                        <template>
                                            <button v-if="permisosUser.anular && egreso.estado=='Registrado'" type="button" class="btn btn-danger btn-sm" @click="desactivarEgreso(egreso.id)" title="Anular">
                                                <i class="icon-trash"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-secondary btn-sm" title="Anular">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template> &nbsp;

                                        <button type="button" @click="abrirModal3('ver',egreso)" class="btn btn-info btn-sm" title="Ver evidencias">
                                            <i class="fa fa-align-justify"></i>
                                        </button> &nbsp;

                                        <button type="button" v-if="permisosUser.actualizar && egreso.estado=='Registrado'" class="btn btn-danger btn-sm" @click="cerrarEgreso(egreso)" title="Cerrar Egreso">
                                            <i class="fa fa-window-close"></i>
                                        </button>
                                        <button type="button" v-else class="btn btn-secondary btn-sm" title="Cerrar Egreso (Deshabilidado)">
                                            <i class="fa fa-window-close"></i>
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
                        <div class="form-group col-md-3" v-if="tipo_egreso!='Saldos iniciales'">
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
                            <label>Tipo egreso</label>
                            <div>
                                <select class="form-control" v-model="tipo_egreso" @change="if(tipo_egreso!='Compras'){forma_pago='';}">
                                    <option value="Bajas">Bajas</option>
                                    <option value="Ajuste inventario">Ajuste inventario</option>
                                    <option value="Devoluciones">Devoluciones</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label><b>Fuente</b></label>
                            <div>
                                <select v-model="forma_pago" class="form-control">
                                    <option value="">NA</option>
                                    <option v-for="fuente in arrayFuentes" :key="fuente.id" :value="fuente.id" v-text="fuente.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label><b>Fecha egreso</b></label>
                            <div>
                                <input type="date" class="form-control" v-model="fecha_egreso">
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
                                <textarea class="form-control" v-model="detalle_egreso" style="height: 86px; max-height: 2.5em;"></textarea>
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
                            <div v-show="errorEgreso" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjEgreso" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row border">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Artículo <span style="color:red;" v-show="idarticulo==0">(*Seleccione)</span></label>
                                <div class="form-inline">
                                    <input type="text" class="form-control col-md-10" v-model="codigo" @keyup.enter="buscarArticulo()" placeholder="Ingrese artículo">
                                    <button @click="abrirModal()" class="btn btn-primary col-md-2">...</button>
                                    <input type="text" readonly class="form-control col-md-12" v-model="articulo">
                                </div>                                    
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Precio Und <span style="color:red;" v-if="!saldo_parcial" v-show="precio==0">(*)</span></label>
                                <input v-if="!saldo_parcial && codigo!='' && idarticulo!=0" type="number" :min="1" step="any" class="form-control" v-model="precio">
                                <input v-else disabled type="number" :min="0" step="any" class="form-control" v-model="precio">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Cantidad <span style="color:red;" v-show="cantidad==0">(*)</span></label>
                                <input type="number" v-if="codigo!='' && idarticulo!=0" :min="1" class="form-control" v-model="cantidad">
                                <input type="number" v-else :min="0" disabled class="form-control" v-model="cantidad">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Precio parcial <span style="color:red;" v-if="saldo_parcial" v-show="precio==0">(*)</span></label>
                                <input v-if="saldo_parcial && codigo!='' && idarticulo!=0" type="number" :min="1" step="any" class="form-control" v-model="precio_parcial">
                                <input v-else disabled type="number" :min="0" step="any" class="form-control" v-model="precio_parcial">
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
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th class="col-md-1">Opciones</th>
                                        <th class="col-md-2">Artículo</th>
                                        <th class="col-md-2">Precio</th>
                                        <th class="col-md-2">Cantidad</th>
                                        <th class="col-md-1">Iva</th>
                                        <th class="col-md-1">%</th>
                                        <th class="col-md-2">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody v-if="arrayDetalle.length && arrayDetalle.length">
                                    <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                        <td>
                                            <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                <i class="icon-close"></i>
                                            </button>
                                        </td>
                                        <td v-text="detalle.articulo">
                                        </td>
                                        <td>
                                            $ {{ detalle.precio }}
                                        </td>
                                        <td>
                                            {{ detalle.cantidad }}
                                        </td>

                                        <td v-if="iva_incluido==true && detalle.porcentaje && regimen_tercero!='Simplificado'">
                                            {{ detalle.iva_individual = Math.round((detalle.precio*detalle.cantidad)-((detalle.precio*detalle.cantidad)/((detalle.porcentaje/100)+1))) }}
                                        </td>
                                        <td v-else-if="iva_incluido==false && detalle.porcentaje && regimen_tercero!='Simplificado'">
                                            {{ detalle.iva_individual = Math.round((detalle.precio*detalle.cantidad)*(detalle.porcentaje/100)) }}
                                        </td>
                                        <td v-else>
                                            <span>N/A</span>
                                        </td>
                                        <!--<td v-else><span>Nada</span></td>-->

                                        <td v-if="detalle.porcentaje && regimen_tercero!='Simplificado'">{{detalle.porcentaje+' %'}}</td>
                                        <td v-else>N/A</td>
                                        <td v-if="regimen_tercero!='Simplificado'">
                                            <span v-if="iva_incluido">
                                                {{ (detalle.precio*detalle.cantidad)-detalle.iva_individual }}
                                            </span>
                                            <span v-else>
                                                {{ detalle.precio*detalle.cantidad }}
                                            </span>
                                        </td>
                                        <td v-else>
                                            {{ detalle.precio*detalle.cantidad }}
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
                                    <tr style="background-color: #CEECF5;" @click="retornariva()">
                                        <td colspan="6" align="right"><strong>Total Iva:</strong></td>
                                        <td>$ {{total_iva=calcularTotalIva}}</td>
                                    </tr>
                                    <tr style="background-color: #CEECF5;">
                                        <td colspan="6" align="right"><strong>Subtotales:</strong></td>
                                        <td>$ {{total_subtotal=calcularTotalSubtotales}}</td>
                                    </tr>
                                    <tr style="background-color: #CEECF5;">
                                        <td colspan="6" align="right"><strong>Total Neto:</strong></td>
                                        <td>$ {{total=calcularTotal}}</td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="7">
                                            NO hay artículos agregados
                                        </td>
                                    </tr>
                                </tbody>                                    
                            </table>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="button" @click="ocultarDetalle()" class="btn btn-primary">Atrás</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarEgreso()">Registrar Egreso</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-success" @click="actualizarEgreso()">Actualizar Egreso</button>
                        </div>
                    </div>
                </div>
                </template>
                <!-- Fin Detalle-->
                <!-- Ver egreso -->
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
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th class="col-md-3">Artículo</th>
                                        <th class="col-md-2">Precio</th>
                                        <th class="col-md-2">Cantidad</th>
                                        <th class="col-md-1">Iva</th>
                                        <th class="col-md-1">%</th>
                                        <th class="col-md-2">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody v-if="arrayDetalle.length && arrayDetalle.length">
                                    <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                        <td v-text="detalle.articulo">
                                        </td>
                                        <td v-text="detalle.precio">
                                        </td>
                                        <td v-text="detalle.cantidad">
                                        </td>
                                        <td v-if="iva_incluido==true && detalle.porcentaje && regimen_tercero!='Simplificado'">
                                            {{ detalle.iva_individual = Math.round((detalle.precio*detalle.cantidad)-((detalle.precio*detalle.cantidad)/((detalle.porcentaje/100)+1))) }}
                                        </td>
                                        <td v-else-if="iva_incluido==false && detalle.porcentaje && regimen_tercero!='Simplificado'">
                                            {{ detalle.iva_individual = Math.round((detalle.precio*detalle.cantidad)*(detalle.porcentaje/100)) }}
                                        </td>
                                        <td v-else>
                                            <span>N/A</span>
                                        </td>
                                        <!--<td v-else><span>Nada</span></td>-->

                                        <td v-if="detalle.porcentaje && regimen_tercero!='Simplificado'">{{detalle.porcentaje+' %'}}</td>
                                        <td v-else>N/A</td>
                                        <td v-if="regimen_tercero!='Simplificado'">
                                            <span v-if="iva_incluido">
                                                {{ (detalle.precio*detalle.cantidad)-detalle.iva_individual }}
                                            </span>
                                            <span v-else>
                                                {{ detalle.precio*detalle.cantidad }}
                                            </span>
                                        </td>
                                        <td v-else>
                                            {{ detalle.precio*detalle.cantidad }}
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
                                    <!--<tr style="background-color: #CEECF5;">
                                        <td colspan="3" align="right"><strong>Flete:</strong></td>
                                        <td>$ {{flete}}</td>
                                    </tr>-->
                                    <tr style="background-color: #CEECF5;" @click="retornariva()">
                                        <td colspan="5" align="right"><strong>Total Iva:</strong></td>
                                        <td>$ {{total_iva=calcularTotalIva}}</td>
                                    </tr>
                                    <tr style="background-color: #CEECF5;">
                                        <td colspan="5" align="right"><strong>Subtotales:</strong></td>
                                        <td>$ {{total_subtotal=calcularTotalSubtotales}}</td>
                                    </tr>
                                    <tr style="background-color: #CEECF5;">
                                        <td colspan="5" align="right"><strong>Total Neto:</strong></td>
                                        <td>$ {{total=calcularTotal}}</td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="6">
                                            NO hay artículos agregados
                                        </td>
                                    </tr>
                                </tbody>                                    
                            </table>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="button" @click="ocultarDetalle()" class="btn btn-primary">Atrás</button>
                        </div>
                    </div>
                </div>
                </template>
                <!-- fin ver egreso -->
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
                            <span aria-hidden="true" title="Cerrar">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-5 pb-sm-1">
                                <label class="control-label col-sm-3 col-md-4 float-left"><i class="fa fa-search"></i> Buscar</label>
                                <input type="text" v-model="buscarA" @keyup="listarArticulo(buscarA,criterioA,buscarCategoriaA)" class="form-control col-sm-9 col-md-8 float-right" placeholder="Texto a buscar">
                            </div>
                            <div class="col-sm-9 col-md-5">
                                <label class="control-label col-sm-4 col-md-4 float-left"><i class="fa fa-search"></i> Categoría</label>
                                <select class="form-control col-sm-8 col-md-8 float-right" v-model="buscarCategoriaA" @change="listarArticulo(buscarA,criterioA,buscarCategoriaA)">
                                    <option value="">Seleccione</option>
                                    <option v-for="categoria in arrayCategoria2" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                </select>
                            </div>
                            <div class="col-sm-3 col-md-2 text-center">
                                <button v-if="tipo_vista_articulo==1" type="button" class="btn btn-info"><i class="fa fa-list"></i></button>
                                <button v-else type="button" class="btn btn-secondary" @click="tipo_vista_articulo=1"><i class="fa fa-list"></i></button>
                                <button v-if="tipo_vista_articulo==2" type="button" class="btn btn-info"><i class="fa fa-th-large"></i></button>
                                <button v-else type="button" class="btn btn-secondary" @click="tipo_vista_articulo=2"><i class="fa fa-th-large"></i></button>
                            </div>
                        </div>
                        <div v-if="tipo_vista_articulo==1" class="table-responsive" style="display: block;height: 35em;max-height: 35em;overflow-y: auto;">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>IMG</th>
                                        <th>Nombre</th>
                                        <th>Modelo contable</th>
                                        <th>Categoría</th>
                                        <th>Saldo parcial</th>
                                        <th>Precio Venta</th>
                                        <th>Stock</th>
                                        <th>Cant</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody v-if="arrayArticulo.length">
                                    <tr v-for="(articulo, index) in arrayArticulo">
                                        <td v-if="articulo.padre==''" v-text="articulo.codigo"></td>
                                        <td v-else></td>
                                        <td>
                                            <img v-if="`${articulo.img}`!='default.png'" :src="`${ruta}/Empresas/${articulo.id_empresa}_empresa/ImgProductos/${articulo.img}`" height="30" width="30">

                                            <img v-else :src="`${ruta}/Empresas/${articulo.img}`" height="30" width="30">
                                        </td>
                                        <td>
                                            <span v-text="articulo.nombre"></span>
                                            <span v-if="articulo.id_presentacion!=null" v-text="' - '+articulo.nom_presentacion"></span>
                                            <span v-else> - N/A presentacion</span>
                                            <span v-if="articulo.talla!=null" v-text="' - '+articulo.talla"></span>
                                            <span v-else> - N/A talla</span>
                                        </td>
                                        <td v-text="articulo.nom_modelo_contable"></td>
                                        <td v-text="articulo.nom_categoria"></td>
                                        <td><input type="checkbox" v-model="articulo.saldo_parcial"></td>
                                        <td><input type="number" v-model="articulo.prec"></td>
                                        <td v-if="articulo.padre!=''" v-text="parseInt(articulo.stock/articulo.unidades)"></td>
                                        <td v-else v-text="articulo.stock"></td>
                                        <td><input type="number" v-model="articulo.cant"></td>
                                        <td v-if="articulo.cant && articulo.prec">
                                            <button type="button" v-if="articulo.cant!=0 && articulo.cant!='' && articulo.prec!=0 && articulo.prec!=''" @click="agregarDetalleModal(articulo), articulo.prec='',articulo.cant=''" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                            </button>
                                            <button type="button" v-else class="btn btn-secondary btn-sm">
                                                <i class="icon-check"></i>
                                            </button>
                                        </td>
                                        <td v-else>
                                            <button type="button" class="btn btn-secondary btn-sm">
                                                <i class="icon-check"></i>
                                            </button>
                                        </td>
                                    </tr>                                
                                </tbody>
                                <tbody v-else>
                                    <tr colspan="10">No hay registros para mostrar</tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="tipo_vista_articulo==2" class="container" style="display: block;height: 36em;max-height: 36em;overflow-y: auto;">
                            <div v-for="(articulo, index) in arrayArticulo" @click="abrirModalCantidadArticulo(articulo)" class="col-sm-6 col-md-3 p-sm-2 p-md-1 mosaico" style="height: 43%;">
                                <div class="border col-md-12" style="height: 100%;">
                                    <div class="text-center py-md-2">
                                        <img v-if="`${articulo.img}`!='default.png'" :src="`${ruta}/Empresas/${articulo.id_empresa}_empresa/ImgProductos/${articulo.img}`" class="img-responsive img-thumbnail" style="width: 8.5em;height: 8.5em;">

                                        <img v-else :src="`${ruta}/Empresas/${articulo.img}`" class="img-responsive img-thumbnail" style="width: 8.5em;height: 8.5em;">
                                    </div>
                                    <div class="text-center col-md-12">
                                        <h6 v-text="articulo.nombre"></h6>
                                        <span v-if="articulo.id_presentacion!=null" v-text="articulo.nom_presentacion"></span>
                                        <span v-else>N/A presentacion</span>
                                    </div>
                                    <div class="text-center col-md-12 pb-md-1">
                                        <span v-text="'Precio: '+articulo.precio_venta"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="cerrarModal()">Cerrar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->

        <!-- Modal cantidad por articulo-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalCantidadArticulo}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content" style="width:35em !important;">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModalCantidadArticulo"></h4>
                        <button type="button" class="close" @click="cerrarModalCantidadArticulo()" aria-label="Close">
                            <span aria-hidden="true" title="Cerrar">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 pb-sm-2 pb-md-1">
                                    <div class="col-sm-10 col-md-10 float-left">
                                        <label class="col-sm-3 col-md-4 float-left">Cant</label>
                                        <input type="number" class="form-control float-right col-sm-9 col-md-8" v-model="cantidadArticulo">

                                        <label class="col-sm-3 col-md-4 float-left">Precio</label>
                                        <input type="number" class="form-control float-right col-sm-9 col-md-8" v-model="precioArticulo">
                                    </div>
                                    <div class="col-sm-2 col-md-2 float-right">
                                        <button v-if="cantidadArticulo!=0 && cantidadArticulo!='' && precioArticulo!=0 && precioArticulo!=''" type="button" @click="agregarDetalleModalCantidadArticulo()" class="btn btn-success btn-sm float-right">
                                            <i class="icon-check"></i>
                                        </button>
                                        <button v-else type="button" class="btn btn-secondary btn-sm float-right">
                                            <i class="icon-check"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="col-sm-4 col-md-5">
                                        <label class="col-sm-6 col-md-6 float-left">Stock</label>
                                        <label class="col-sm-6 col-md-6 float-right" v-text="stockCantidadArticulo"></label>
                                    </div>
                                    <div class="col-sm-4 col-md-5">
                                        <label class="col-sm-6 col-md-6 float-left">Saldo parcial</label>
                                        <input type="checkbox" class="col-sm-6 col-md-6 float-right" v-model="saldoParcialCantidadArticulo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModalCantidadArticulo()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal busqueda tercero-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal2}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal2"></h4>
                            <button type="button" class="close" @click="cerrarModalT()" aria-label="Close">
                                <span aria-hidden="true" title="Cerrar">×</span>
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
                                <table class="table table-bordered table-striped table-sm">
                                    
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
                            <span aria-hidden="true" title="Cerrar">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" v-if="tipoAccion3==1">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="form-control-label col-md-1 flota-left">Nombre</label>
                                    <div class="col-md-11 float-right">
                                        <input type="text" class="form-control float-right" v-model="evidencia" style="width: 96%;">
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
                                    <button v-if="tipoAccion3==1" type="button" class="btn btn-primary float-right" @click="tipoAccion3=0">Cancelar</button>
                                </div>
                                <div class="form-group col-md-6">
                                    <button v-if="tipoAccion3==1" type="button" class="btn btn-success float-left" @click="registrarEvidencia()">Guardar</button>
                                </div>
                            </div>
                        </form>
                        <!--<ul>
                            <li v-for="novedades in arrayNovedades" :key="novedades.id" v-text="novedades.nombre"></li>
                        </ul>-->
                        <table v-if="tipoAccion3==0" class="table table-bordered table-striped table-sm" style="display: block;border: none;overflow-y: auto;height: 26.2em;">
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
                        <button type="button" class="btn btn-primary" @click="cerrarModal3()">Cerrar</button>
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
        props : ['ruta'],
        data (){
            return {
                permisosUser : {
                    'leer' : 1,
                    'escribir' : 1,
                    'crear' : 1,
                    'actualizar' : 1,
                    'anular' : 1,
                },
                egreso_id: 0,
                idproveedor:0,
                proveedor:'',
                nombre : '',
                tipo_comprobante : 'BOLETA',
                serie_comprobante : '',
                num_comprobante : '',
                impuesto: 0.18,
                total:0.0,
                total2:0.0,
                totalImpuesto: 0.0,
                totalParcial: 0.0, 
                arrayEgreso : [],
                arrayProveedor: [],
                arrayDetalle : [],
                listado:1,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                tipoAccion1 : 0,
                errorEgreso : 0,
                errorMostrarMsjEgreso : [],
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
                buscarCategoriaA : '',
                arrayCategoria2 : [],
                arrayArticulo: [],
                idarticulo: 0,
                codigo: '',
                articulo: '',
                precio: 1,
                cantidad:1,
                precio_parcial : 1,

                // variables modal buscar tercero
                modal2 : '',
                tercero :'',
                id_tercero : '',
                regimen_tercero : '',
                tituloModal2 : '',
                buscar : '',   
                ctn_ban : 0,       
                tipo_cta : '',    
                cta_busq : '',  
                terc_busq : '',
                tipo_egreso: '',
                arrayTerceros : [],

                tipo_egreso_filtro : 0,

                cuenta_ini : '',
                id_cuenta_ini : '',
                cuenta_fin : '',
                id_cuenta_fin : '',

                forma_pago : '',
                flete : 0,
                fecha_egreso : '',
                detalle_egreso : '',
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
                nom_presentacion : '',
                padreDetalle : '',
                tipo_vista_articulo:1,

                tipo_formato : '',
                arrayTiposFormatos : [],
                numero : 0,
                tipo_f_nom : '',

                saldo_parcial : '',
                iva_incluido : '',
                total_iva : 0.0,
                total_subtotal : 0.0,
                porcentaje : 0,

                // modal cantidad articulo
                modalCantidadArticulo : 0,
                tituloModalCantidadArticulo : '',
                cantidadArticulo : 0,
                precioArticulo : 0,
                stockCantidadArticulo : 0,
                saldoParcialCantidadArticulo : false,
                arrayInfoArticuloModalCantidad : [],

                accionCodigoBarras : 0,
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
                var iva_indivi = 0.0;
                if(!this.saldo_parcial || this.saldo_parcial!=false || this.saldo_parcial!=0)
                {
                    for(var i=0;i<this.arrayDetalle.length;i++){
                        iva_indivi = 0.0;
                        if(this.iva_incluido){
                            resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad);
                        }
                        else{
                            if(this.regimen_tercero!='Simplificado')
                            {
                            iva_indivi = Math.round((this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)*(this.arrayDetalle[i].porcentaje/100));
                            }
                            else{iva_indivi=0.0;}

                            resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)+iva_indivi;
                        }
                    }
                }
                else
                {
                    resultado = 0.0;
                }

                return resultado;
            },
            /*calcularTotal: function(){
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)
                }
                return resultado;
            },*/
            calcularTotalSubtotales: function(){
                var resultado=0.0;
                var iva_indivi = 0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    iva_indivi = 0.0;
                    if(this.regimen_tercero!='Simplificado')
                    {
                        if(this.iva_incluido==true || this.iva_incluido==1)
                        {
                            resultado=resultado+ ( this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)/((this.arrayDetalle[i].porcentaje/100)+1);
                        }
                        else
                        {
                            resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)
                        }
                    }
                    else
                    {
                        resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)
                    }
                }

                resultado = Math.round(resultado);
                return resultado;
            },
            calcularTotalIva: function(){
                var resultado=0.0;
                var iva_indivi = 0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.regimen_tercero!='Simplificado')
                    {
                        if(this.iva_incluido==true)
                        {
                            iva_indivi = Math.round((this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)-((this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)/((this.arrayDetalle[i].porcentaje/100)+1)));
                        }
                        else
                        {
                            iva_indivi = Math.round((this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)*(this.arrayDetalle[i].porcentaje/100));
                        }
                    }
                    else{iva_indivi = 0;}

                    resultado=resultado+iva_indivi;
                }
                return resultado;
            }
        },
        methods : {
            retornariva(){
                console.log(this.arrayDetalle);
                console.log(this.total_iva);
            },
            listarEgreso(page,buscar,criterio){
                let me=this;
                var url= this.ruta +'/egreso?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayEgreso = respuesta.egresos.data;
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
                var url=  this.ruta +'/evidencias_egresos/listarEvidencias?page='+page+'&id='+id;
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
                        if (me.arrayArticulo[0]['productos_asociados'].length>0){
                            me.buscarA = me.arrayArticulo[0]['codigo'];
                            me.abrirModal();
                        }
                        else {
                            var p = '';
                            if(me.arrayArticulo[0]['padre']!='')
                            {
                                p = ' - (Presentacion asociada: '+me.arrayArticulo[0]['nom_presentacion']+')';
                            }
                            else
                            {
                                p = ' - '+me.arrayArticulo[0]['nom_presentacion'];
                            }
                            me.articulo=me.arrayArticulo[0]['codigo']+' - '+me.arrayArticulo[0]['nombre']+p;
                            me.idarticulo=me.arrayArticulo[0]['id'];
                            me.precio = 1;
                            me.cantidad = 1;
                            for(var i=0; i<me.arrayArticulo[0]['productos_iva'].length; i++)
                            { 
                                if(me.arrayArticulo[0]['productos_iva'][i]['tipo_iva']=='Compra')
                                {
                                    me.porcentaje = me.arrayArticulo[0]['productos_iva'][i]['porcentaje'];
                                }
                            }
                            // me.porcentaje = me.arrayArticulo[0]['porcentaje'];
                            me.precio_parcial = 1;
                            // me.cantidad=me.arrayArticulo[0]['stock'];
                        }
                    }
                    else{
                        me.articulo='No existe artículo';
                        me.idarticulo=0;
                        me.precio = 0;
                        me.cantidad = 0;
                        me.precio_parcial = 0;
                        me.porcentaje = 0;
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
                    me.arrayFuentes = respuesta.fuentes2;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectDetalleEgreso(id){ 
                let me=this;
                var url= this.ruta +'/detalle_egreso/selectDetalleEgreso?id='+id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalle_egreso;
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
            selectCategoria2(){
                let me=this;
                var url= this.ruta + '/categoria/selectCategoria';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayCategoria2 = respuesta.categorias;
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
                me.listarEgreso(page,buscar,criterio);
            },
            cambiarPaginaEvidencias(page,id_egreso){
                let me = this;
                //Actualiza la página actual
                me.pagination_evidencias.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarEvidencias(page,me.egreso_id);
            },
            encuentra(id,presentacion){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].id==id && this.arrayDetalle[i].id_presentacion==presentacion){
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
                    if(me.encuentra(me.idarticulo, me.id_presentacion)){
                        Swal.fire({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese artículo ya se encuentra agregado!',
                            })
                    }
                    else{
                        if(!me.saldo_parcial)
                        {
                            me.arrayDetalle.push({
                                idarticulo: me.idarticulo,
                                articulo: me.articulo,
                                cantidad: me.cantidad,
                                precio: parseFloat(me.precio),
                                porcentaje : me.porcentaje,
                                iva_individual : 0,
                                subtotal : 0,
                                nom_presentacion : me.nom_presentacion,
                                padre : me.padreDetalle
                            });
                        }
                        else
                        {
                            me.arrayDetalle.push({
                                idarticulo: me.idarticulo,
                                articulo: me.articulo,
                                cantidad: me.cantidad,
                                precio: parseFloat(me.precio_parcial)/parseFloat(me.cantidad),
                                porcentaje : me.porcentaje,
                                iva_individual : 0,
                                subtotal : 0,
                                nom_presentacion : me.nom_presentacion,
                                padre : me.padreDetalle
                            });
                        }

                        me.codigo="";
                        me.idarticulo=0;
                        me.articulo="";
                        me.cantidad=0;
                        me.precio=0;
                        me.precio_parcial=0;
                    }
                    
                }
            },
            agregarDetalleModal(data =[]){
                let me=this;
                if(me.encuentra(data['id'], data['id_presentacion'])){
                    Swal.fire({
                        type: 'error',
                        title: 'Error...',
                        text: 'Ese artículo ya se encuentra agregado!',
                        })
                }
                else{
                    // me.codigo = data['codigo'];
                    // me.articulo = data['codigo']+' - '+data['nombre'];
                    // me.idarticulo = data['id'];
                    // me.porcentaje = data['porcentaje'];
                    // me.precio = 1;
                    // me.cantidad = 1;
                    // me.precio_parcial = 1;
                    // me.iva_individual = 0;
                    // me.nom_presentacion = data['nom_presentacion'];
                    // me.padre = data['padre'];
                    var p = '';
                    if(data['padre']!='')
                    {
                        p = ' - (Presentacion asociada: '+data['nom_presentacion']+')';
                    }
                    else
                    {
                        p = ' - '+data['nom_presentacion'];
                    }
                    var ivaCompra = 0;
                    data['productos_iva'].forEach(function(iva){
                        if(iva['tipo_iva']=='Devoluciones compra'){ivaCompra=iva['porcentaje'];}
                    });

                    var pre=0;
                    if(data['saldo_parcial']==true){pre=parseFloat(data['prec'])/parseFloat(data['cant']);}
                    else{pre=data['prec'];}
                    me.arrayDetalle.push({
                        idarticulo: data['id'],
                        articulo: data['codigo']+' - '+data['nombre']+p,
                        porcentaje : ivaCompra,
                        cantidad: data['cant'],
                        precio: pre,
                        precio_venta: data['precio_venta'],
                        iva_individual : ivaCompra,
                        nom_presentacion : data['nom_presentacion'],
                        padre : data['padre'],
                        unidades : data['unidades'],
                    });
                    // me.cerrarModal();
                }
            },
            agregarDetalleModalCantidadArticulo(){
                let me=this;
                
                if(me.encuentra(me.arrayInfoArticuloModalCantidad.id && me.arrayInfoArticuloModalCantidad.id_presentacion)){
                    Swal.fire({
                        type: 'error',
                        title: 'Error...',
                        text: 'Ese artículo ya se encuentra agregado!',
                        })
                }
                else{
                    var p = ''
                    if(me.arrayInfoArticuloModalCantidad.padre!='')
                    {
                        p = ' - (Presentacion asociada: '+me.arrayInfoArticuloModalCantidad.padre+')';
                    }
                    else
                    {
                        p = ' - '+me.arrayInfoArticuloModalCantidad.padre;
                    }
                    
                    var ivaCompra = 0;
                    me.arrayInfoArticuloModalCantidad.productos_iva.forEach(function(iva){
                        if(iva['tipo_iva']=='Devoluciones compra'){ivaCompra=iva['porcentaje'];}
                    });

                    var pre=0;
                    if(me.saldoParcialCantidadArticulo==true){pre=parseFloat(me.precioArticulo)/parseFloat(me.cantidadArticulo);}
                    else{pre=me.precioArticulo;}
                    me.arrayDetalle.push({
                        idarticulo: me.arrayInfoArticuloModalCantidad.id,
                        articulo: me.arrayInfoArticuloModalCantidad.codigo+' - '+me.arrayInfoArticuloModalCantidad.nombre+p,
                        porcentaje : ivaCompra,
                        cantidad: me.cantidadArticulo,
                        precio: pre,
                        precio_venta : me.arrayInfoArticuloModalCantidad.precio_venta,
                        iva_individual: ivaCompra,
                        nom_presentacion : me.arrayInfoArticuloModalCantidad.nom_presentacion,
                        padre : me.arrayInfoArticuloModalCantidad.padre,
                        unidades : me.arrayInfoArticuloModalCantidad.unidades,
                    }); 
                }
                me.cerrarModalCantidadArticulo();
            },
            listarArticulo (buscar,criterio,categoria){
                let me=this;
                // var url= this.ruta +'/articulo/listarArticulo?buscar='+ buscar + '&criterio='+ criterio;
                var var_categoria='';
                if(categoria && categoria!=''){var_categoria='&categoria='+categoria;}
                var url= this.ruta +'/articulo/listarArticulo?buscar='+ buscar + '&criterio='+ criterio+var_categoria;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarEgreso(){
                if (this.validarEgreso()){
                    return;
                }
                
                let me = this;
                me.tipo_comprobante = null;
                me.serie_comprobante = null;
                me.num_comprobante = null;
                me.impuesto = null;

                axios.post(this.ruta +'/egreso/registrar',{
                    'idproveedor': this.id_tercero,
                    'regimen_proveedor' : this.regimen_tercero,
                    'tipo_comprobante': this.tipo_comprobante,
                    'serie_comprobante' : this.serie_comprobante,
                    'num_comprobante' : this.num_comprobante,
                    'tipo_egreso' : this.tipo_egreso,
                    'impuesto' : this.impuesto,
                    'total' : this.total,
                    'forma_pago' : this.forma_pago,
                    'flete' : this.flete,
                    'fecha_egreso' : this.fecha_egreso,
                    'detalle' : this.detalle_egreso,
                    'data': this.arrayDetalle,
                    'tipo_movimiento' : 2,
                    'saldo_parcial' : this.saldo_parcial,
                    'iva_incluido' : this.iva_incluido,
                    'valor_iva' : this.total_iva,
                    'sumatoria' : 0
                }).then(function (response) {
                    me.listado=1;
                    me.listarEgreso(1,'','num_comprobante');
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
                    me.tipo_egreso = 0,
                    me.arrayTerceros=[];
                    me.tipo_movimiento = '';
                    me.saldo_parcial = '';
                    me.iva_incluido = '';
                    me.tipoAccion = 0;
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarEgreso(){
                if (this.validarEgreso()){
                    return;
                }
                
                let me = this;
                me.tipo_comprobante = null;
                me.serie_comprobante = null;
                me.num_comprobante = null;
                me.impuesto = null;

                axios.put( this.ruta + '/egreso/actualizar',{
                    'idproveedor': this.id_tercero,
                    'regimen_proveedor' : this.regimen_tercero,
                    'tipo_comprobante': this.tipo_comprobante,
                    'serie_comprobante' : this.serie_comprobante,
                    'num_comprobante' : this.num_comprobante,
                    'tipo_egreso' : this.tipo_egreso,
                    'impuesto' : this.impuesto,
                    'total' : this.total,
                    'forma_pago' : this.forma_pago,
                    'flete' : this.flete,
                    'fecha_egreso' : this.fecha_egreso,
                    'detalle' : this.detalle_egreso,
                    'data': this.arrayDetalle,
                    'tipo_movimiento' : 2,
                    'saldo_parcial' : this.saldo_parcial,
                    'iva_incluido' : this.iva_incluido,
                    'valor_iva' : this.total_iva,
                    'sumatoria' : 0,
                    'id': this.egreso_id
                }).then(function (response) {
                    me.listado=1;
                    me.listarEgreso(1,'','num_comprobante');
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
                    me.tipo_egreso = 0,
                    me.arrayTerceros=[];
                    me.tipo_movimiento = '';
                    me.saldo_parcial = '';
                    me.iva_incluido = '';
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            validarEgreso(){
                this.errorEgreso=0;
                this.errorMostrarMsjEgreso =[];

                if (this.id_tercero==0 || this.id_tercero=='') this.errorMostrarMsjEgreso.push("Seleccione un Proveedor");
                if (this.tipo_egreso==0 || this.tipo_egreso=='') this.errorMostrarMsjEgreso.push("Seleccione el tipo de egreso");
                if (this.forma_pago==0) this.errorMostrarMsjEgreso.push("Seleccione una fuente");
                if (this.fecha_egreso=='') this.errorMostrarMsjEgreso.push("Ingrese la fecha de egreso");
                if (this.arrayDetalle.length<=0) this.errorMostrarMsjEgreso.push("Agregue detalles");

                if (this.errorMostrarMsjEgreso.length) this.errorEgreso = 1;

                return this.errorEgreso;
            },
            mostrarDetalle(){
                let me=this;
                me.listado=0;
                me.tipoAccion=1;
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
                me.precio_parcial=0;
                me.arrayDetalle=[];
                me.arrayFuentes=[];
                me.saldo_parcial = '';
                me.iva_incluido = 1;

                me.selectFuentes();
                me.selectTipoFormato();
            },
            ocultarDetalle(){
                let me=this;
                me.listado=1;
                me.tipoAccion=0;
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
                me.errorEgreso = 0;
                me.errorMostrarMsjEgreso = [];
                me.tipo_egreso = 0;
            },
            verEgreso(id){
                let me=this;
                me.listado=2;
                
                //Obtener los datos del egreso
                var arrayEgresoT=[];
                var url= this.ruta +'/egreso/obtenerCabecera?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayEgresoT = respuesta.egreso;

                    me.proveedor = arrayEgresoT[0]['nombre'];
                    me.tipo_comprobante=arrayEgresoT[0]['tipo_comprobante'];
                    me.serie_comprobante=arrayEgresoT[0]['serie_comprobante'];
                    me.num_comprobante=arrayEgresoT[0]['num_comprobante'];
                    me.regimen_tercero = arrayEgresoT[0]['regimen'];
                    me.total=arrayEgresoT[0]['total'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles 
                var urld= this.ruta +'/egreso/obtenerDetalles?id=' + id;
                
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
                this.arrayArticulo = [];
                this.cantidadArticulo = 0;
                this.precioArticulo = 0;
                this.buscarA = '';
                this.criterioA = '';
                this.buscarCategoriaA = 0;
            }, 
            abrirModal(){               
                this.arrayArticulo=[];
                this.modal = 1;
                this.tituloModal = 'Seleccione uno o varios artículos';
                this.selectCategoria2();
                this.listarArticulo(this.buscarA,this.criterioA,this.buscarCategoriaA)
            },
            cerrarModal3(){
                this.modal3=0;
                this.tituloModal3='';
                this.tipoAccion3=0;
                this.evidencia='';
                this.observacionEvidencia='';
                this.link='';
                this.egreso_id=0;
                this.tipoAccion3=0;
                this.arrayEvidencias = [];
                this.pagination_evidencias = [];
            }, 
            abrirModal3(accion,data){

                switch(accion){
                    case 'ver':{
                        this.modal3 = 1;
                        this.tituloModal3 = 'Evidencias';
                        this.egreso_id = data['id'];
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

                axios.post( this.ruta +'/evidencias_egresos/registrar',{
                    'id_egreso' : this.egreso_id,
                    'nombre': this.evidencia,
                    'observacion' : this.observacionEvidencia,
                    'link' : this.link,
                }).then(function (response) {
                    me.tipoAccion3=0;
                    me.listarEvidencias(1,me.egreso_id);
                }).catch(function (error) {
                    console.log(error); 
                });
            },
            eliminarEvidencia(id){
                let me = this;

                axios.put( this.ruta +'/evidencias_egresos/eliminarEvidencia',{
                    'id': id,
                }).then(function (response) {
                    me.listarEvidencias(1,me.egreso_id);
                }).catch(function (error) {
                    console.log(error); 
                });
            },
            desactivarEgreso(id){
               Swal.fire({
                title: 'Esta seguro de anular este egreso?',
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

                    axios.put(this.ruta +'/egreso/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarEgreso(1,'','num_comprobante');
                        Swal.fire(
                        'Anulado!',
                        'El egreso ha sido anulado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            cerrarEgreso(data){
                
                Swal.fire({
                title: 'Cerrar egreso?',
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

                    axios.put(this.ruta +'/egreso/cerrar',{
                        'tipo_egreso' : this.tipo_egreso,
                        'tipo_formato': data['forma_pago'],
                        'tercero': data['idproveedor'],
                        'fecha': data['fecha_egreso'],
                        'detalle': data['detalle'],
                        'vr_impuesto': data['valor_iva'],
                        'total': data['total'],
                        'id' : data['id'],
                        'tipo_egreso' : data['tipo_egreso'],
                        'data': data,
                    }).then(function (response) {
                        me.listarEgreso(1,'','num_comprobante');
                        Swal.fire(
                        'Cerrado!',
                        'El egreso ha sido cerrado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    
                }
                })
            },

            cerrarModalCantidadArticulo(){
                this.modalCantidadArticulo=0;
                this.tituloModalCantidadArticulo='';
                this.cantidadArticulo = 0;
                this.stockCantidadArticulo = 0;
                this.saldoParcialCantidadArticulo = false;
                this.arrayInfoArticuloModalCantidad = [];
            }, 
            abrirModalCantidadArticulo(data){               
                this.modalCantidadArticulo = 1;
                this.tituloModalCantidadArticulo = 'Cantidad del articulo';
                this.arrayInfoArticuloModalCantidad = data;
                this.stockCantidadArticulo = data['stock']
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
                this.regimen_tercero = tercero['regimen'];
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
            },
            abrirModalActualizarEgreso(data=[]){
                this.listado = 0;
                this.tipoAccion=2;
                this.selectFuentes();
                this.selectTipoFormato();
                this.selectDetalleEgreso(data['id']);

                this.egreso_id = data['id'];
                this.id_tercero = data['idproveedor'];
                this.tercero = data['num_documento']+' - '+data['nombre1']+' '+data['apellido1'];
                this.regimen_tercero = data['regimen'];
                this.tipo_egreso = data['tipo_egreso'];
                this.forma_pago = data['forma_pago'];
                this.fecha_egreso = data['fecha_egreso'];
                this.detalle_egreso = data['detalle'];
                this.saldo_parcial = data['saldo_parcial'];
                this.iva_incluido = data['iva_incluido'];
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
            me.fecha_egreso= d;

            this.listarEgreso(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
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
    .mosaico{
        display: inline-block;
        float: left;
    }
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
