<template>
            <main class="main">
            <!-- Breadcrumb -->
            
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Plan Cuentas
                        <button v-if="permisosUser.crear" type="button" @click="abrirModal('planCuentas','registrar')" class="btn btn-primary" title="Nuevo">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>

                        <button v-else type="button" class="btn btn-secondary" title="Nuevo">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select v-if="permisosUser.leer" class="form-control col-md-3" v-model="criterio" @change="listarPlanCuentas(1,buscar,criterio)">
                                      <option value="codigo">Codigo</option>
                                      <option value="nombre">Nombre</option>
                                    </select>

                                    <select v-else disabled class="form-control col-md-3" v-model="criterio" title="Tipo">
                                    </select>
                                    <input v-if="permisosUser.leer" type="text" v-model="buscar" @keyup="listarPlanCuentas(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar" title="Texto a buscar">
                                    <input v-else type="text" disabled v-model="buscar" class="form-control" placeholder="Texto a buscar" title="Texto a buscar">

                                    <!--<button v-if="permisosUser.leer" type="submit" @click="listarPlanCuentas(1,buscar,criterio)" class="btn btn-primary" title="Buscar"><i class="fa fa-search"></i> Buscar</button>
                                    <button v-else type="button" class="btn btn-secondary" title="Buscar"><i class="fa fa-search"></i> Buscar</button>-->
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm  table-responsive">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Nombre</th>                                   
                                    <th>Estado</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <tbody v-if="permisosUser.leer && arrayPlanCuentas.length">
                                <tr v-for="cuenta in arrayPlanCuentas" :key="cuenta.id">
                                    <td v-text="cuenta.codigo"></td>
                                    <td v-text="cuenta.nombre"></td>
                                    <td>
                                        <div v-if="cuenta.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Inactivo</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <button v-if="permisosUser.actualizar" type="button" @click="abrirModal('planCuentas','actualizar',cuenta)" class="btn btn-warning btn-sm" title="Actualizar">
                                          <i class="icon-pencil"></i>
                                        </button>
                                        
                                        <button v-else type="button" class="btn btn-secondary btn-sm" title="Actualizar (Deshabilitado)">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;                                        
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr colspan="4"><span>No hay registros para mostrar</span></tr>
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
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Detalles Cuenta</h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true" title="Cerrar">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="text-input">NIIF</label>
                                    <div class="col-md-2">
                                        <input type="text" v-model="codigo" class="form-control" placeholder="Codigo">
                                        
                                    </div>
                                
                                    <label class="col-md-2 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-6">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre Cuenta">                                       
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-2 form-control-label" for="text-input">Año</label>
                                    <div class="col-md-2">
                                        <input type="number" v-model="anio" min='2015' max="2025" class="form-control" placeholder="Año">
                                    </div>

                                    <label class="col-md-2 form-control-label" for="text-input">PUC Fiscal</label>
                                    <div class="col-md-6">
                                        <input type="text" v-model="niif" class="form-control" placeholder="NIIF">
                                    </div>                           
                                    
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="text-input">naturaleza</label>
                                    <div class="col-md-4">
                                        
                                        <select v-model="naturaleza" class="form-control" placeholder="Naturaleza">
                                            <option value="Credito">Credito</option>
                                            <option value="Debito">Debito</option>
                                        </select>
                                    </div>
                                
                                    <label class="col-md-2 form-control-label" for="text-input">Tipo</label>
                                    <div class="col-md-4">
                                        <select v-model="tipo" class="form-control" placeholder="Tipo">
                                            <option value="Detalle">Detalle</option>
                                            <option value="Titulo">Titulo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <!--<label class="col-md-2 form-control-label" for="text-input">corriente</label>
                                    <div class="col-md-1">                                        
                                        <input type="checkbox" v-model="corriente" class="form-control">
                                    </div>
                                -->
                                    <label class="col-md-2 form-control-label" for="text-input">Banco</label>
                                     <div class="col-md-1">                                        
                                        <input type="checkbox" v-model="banco" class="form-control">
                                    </div>        
                                    <label class="col-md-2 form-control-label" for="text-input">Tercero</label>
                                    <div class="col-md-1">                                        
                                        <input type="checkbox" v-model="tercero" class="form-control">
                                    </div>
                                    <label class="col-md-2 form-control-label" for="text-input">Estado</label>
                                    <div class="col-md-2">
                                        <select v-model="condicion" class="form-control" placeholder="Estado">
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="text-input">Evitar saldo negativo</label>
                                    <div class="col-md-1">                                        
                                        <input type="checkbox" v-model="evitar_saldo_negativo" class="form-control">
                                    </div>
                                    <label v-if="verificar_ini_cuenta" class="col-md-2 form-control-label" for="text-input">Orden</label>
                                    <div v-if="verificar_ini_cuenta" class="col-md-2">
                                        <select class="form-control" id="orden" v-model="orden">
                                            <option value="">N/A</option>
                                            <option value="corriente">Corriente</option>
                                            <option value="corriente">No Corriente</option>
                                            <option value="corriente">Otros</option>
                                            <option value="corriente">Control</option>
                                            <option value="corriente">Orden Acreedor</option>
                                            <option value="corriente">Orden Deudor</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label">Cuenta de cierre <span style="color:red;" v-show="id_cuenta_cierre==''">(*Seleccione)</span></label>
                                    <div class="form-inline col-md-4">
                                        <input type="text" readonly class="form-control" v-model="cuenta_cierre">
                                        <button type="button" @click="abrirModal('planCuentas','buscar')" class="btn btn-primary">...</button>
                                    </div>

                                    
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="text-input">Tercero cierre</label>
                                    <div class="form-inline col-md-4">
                                        <input type="text" readonly class="form-control" v-model="tercero">
                                        <button type="button" @click="abrirModal('planCuentas','tercero')" class="btn btn-primary">...</button>
                                        <button type="button" @click="quitar()" class="btn btn-danger">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </div>

                                    <label class="col-md-2 form-control-label">Categoria <span style="color:red;" v-show="id_categoria.length==0">(*Seleccione)</span></label>
                                    <div class="form-inline col-md-4">
                                        <div class="col-md-10 float-left">
                                            <multiselect v-model="id_categoria" :options="arrayCategoria" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" :custom-label="arrayCategoria.nombre" placeholder="Seleccione alguna" label="nombre" track-by="nombre" :preselect-first="true">
                                                <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} seleccionadas</span></template>
                                            </multiselect>
                                        </div>

                                        <button type="button" @click="abrirModal('planCuentas','categorias')" class="btn btn-primary col-md-2 float-right"><i class="fa fa-plus-circle"></i></button>
                                    </div>
                                </div>
                                <div style="display:none;" :class="{'form-group row mostrar-crear' : modalCrear==1}">
                                    <div class="col-md-10 float-left">
                                        <div class="form-group col-md-6 float-left">
                                            <span v-text="tituloModalCrear" class="form-control-label col-md-4 float-left"></span>
                                            <input type="text" class="form-control col-md-8 float-right" v-model="nombre_crear">
                                        </div>
                                        <div class="col-md-6 float-left">
                                            <span class="form-control-label col-md-4 float-left">Descripción</span>
                                            <input type="text" class="form-control col-md-8 float-right" v-model="descripcion_crear">
                                        </div>
                                    </div>
                                    <div class="col-md-2 float-right">
                                        <button type="button" class="btn btn-primary" @click="crearExtras('categoria')"><i class="fa fa-save"></i></button>
                                        <button type="button" class="btn btn-secondary" @click="cerrarModalCrear()"><i class="fa fa-times-circle"></i></button>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Cuenta compra</label>
                                    <div class="col-md-1">                                        
                                        <input type="checkbox" v-model="tipo_cuenta_compra" value="Cuenta compra" class="form-control">
                                    </div>

                                    <label class="col-md-3 form-control-label" for="text-input">Cuenta salida de almacen</label>
                                    <div class="col-md-1">                                        
                                        <input type="checkbox" v-model="tipo_cuenta_salida_almacen" value="Cuenta salida almacen" class="form-control">
                                    </div>
                                </div>
                                
                                <div v-show="errorPlanCuentas" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPlanCuentas" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarPlanCuentas()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-success" @click="actualizarPlanCuentas()">Actualizar</button>
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
                            <button type="button" class="close" @click="cerrarModal2()" aria-label="Close">
                                <span aria-hidden="true" title="Cerrar">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div style="max-width: 120px !important;" class="col-md-2   ">
                                    <label style='margin-top: 3px; '><b>Cuenta</b></label>                                
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="cta_busq" v-model="cta_busq" @keyup="buscarCuentaB()">
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm  table-responsive">
                                    
                                        <tr><th>Codigo</th><th>Cuenta</th><th>-</th></tr>
                                    
                                        <tr v-for="cuentas in arrayCuentasBusq" :key="cuentas.id">
                                            <td v-text="cuentas.codigo"></td>
                                            <td v-text="cuentas.nombre"></td>
                                            <td>
                                                <button type="button" style=" margin-right: -8px;" @click="cargarCuentaB(cuentas)" class="btn btn-success btn-sm" title='Ver formato'>
                                                    <i class="icon-check"></i>
                                                </button>
                                            </td>
                                        </tr>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" @click="cerrarModal2()">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--Fin del modal-->

            <!-- Modal busqueda tercero-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalTerceros}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="titulomodalTerceros"></h4>
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
            <!-- Fin Modal buscar tercero -->
        </main>
</template>

<script>
    export default {
        props : ['ruta', 'permisosUser'],
        data (){
            return {
                cuenta_id: 0,
                nombre : '',
                codigo : '',
                naturaleza : '',
                tipo : '',
                corriente : '',
                banco : '',
                diferido : '',
                tercero : '',
                niif : '',
                anio : '',
                orden : '',
                id_cuenta_cierre : '',
                codigo_cuenta_cierre : '',
                cuenta_cierre : '',
                evitar_saldo_negativo : false,
                id_categoria : [],
                condicion : '',
                arrayPlanCuentas : [],
                arrayCategoria : [],

                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorPlanCuentas : 0,
                errorMostrarMsjPlanCuentas : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 20,
                criterio : 'nombre',
                buscar : '',

                modal2 : 0,
                tituloModal2 : '',
                cta_busq : '',
                arrayCuentasBusq : [],

                /* Variables para crear categorias*/
                nombre_crear : '',
                descripcion_crear : '',
                modalCrear : 0,
                tituloModalCrear : '',
                tipoAccionCrear : 0,
                errorCrear : 0,
                errorMostrarMsjCrear : [],

                // variables modulo terceros
                tipoAccionModalTerceros : 0,
                arrayTerceros : [],
                titulomodalTerceros : '',
                modalTerceros : 0,
                tercero : '',
                tercero_id : '',
                tercero_doc : '',
                terc_busq : '',
                tipoAutoretenedorTercero : '',

                tipo_cuenta_compra : '',
                tipo_cuenta_salida_almacen : '',
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

            },
            verificar_ini_cuenta: function(){
                if((this.codigo.substr(0,1)=="1"||this.codigo.substr(0,1)=="2")&&this.codigo.length>=6){
                    return 1;
                }
                else{
                    return 0;
                }
                
            }
        },
        methods : {
            listarPlanCuentas (page,buscar,criterio){
                let me=this;
                var url= this.ruta +'/planCuentas?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPlanCuentas = respuesta.planCuentas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectCategoria(){
                let me=this;
                var url= this.ruta + '/categoria/selectCategoria';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayCategoria = respuesta.categorias;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectCategoriaPlanCuentas(id){
                let me=this;
                var url= this.ruta + '/planCuentasCategorias/selectPlanCuentasCategorias?id_plan_cuentas='+id;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.id_categoria = respuesta.planCuentasCategorias;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            crearExtras(nombre){
                if (this.validarExtras()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/'+nombre+'/registrar',{
                    'nombre': this.nombre_crear,
                    'descripcion': this.descripcion_crear
                }).then(function (response) {
                    me.cerrarModalCrear();
                    me.selectCategoria();
                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarExtras(){
                this.errorCrear=0;
                this.errorMostrarMsjCrear =[];

                if (!this.nombre_crear) this.errorMostrarMsjCrear.push("El nombre no puede estar vacío.");

                if (this.errorMostrarMsjCrear.length) this.errorCrear = 1;

                return this.errorCrear;
            },
            cerrarModalCrear(){
                this.modalCrear=0;
                this.tituloModalCrear='';
                this.nombre_crear = '';
                this.descripcion_crear = '';
		        this.errorCrear=0;
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
            cargarCuentaB(cuenta){
                let me=this;
                me.codigo_cuenta_cierre= cuenta['codigo'];
                me.id_cuenta_cierre= cuenta['id'];
                me.cuenta_cierre= cuenta['nombre'];

                // cerrar el modal 2
                me.modal2=0;
                me.tituloModal2='';
                me.cta_busq='';
                me.arrayCuentasBusq=[];
            },
            cargarTercero(tercero){
                this.tercero = tercero['num_documento']+' - '+tercero['nombre1']+' '+tercero['apellido1'];
                this.tercero_id = tercero['id'];
                this.tercero_doc = tercero['num_documento'];
                this.tipoAutoretenedorTercero = tercero['autoretenedor']
                
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
            quitar(){
                this.tercero_id = '';
                this.tercero = '';
            },
            cerrarModalT(){
                let me=this;
                me.modalTerceros=0;
                me.titulomodalTerceros='';
                me.terc_busq = '';
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarPlanCuentas(page,buscar,criterio);
            },
            registrarPlanCuentas(){
                if (this.validarPlanCuentas()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/planCuentas/registrar',{
                    'nombre': this.nombre,
                    'codigo': this.codigo,
                    'naturaleza': this.naturaleza,
                    'tipo': this.tipo,
                    'corriente': this.corriente,
                    'diferido': this.diferido,
                    'niif': this.niif,
                    'condicion': this.condicion,
                    'anio': this.anio,
                    'banco': this.banco,
                    'id_cuenta_cierre': this.id_cuenta_cierre,
                    'evitar_saldo_negativo': this.evitar_saldo_negativo,
                    'id_categorias': this.id_categoria,
                    'id_tercero': this.tercero_id,
                    'tipo_cuenta_compra': this.tipo_cuenta_compra,
                    'orden': this.orden,
                    'tipo_cuenta_salida_almacen': this.tipo_cuenta_salida_almacen,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPlanCuentas(1,'','codigo');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarPlanCuentas(){
               if (this.validarPlanCuentas()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta +'/planCuentas/actualizar',{
                    'nombre': this.nombre,
                    'codigo': this.codigo,
                    'naturaleza': this.naturaleza,
                    'tipo': this.tipo,
                    'corriente': this.corriente,
                    'diferido': this.diferido,
                    'niif': this.niif, 
                    'condicion': this.condicion,
                    'banco': this.banco,
                    'anio': this.anio,
                    'id_cuenta_cierre': this.id_cuenta_cierre,
                    'evitar_saldo_negativo': this.evitar_saldo_negativo,
                    'id_categorias': this.id_categoria,
                    'id_tercero': this.tercero_id,
                    'tipo_cuenta_compra': this.tipo_cuenta_compra,
                    'orden': this.orden,
                    'tipo_cuenta_salida_almacen': this.tipo_cuenta_salida_almacen,
                    'id': this.cuenta_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPlanCuentas(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            
            validarPlanCuentas(){
                this.errorPlanCuentas=0;
                this.errorMostrarMsjPlanCuentas =[];

                if (!this.nombre) this.errorMostrarMsjPlanCuentas.push("El nombre de la cuenta no puede estar vacío.");
                if (!this.codigo) this.errorMostrarMsjPlanCuentas.push("El codigo de la cuenta no puede estar vacío.");
                if (!this.anio) this.errorMostrarMsjPlanCuentas.push("El año de la cuenta no puede estar vacío.");
                if (!this.naturaleza) this.errorMostrarMsjPlanCuentas.push("La naturalzeza de la cuenta no puede estar vacía.");
                if (!this.tipo) this.errorMostrarMsjPlanCuentas.push("El tipo de la cuenta no puede estar vacío.");
                if (!this.condicion) this.errorMostrarMsjPlanCuentas.push("El estado de la cuenta no puede estar vacío.");
                if (this.errorMostrarMsjPlanCuentas.length) this.errorPlanCuentas = 1;

                return this.errorPlanCuentas;
            },
            cerrarModal(){
                this.modal=0;
                //this.tituloModal='';
                this.naturaleza='';
                this.tipo='';
                this.corriente='';
                this.diferido='';
                this.niif='';
                this.condicion='';
                this.nombre='';
                this.codigo='';
                this.banco='';
                this.tercero='';
                this.anio='';
                this.orden='';
                this.id_cuenta_cierre='';
                this.codigo_cuenta_cierre = '';
                this.cuenta_cierre = '';
                this.modal2=0;
                this.id_categoria = [];
                this.tipo_cuenta_compra = '';
                this.tipo_cuenta_salida_almacen = '';
            },
            cerrarModal2(){
                this.modal2 = 0;
                this.tituloModal2 = '';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "planCuentas":
                    {
                        this.selectCategoria();
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Plan cuentas';
                                this.tituloModal='';
                                this.naturaleza='';
                                this.tipo='';
                                this.corriente='';
                                this.diferido='';
                                this.niif='';
                                this.condicion='';
                                //this.anio;
                                this.orden='';
                                this.evitar_saldo_negativo=0;
                                this.tipoAccion = 1;
                                this.condicion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal = 'Actualizar categoría';
                                this.tipoAccion = 2;
                                this.cuenta_id = data['id'];
                                this.nombre = data['nombre'];
                                this.codigo = data['codigo'];
                                this.naturaleza = data['naturaleza'];
                                this.tipo = data['tipo'];
                                this.corriente = data['corriente'];
                                this.diferido = data['diferido'];
                                this.niif = data['niif'];
                                this.banco = data['banco'];
                                this.condicion = data['condicion'];
                                this.anio = data['anio'];
                                this.id_cuenta_cierre = data['id_cuenta_cierre'];
                                this.cuenta_cierre = data['cuenta_cierre'];
                                this.codigo_cuenta_cierre = data['codigo_cuenta_cierre'];
                                this.evitar_saldo_negativo = data['evitar_saldo_negativo'];
                                this.tipo_cuenta_compra = data['tipo_cuenta_compra'];
                                this.orden = data['orden'];
                                this.tipo_cuenta_salida_almacen = data['tipo_cuenta_salida_almacen'];

                                if(data['id_tercero']!=0 && data['id_tercero']!=null){
                                    this.tercero_id = data['id_tercero'];
                                    this.tercero = data['nom_tercero']+' '+data['apellido_tercero'];
                                    this.tercero_doc = data['num_doc_tercero'];
                                }
                                else{
                                    this.tercero_id = data['id_tercero'];
                                    this.tercero = 'No se ha seleccionado un tercero';
                                    this.tercero_doc = '';
                                }
                                
                                this.selectCategoriaPlanCuentas(data['id']);
                                break;
                            }
                            case 'buscar':
                            {
                                this.modal2 = 1;
                                this.tituloModal2 = 'Seleccione una cuenta';
                                break;
                            }
                            case "categorias":
                            {   
                                this.modalCrear = 1;
                                this.tituloModalCrear = 'Categoria';
                                this.nombre_crear= '';
                                this.descripcion_crear = '';
                                this.tipoAccionCrear = 1;
                                break;
                            }
                            case 'tercero':
                            {
                                this.arrayTerceros=[];
                                this.modalTerceros = 1;
                                this.titulomodalTerceros = 'Seleccione un tercero filtro 1';
                                this.tipoAccionModalTerceros = 1;
                                break;
                            }
                        }
                    }
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
            me.anio = yyyy;

            this.listarPlanCuentas(1,this.buscar,this.criterio);
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

    .mostrar-crear{
        display: inline !important;
    }
</style>
