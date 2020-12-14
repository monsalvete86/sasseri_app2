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
                        <i class="fa fa-align-justify"></i> Modelos Contables
                        <button v-if="permisosUser.crear" type="button" @click="abrirModal('modelo_contable','registrar')" class="btn btn-primary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                        <button v-else type="button" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <!--<select v-if="permisosUser.leer" class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <select v-else disabled class="form-control col-md-3" v-model="criterio">
                                    </select>-->

                                    <input v-if="permisosUser.leer" type="text" v-model="buscar" @keyup="listarModeloContable(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <input v-else disabled type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar">
                                    
                                    <!--<button v-if="permisosUser.leer" type="submit" @click="listarModeloContable(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    <button v-else type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> Buscar</button>-->
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="col-md-4">Nombre</th>
                                    <th>Descripción</th>
                                    <th class="col-md-1">Estado</th>
                                    <th class="col-md-1">Opciones</th>
                                </tr>
                            </thead>
                            <tbody v-if="permisosUser.leer && arrayModeloContable.length">
                                <tr v-for="modelo_contable in arrayModeloContable" :key="modelo_contable.id">
                                    <td v-text="modelo_contable.nombre"></td>
                                    <td v-text="modelo_contable.descripcion"></td>
                                    <td>
                                        <div v-if="modelo_contable.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                    </td>
                                    <td>
                                        <button v-if="permisosUser.actualizar && modelo_contable.condicion" type="button" @click="abrirModal('modelo_contable','actualizar',modelo_contable)" class="btn btn-warning btn-sm" title="Actualizar">
                                          <i class="icon-pencil"></i>
                                        </button>
                                        <button v-else type="button" class="btn btn-secondary btn-sm" title="Actualizar (Deshabilitado)">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;

                                        <template v-if="permisosUser.anular">
                                            <button v-if="modelo_contable.condicion" type="button" class="btn btn-danger btn-sm" @click="desactivarModeloContable(modelo_contable.id)" title="Desactivar">
                                                <i class="icon-trash"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-info btn-sm" @click="activarModeloContable(modelo_contable.id)" title="Activar">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button v-if="modelo_contable.condicion" type="button" class="btn btn-secondary btn-sm" title="Desactivar (Deshabilitado)">
                                                <i class="icon-trash"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-secondary btn-sm" title="Activar (Deshabilitado)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                </tr>                                
                            </tbody>
                            <tbody v-else>
                                <tr><td colspan="4">NO hay registros para mostrar</td></tr>
                            </tbody>
                        </table>
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
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content" style="width: 1100px !important;margin-left: -10%;">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true" title="Cerrar">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label class="col-md-1 form-control-label float-left" for="text-input">Nombre</label>
                                        <div class="col-md-11 float-right">
                                            <input type="text" v-model="nombre" class="form-control float-right" placeholder="Nombre del modelo contable" v-bind:class="{ 'is-invalid' : hasError.nombre==1}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label class="col-md-1 form-control-label float-left" for="email-input">Descripción</label>
                                        <div class="col-md-11 float-right">
                                            <textarea v-model="descripcion" class="form-control float-right"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left">Cuenta compra <span style="color:red;" v-show="idCuentaProductos==''">(*)</span></label>
                                        <div class="form-inline col-md-9 float-right">
                                            <input type="text" readonly class="form-control" style="width: 85%;" v-model="cuentaProductos" v-bind:class="{ 'is-invalid' : hasError.idCuentaProductos==1}">
                                            <button type="button" @click="abrirModalCuentas('productos')" title="Agragar cuenta" class="btn btn-primary">...</button>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left">Cuenta Salida <span style="color:red;" v-show="idCuentaSalidaProductos==''">(*)</span></label>
                                        <div class="form-inline col-md-9 float-right">
                                            <input type="text" readonly class="form-control" style="width: 85%;" v-model="cuentaSalidaProductos"v-bind:class="{ 'is-invalid' : hasError.idCuentaSalidaProductos==1}">
                                            <button type="button" @click="abrirModalCuentas('salida_productos')" title="Agragar cuenta" class="btn btn-primary">...</button>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left">Saldos iniciales <span style="color:red;" v-show="idCuentaSaldosIniciales==''">(*)</span></label>
                                        <div class="form-inline col-md-9 float-right">
                                            <input type="text" readonly class="form-control" style="width: 85%;" v-model="cuentaSaldosIniciales" v-bind:class="{ 'is-invalid' : hasError.idCuentaSaldosIniciales==1}">
                                            <button type="button" @click="abrirModalCuentas('saldos_iniciales')" title="Agragar cuenta" class="btn btn-primary">...</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left">Cuenta Donaciones <span style="color:red;" v-show="idCuentaDonaciones==''">(*)</span></label>
                                        <div class="form-inline col-md-9 float-right">
                                            <input type="text" readonly class="form-control" style="width: 85%;" v-model="cuentaDonaciones" v-bind:class="{ 'is-invalid' : hasError.idCuentaDonaciones==1}">
                                            <button type="button" @click="abrirModalCuentas('donaciones')" title="Agragar cuenta" class="btn btn-primary">...</button>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left">Cuenta devoluciones ventas <span style="color:red;" v-show="idCuentaDevolucionesVentas==''">(*)</span></label>
                                        <div class="form-inline col-md-9 float-right">
                                            <input type="text" readonly class="form-control" style="width: 85%;" v-model="cuentaDevolucionesVentas" v-bind:class="{ 'is-invalid' : hasError.idCuentaDevolucionesVentas==1}">
                                            <button type="button" @click="abrirModalCuentas('devoluciones_ventas')" title="Agragar cuenta" class="btn btn-primary">...</button>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left">Cuenta devoluciones compras <span style="color:red;" v-show="idCuentaDevolucionesCompras==''">(*)</span></label>
                                        <div class="form-inline col-md-9 float-right">
                                            <input type="text" readonly class="form-control" style="width: 85%;" v-model="cuentaDevolucionesCompras" v-bind:class="{ 'is-invalid' : hasError.idCuentaDevolucionesCompras==1}">
                                            <button type="button" @click="abrirModalCuentas('devoluciones_compras')" title="Agragar cuenta" class="btn btn-primary">...</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left">Cuenta impuesto al consumo en ventas <span style="color:red;" v-show="idCuentaImpuestoConsumoVentas==''">(*)</span></label>
                                        <div class="form-inline col-md-9 float-right">
                                            <input type="text" readonly class="form-control" style="width: 85%;" v-model="cuentaImpuestoConsumoVentas" v-bind:class="{ 'is-invalid' : hasError.idCuentaImpuestoConsumoVentas==1}">
                                            <button type="button" @click="abrirModalCuentas('impuesto_consumo_ventas')" title="Agragar cuenta" class="btn btn-primary">...</button>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left">Iva Compras<span style="color:red;" v-show="idIvaCompras==0">(*)</span></label>
                                        <div class="col-md-9 float-right">
                                            <select class="form-control" v-model="idIvaCompras" v-bind:class="{ 'is-invalid' : hasError.idIvaCompras==1}">
                                                <option value="0">Seleccione</option>
                                                <option v-for="(iva, index) in arrayIvasCompras" :value="iva.id" v-text="iva.nombre"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left">Iva Ventas<span style="color:red;" v-show="idIvaVentas==0">(*)</span></label>
                                        <div class="col-md-9 float-right">
                                            <select class="form-control" v-model="idIvaVentas" v-bind:class="{ 'is-invalid' : hasError.idIvaVentas==1}">
                                                <option value="0">Seleccione</option>
                                                <option v-for="(iva, index) in arrayIvasVentas" :value="iva.id" v-text="iva.nombre"></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left">Iva Devolucion En Compras<span style="color:red;" v-show="idIvaDevolucionCompras==0">(*)</span></label>
                                        <div class="col-md-9 float-right">
                                            <select class="form-control" v-model="idIvaDevolucionCompras" v-bind:class="{ 'is-invalid' : hasError.idIvaDevolucionCompras==1}">
                                                <option value="0">Seleccione</option>
                                                <option v-for="(iva, index) in arrayIvasDevolucionCompras" :value="iva.id" v-text="iva.nombre"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left">Iva Devolucion En Ventas<span style="color:red;" v-show="idIvaDevolucionVentas==0">(*)</span></label>
                                        <div class="col-md-9 float-right">
                                            <select class="form-control" v-model="idIvaDevolucionVentas" v-bind:class="{ 'is-invalid' : hasError.idIvaDevolucionVentas==1}">
                                                <option value="0">Seleccione</option>
                                                <option v-for="(iva, index) in arrayIvasDevolucionVentas" :value="iva.id" v-text="iva.nombre"></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--<div v-show="errorModeloContable" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjModeloContable" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>-->

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarModeloContable()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-success" @click="actualizarModeloContable()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

            <!-- Modal busqueda cuentas-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal2}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal2"></h4>
                            <button type="button" class="close" @click="cerrarModalCuentas()" aria-label="Close">
                                <span aria-hidden="true" title="Cerrar">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div style="max-width: 120px !important;" class="col-md-2   ">
                                    <label style='margin-top: 3px; '><b>Cuenta</b></label>                                
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="cta_busq" v-model="cta_busq" @keyup="buscarCuentaB()" placeholder="Ingrese el nombre o el código de la cuenta">
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    
                                        <tr><th>Codigo</th><th>Cuenta</th><th>-</th></tr>
                                    
                                        <tr v-for="cuentas in arrayCuentasBusq" :key="cuentas.id">
                                            <td v-text="cuentas.codigo"></td>
                                            <td v-text="cuentas.nombre"></td>
                                            <td>
                                                <button type="button" style=" margin-right: -8px;" @click="cargarCuentaB(cuentas, tipoCuenta)" class="btn btn-success btn-sm" title='Ver formato'>
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
            <!--Fin del modal-->
        </main>
</template>

<script>
    export default {
        props : ['ruta','permisosUser'],
        data (){
            return {
                modelo_contable_id: 0,
                nombre : '',
                descripcion : '',
                arrayModeloContable : [],
                idIvaCompras : 0,
                idIvaVentas : 0,
                idIvaDevolucionCompras : 0,
                idIvaDevolucionVentas : 0,
                arrayIvasCompras : [],
                arrayIvasVentas : [],
                arrayIvasDevolucionCompras : [],
                arrayIvasDevolucionVentas : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorModeloContable : 0,
                errorMostrarMsjModeloContable : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 10,
                criterio : 'nombre',
                buscar : '',

                // variables modal de cuentas
                modal2 : 0,
                tituloModal2 : '',
                tipoCuenta : '',
                cta_busq : '',
                arrayCuentasBusq : [],

                // variables de cuentas de producto, salida de productos, saldos iniciales y donaciones
                idCuentaProductos: 0,
                cuentaProductos : '',
                codCuentaProductos : '',

                idCuentaSalidaProductos: 0,
                cuentaSalidaProductos: '',
                codCuentaSalidaProductos: '',

                idCuentaSaldosIniciales: 0,
                cuentaSaldosIniciales: '',
                codCuentaSaldosIniciales: '',

                idCuentaDonaciones: 0,
                cuentaDonaciones: '',
                codCuentaDonaciones: '',

                idCuentaDevolucionesVentas: 0,
                cuentaDevolucionesVentas: '',
                codCuentaDevolucionesVentas: '',

                idCuentaDevolucionesCompras: 0,
                cuentaDevolucionesCompras: '',
                codCuentaDevolucionesCompras: '',

                idCuentaImpuestoConsumoVentas: 0,
                cuentaImpuestoConsumoVentas: '',
                codCuentaImpuestoConsumoVentas: '',

                hasError : {
                    nombre : 0,
                    descripcion : 0,
                    idIvaCompras : 0,
                    idIvaVentas : 0,
                    idIvaDevolucionCompras : 0,
                    idIvaDevolucionVentas : 0,
                    idCuentaProductos : 0,
                    idCuentaSalidaProductos : 0,
                    idCuentaSaldosIniciales : 0,
                    idCuentaDonaciones : 0,
                    idCuentaDevolucionesVentas : 0,
                    idCuentaDevolucionesCompras : 0,
                    idCuentaImpuestoConsumoVentas : 0,
                }
            }
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

            }
        },
        methods : {
            listarModeloContable (page,buscar,criterio){
                let me=this;
                var url= this.ruta +'/modelo_contable?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayModeloContable = respuesta.modelo_contable.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarIvas(page,buscar,criterio){
                let me=this;
                var url= this.ruta +'/iva?buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayIvasCompras = respuesta.ivaCompra;
                    me.arrayIvasVentas = respuesta.ivaVenta;
                    me.arrayIvasDevolucionCompras = respuesta.ivaDevolucionCompra;
                    me.arrayIvasDevolucionVentas = respuesta.ivaDevolucionVenta;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarModeloContable(page,buscar,criterio);
            },
            registrarModeloContable(){
                if (this.validarModeloContable()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/modelo_contable/registrar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'idIvaCompras': this.idIvaCompras,
                    'idIvaVentas': this.idIvaVentas,
                    'idIvaDevolucionCompras': this.idIvaDevolucionCompras,
                    'idIvaDevolucionVentas': this.idIvaDevolucionVentas,
                    'idCuentaProductos': this.idCuentaProductos,
                    'idCuentaSalidaProductos': this.idCuentaSalidaProductos,
                    'idCuentaSaldosIniciales': this.idCuentaSaldosIniciales,
                    'idCuentaDonaciones': this.idCuentaDonaciones,
                    'idCuentaDevolucionesVentas': this.idCuentaDevolucionesVentas,
                    'idCuentaDevolucionesCompras': this.idCuentaDevolucionesCompras,
                    'idCuentaImpuestoConsumoVentas': this.idCuentaImpuestoConsumoVentas,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarModeloContable(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarModeloContable(){
               if (this.validarModeloContable()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta +'/modelo_contable/actualizar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'idIvaCompras': this.idIvaCompras,
                    'idIvaVentas': this.idIvaVentas,
                    'idIvaDevolucionCompras': this.idIvaDevolucionCompras,
                    'idIvaDevolucionVentas': this.idIvaDevolucionVentas,
                    'idCuentaProductos': this.idCuentaProductos,
                    'idCuentaSalidaProductos': this.idCuentaSalidaProductos,
                    'idCuentaSaldosIniciales': this.idCuentaSaldosIniciales,
                    'idCuentaDonaciones': this.idCuentaDonaciones,
                    'idCuentaDevolucionesVentas': this.idCuentaDevolucionesVentas,
                    'idCuentaDevolucionesCompras': this.idCuentaDevolucionesCompras,
                    'idCuentaImpuestoConsumoVentas': this.idCuentaImpuestoConsumoVentas,
                    'id': this.modelo_contable_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarModeloContable(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarModeloContable(id){
               Swal.fire({
                title: 'Esta seguro de desactivar este modelo contable?',
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

                    axios.put(this.ruta +'/modelo_contable/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarModeloContable(1,'','nombre');
                        Swal.fire(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
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
            activarModeloContable(id){
               Swal.fire({
                title: 'Esta seguro de activar este modelo contable?',
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

                    axios.put(this.ruta +'/modelo_contable/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarModeloContable(1,'','nombre');
                        Swal.fire(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
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
            validarModeloContable(){
                this.hasError['nombre'] = 0;
                this.hasError['descripcion'] = 0;
                this.hasError['idIvaCompras'] = 0;
                this.hasError['idIvaVentas'] = 0;
                this.hasError['idIvaDevolucionCompras'] = 0;
                this.hasError['idIvaDevolucionVentas'] = 0;
                this.hasError['idCuentaProductos'] = 0;
                this.hasError['idCuentaSalidaProductos'] = 0;
                this.hasError['idCuentaSaldosIniciales'] = 0;
                this.hasError['idCuentaDonaciones'] = 0;
                this.hasError['idCuentaDevolucionesVentas'] = 0;
                this.hasError['idCuentaDevolucionesCompras'] = 0;
                this.hasError['idCuentaImpuestoConsumoVentas'] = 0;

                this.errorModeloContable=0;
                this.errorMostrarMsjModeloContable =[];
                var error = 0;

                if(!this.nombre) {error=1; this.hasError['nombre']=1;}
                if(!this.idCuentaProductos || this.idCuentaProductos==0){error=1; this.hasError['idCuentaProductos']=1;}
                if(!this.idCuentaSalidaProductos || this.idCuentaSalidaProductos==0){error=1; this.hasError['idCuentaSalidaProductos']=1;}
                if(!this.idCuentaSaldosIniciales || this.idCuentaSaldosIniciales==0){error=1; this.hasError['idCuentaSaldosIniciales']=1;}
                if(!this.idCuentaDonaciones || this.idCuentaDonaciones==0){error=1; this.hasError['idCuentaDonaciones']=1;}
                if(!this.idCuentaDevolucionesVentas || this.idCuentaDevolucionesVentas==0){error=1; this.hasError['idCuentaDevolucionesVentas']=1;}
                if(!this.idCuentaDevolucionesCompras || this.idCuentaDevolucionesCompras==0){error=1; this.hasError['idCuentaDevolucionesCompras']=1;}
                if(!this.idCuentaImpuestoConsumoVentas || this.idCuentaImpuestoConsumoVentas==0){error=1; this.hasError['idCuentaImpuestoConsumoVentas']=1;}

                if(!this.idIvaCompras || this.idIvaCompras==0){error=1; this.hasError['idIvaCompras']=1;}
                if(!this.idIvaVentas || this.idIvaVentas==0){error=1; this.hasError['idIvaVentas']=1;}
                if(!this.idIvaDevolucionCompras || this.idIvaDevolucionCompras==0){error=1; this.hasError['idIvaDevolucionCompras']=1;}
                if(!this.idIvaDevolucionVentas || this.idIvaDevolucionVentas==0){error=1; this.hasError['idIvaDevolucionVentas']=1;}

                if (error=1) this.errorModeloContable = 1;

                return this.errorModeloContable;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.descripcion='';
                this.idIvaCompras = 0;
                this.idIvaVentas = 0;
                this.idIvaDevolucionCompras = 0;
                this.idIvaDevolucionVentas = 0;
                this.arrayIvas = [];
                this.idCuentaProductos = 0;
                this.cuentaProductos = '';
                this.codCuentaProductos = '';
                this.idCuentaSalidaProductos = 0;
                this.cuentaSalidaProductos = '';
                this.codCuentaSalidaProductos = '';
                this.idCuentaSaldosIniciales = 0;
                this.cuentaSaldosIniciales = '';
                this.codCuentaSaldosIniciales = '';
                this.idCuentaDonaciones = 0;
                this.cuentaDonaciones = '';
                this.codCuentaDonaciones = '';

                this.idCuentaDevolucionesVentas= 0;
                this.cuentaDevolucionesVentas= '';
                this.codCuentaDevolucionesVentas= '';
                this.idCuentaDevolucionesCompras= 0;
                this.cuentaDevolucionesCompras= '';
                this.codCuentaDevolucionesCompras= '';
                this.idCuentaImpuestoConsumoVentas= 0;
                this.cuentaImpuestoConsumoVentas= '';
                this.codCuentaImpuestoConsumoVentas= '';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "modelo_contable":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar modelo contable';
                                this.nombre= '';
                                this.descripcion = '';
                                this.idIvaCompras = 0;
                                this.idIvaVentas = 0;
                                this.idIvaDevolucionCompras = 0;
                                this.idIvaDevolucionVentas = 0;
                                this.arrayIvas = [];
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar modelo contable';
                                this.tipoAccion=2;
                                this.modelo_contable_id=data['id'];
                                this.nombre = data['nombre'];
                                this.descripcion= data['descripcion'];
                                this.idIvaCompras = data['idIvaCompras'];
                                this.idIvaVentas = data['idIvaVentas'];
                                this.idIvaDevolucionCompras = data['idIvaDevolucionCompras'];
                                this.idIvaDevolucionVentas = data['idIvaDevolucionVentas'];

                                this.idCuentaProductos = data['idCuentaProductos'];
                                this.cuentaProductos = data['cuentaProductos'];
                                this.codCuentaProductos = data['codCuentaProductos'];

                                this.idCuentaSalidaProductos = data['idCuentaSalidaProductos'];
                                this.cuentaSalidaProductos = data['cuentaSalidaProductos'];
                                this.codCuentaSalidaProductos = data['codCuentaSalidaProductos'];

                                this.idCuentaSaldosIniciales = data['idCuentaSaldosIniciales'];
                                this.cuentaSaldosIniciales = data['cuentaSaldosIniciales'];
                                this.codCuentaSaldosIniciales = data['codCuentaSaldosIniciales'];

                                this.idCuentaDonaciones = data['idCuentaDonaciones'];
                                this.cuentaDonaciones = data['cuentaDonaciones'];
                                this.codCuentaDonaciones = data['codCuentaDonaciones'];

                                this.idCuentaDevolucionesVentas = data['idCuentaDevolucionesVentas'];
                                this.cuentaDevolucionesVentas = data['cuentaDevolucionesVentas'];
                                this.codCuentaDevolucionesVentas = data['codCuentaDevolucionesVentas'];

                                this.idCuentaDevolucionesCompras = data['idCuentaDevolucionesCompras'];
                                this.cuentaDevolucionesCompras = data['cuentaDevolucionesCompras'];
                                this.codCuentaDevolucionesCompras = data['codCuentaDevolucionesCompras'];

                                this.idCuentaImpuestoConsumoVentas = data['idCuentaImpuestoConsumoVentas'];
                                this.cuentaImpuestoConsumoVentas = data['cuentaImpuestoConsumoVentas'];
                                this.codCuentaImpuestoConsumoVentas = data['codCuentaImpuestoConsumoVentas'];
                                break;
                            }
                        }
                        this.listarIvas(1,'','');
                    }
                }
            },
            cerrarModalCuentas(){
                this.modal2=0;
                this.tituloModal2='';
                this.cta_busq='';
                this.arrayCuentasBusq=[];
                this.tipoCuenta = '';
            },
            abrirModalCuentas(modelo){
                this.modal2 = 1;
                switch(modelo)
                {
                    case 'productos':{
                        this.tituloModal2 = 'Cuenta para productos';
                        this.tipoCuenta = 'productos';
                        break;
                    }
                    case 'salida_productos':{
                        this.tituloModal2 = 'Cuenta de salida de productos';
                        this.tipoCuenta = 'salida_productos';
                        break;
                    }
                    case 'saldos_iniciales':{
                        this.tituloModal2 = 'Cuenta de saldos iniciales';
                        this.tipoCuenta = 'saldos_iniciales';
                        break;
                    }
                    case 'donaciones':{
                        this.tituloModal2 = 'Cuenta para donaciones';
                        this.tipoCuenta = 'donaciones';
                        break;
                    }
                    case 'devoluciones_ventas':{
                        this.tituloModal2 = 'Cuenta para devoluciones en ventas';
                        this.tipoCuenta = 'devoluciones_ventas';
                        break;
                    }
                    case 'devoluciones_compras':{
                        this.tituloModal2 = 'Cuenta para devoluciones en compras';
                        this.tipoCuenta = 'devoluciones_compras';
                        break;
                    }
                    case 'impuesto_consumo_ventas':{
                        this.tituloModal2 = 'Cuenta para impuesto en consumo de ventas';
                        this.tipoCuenta = 'impuesto_consumo_ventas';
                        break;
                    }
                }
            },
            buscarCuentaB(){
                let me=this;            
                var url= this.ruta +'/planCuentas/selectCuentaInfo?busqueda=' + me.cta_busq;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCuentasBusq = respuesta.cuentas;
                })
                .catch(function (error) {
                    console.log(error);
                });

            },
            cargarCuentaB(cuenta, tipoCuenta){
                let me=this;
                switch(tipoCuenta)
                {
                    case 'productos':{
                        me.idCuentaProductos = cuenta['id'];
                        me.cuentaProductos = cuenta['nombre'];
                        me.codCuentaProductos = cuenta['codigo'];
                        break;
                    }
                    case 'salida_productos':{
                        me.idCuentaSalidaProductos = cuenta['id'];
                        me.cuentaSalidaProductos = cuenta['nombre'];
                        me.codCuentaSalidaProductos = cuenta['codigo'];
                        break;
                    }
                    case 'saldos_iniciales':{
                        me.idCuentaSaldosIniciales = cuenta['id'];
                        me.cuentaSaldosIniciales = cuenta['nombre'];
                        me.codCuentaSaldosIniciales = cuenta['codigo'];
                        break;
                    }
                    case 'donaciones':{
                        me.idCuentaDonaciones = cuenta['id'];
                        me.cuentaDonaciones = cuenta['nombre'];
                        me.codCuentaDonaciones = cuenta['codigo'];
                        break;
                    }
                    case 'devoluciones_ventas':{
                        me.idCuentaDevolucionesVentas = cuenta['id'];
                        me.cuentaDevolucionesVentas = cuenta['nombre'];
                        me.codCuentaDevolucionesVentas = cuenta['codigo'];
                        break;
                    }
                    case 'devoluciones_compras':{
                        me.idCuentaDevolucionesCompras = cuenta['id'];
                        me.cuentaDevolucionesCompras = cuenta['nombre'];
                        me.codCuentaDevolucionesCompras = cuenta['codigo'];
                        break;
                    }
                    case 'impuesto_consumo_ventas':{
                        me.idCuentaImpuestoConsumoVentas = cuenta['id'];
                        me.cuentaImpuestoConsumoVentas = cuenta['nombre'];
                        me.codCuentaImpuestoConsumoVentas = cuenta['codigo'];
                        break;
                    }
                }
                me.cerrarModalCuentas();
            },
        },
        mounted() {
            this.listarModeloContable(1,this.buscar,this.criterio);
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
</style>
