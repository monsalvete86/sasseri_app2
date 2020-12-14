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
                        <i class="fa fa-align-justify"></i> Cajas
                        <button v-if="permisosUser.crear" type="button" @click="abrirModal('cajas','registrar')" class="btn btn-primary">
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
                                      <option value="nombre">Nombre</option>>
                                    </select>
                                    <select v-else disabled class="form-control col-md-3" v-model="criterio">
                                    </select>-->

                                    <input v-if="permisosUser.leer" type="text" v-model="buscar" @keyup="listarCajas(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <input v-else disabled type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar">

                                    <!--<button v-if="permisosUser.leer" type="submit" @click="listarCajas(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    <button v-else type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> Buscar</button>-->
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="col-md-7">Nombre</th>
                                    <th>Estado</th>
                                    <th>Tiempo</th>
                                    <th>Usuario</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody v-if="permisosUser.leer && arrayCajas.length">
                                <tr v-for="cajas in arrayCajas" :key="cajas.id">
                                    <td v-text="cajas.nombre"></td>
                                    <td v-if="cajas.estado_caja==0">Sin abrir</td>
                                    <td v-else-if="cajas.estado_caja==1">Abierta</td>
                                    <td v-else-if="cajas.estado_caja==2">Cerrada</td>
                                    <td v-text="cajas.tiempo_caja"></td>
                                    <td v-if="cajas.usuario_caja!=''" v-text="cajas.usuario_caja"></td>
                                    <td v-else>N/A</td>
                                    <td>
                                        <button v-if="permisosUser.actualizar && cajas.estado" type="button" @click="abrirModal('cajas','actualizar',cajas)" class="btn btn-warning btn-sm" title="Editar">
                                          <i class="icon-pencil"></i>
                                        </button>
                                        <button v-else type="button" class="btn btn-secondary btn-sm" title="Editar (Deshabilitado)">
                                          <i class="icon-pencil"></i>
                                        </button>

                                        <template v-if="permisosUser.anular">
                                            <button v-if="cajas.estado" type="button" class="btn btn-danger btn-sm" @click="desactivarCaja(cajas.id)" title="Desactivar">
                                                <i class="icon-trash"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-info btn-sm" @click="activarCaja(cajas.id)" title="Activar">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button v-if="cajas.estado" type="button" class="btn btn-secondary btn-sm" title="Desactivar">
                                                <i class="icon-trash"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-secondary btn-sm" title="Activar">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                        <template v-if="cajas.estado==1">
                                            <button v-if="cajas.estado_caja!=1" type="button" class="btn btn-info btn-sm" title="Abrir caja" @click="abrirModal('cierres_caja','registrar', cajas)">
                                                <i class="fas fa-box-open"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-warning btn-sm" title="Cerrar caja" @click="abrirModal('cierres_caja','cerrar_caja', cajas)">
                                                <i class="fas fa-box-open"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button v-if="cajas.estado_caja!=2" type="button" class="btn btn-secondary btn-sm" title="Abrir">
                                                <i class="fas fa-box-open"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-secondary btn-sm" title="Cerrar">
                                                <i class="fas fa-box-open"></i>
                                            </button>
                                        </template>
                                    </td>
                                </tr>                                
                            </tbody>
                            <tbody v-else>
                                <tr><td colspan="2">No hay registros para mostrar</td></tr>
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
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true" title="Cerrar">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de la concentración">
                                        
                                    </div>
                                </div>
                                <div v-show="errorCaja" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjCaja" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarCaja()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-success" @click="actualizarCaja()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

            <!-- Modal actualizar cierre de caja -->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalCierreCaja}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModalCierre"></h4>
                            <button type="button" class="close" @click="cerrarModalCierreCaja()" aria-label="Close">
                                <span aria-hidden="true" title="Cerrar">×</span>
                            </button>
                        </div>
                        <div v-if="tipoAccionCierre!=3 && tipoAccionCierre!=4" class="modal-body">
                            <!--<div class="form-group row">
                                <div class="col-md-12">
                                    <label class="col-md-1 float-left">Caja</label>
                                    <div class="float-right col-md-11">
                                        <select v-if="tipoAccionCierre==2" disabled class="form-control float-right" v-model="id_caja_cierre" style="width: 95.7% !important;">
                                            <option></option>
                                            <option v-for="(caja, index) in arrayCajas" :value="caja.id" v-text="caja.nombre"></option>
                                        </select>
                                        <select v-else class="form-control float-right" v-model="id_caja_cierre" @change="selectValorInicialCaja(id_caja_cierre)" style="width: 95.7% !important;">
                                            <option></option>
                                            <option v-for="(caja, index) in arrayCajas" :value="caja.id" v-text="caja.nombre"></option>
                                        </select>
                                    </div>
                                </div> 
                            </div>-->
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="col-md-3 float-left">Vr. Inicial</label>
                                    <div class="col-md-9 float-right">
                                        <input type="number" v-if="tipoAccionCierre==2" disabled class="form-control" v-model="vr_inicial_cierre">
                                        <input type="number" v-else class="form-control" v-model="vr_inicial_cierre" v-bind:class="{ 'is-invalid' : hasError.vr_inicial_cierre==1 }">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-md-3 float-left">Obs. Inicial</label>
                                    <div class="col-md-9 float-right">
                                        <input type="text" class="form-control" v-model="obs_inicial_cierre" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row" v-if="tipoAccionCierre==1">
                                <div class="col-md-6">
                                    <label class="col-md-3 float-left">Cajero</label>
                                    <div class="col-md-9 float-right">
                                        <select class="form-control" v-model="id_cajero">
                                            <option value="0">Seleccione</option>
                                            <option v-for="(cajero, index) in arrayCajeros" :value="cajero.id" v-text="cajero.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row" v-if="tipoAccionCierre==2">
                                <div class="col-md-6">
                                    <label class="col-md-3 float-left">Vr. Gastos</label>
                                    <div class="col-md-9 float-right">
                                        <input type="number" class="form-control" v-model="vr_gastos_cierre" v-bind:class="{ 'is-invalid' : hasError.vr_gastos_cierre==1 }">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-md-3 float-left">Obs. Gastos</label>
                                    <div class="col-md-9 float-right">
                                        <input type="text" class="form-control" v-model="obs_gastos_cierre">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row" v-if="tipoAccionCierre==2">
                                <div class="col-md-6">
                                    <label class="col-md-3 float-left">Vr. Final</label>
                                    <div class="col-md-9 float-right">
                                        <input type="number" class="form-control" v-model="vr_final_cierre" v-bind:class="{ 'is-invalid' : hasError.vr_final_cierre==1 }">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-md-3 float-left">Cajero</label>
                                    <div class="col-md-9 float-right">
                                        <select class="form-control" v-model="id_cajero" disabled>
                                            <option value="0">Seleccione</option>
                                            <option v-for="(cajero, index) in arrayCajeros" :value="cajero.id" v-text="cajero.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else class="modal-body">
                            <div  v-if="tipoAccionCierre==3" class="row container">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th class="col-md-10">Nombre</th>
                                            <th class="col-md-1">Fecha</th>
                                            <th class="col-md-1">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="permisosUser.leer && arrayCierresUsuario.length">
                                        <tr v-for="cierre_caja in arrayCierresUsuario" :key="cierre_caja.id">
                                            <td v-text="cierre_caja.nombre"></td>
                                            <td v-text="cierre_caja.created_at"></td>
                                            <td>
                                                <button v-if="permisosUser.leer" type="button" @click="mostrarDetalle('cierres_caja','ver',cierre_caja)" class="btn btn-info btn-sm">
                                                    <i class="icon-eye"></i>
                                                </button>
                                                <button v-else type="button" class="btn btn-secondary btn-sm">
                                                    <i class="icon-eye"></i>
                                                </button> &nbsp;

                                                <!--<button v-if="permisosUser.actualizar && cierre_caja.estado" type="button" @click="mostrarDetalle('cierres_caja','actualizar',cierre_caja)" class="btn btn-warning btn-sm">
                                                    <i class="icon-pencil"></i>
                                                </button>
                                                <button v-else type="button" class="btn btn-secondary btn-sm">
                                                    <i class="icon-pencil"></i>
                                                </button> &nbsp;-->

                                                <template v-if="permisosUser.actualizar">
                                                    <button v-if="cierre_caja.estado==1" type="button" class="btn btn-warning btn-sm" @click="mostrarDetalle('cierres_caja','cerrar_caja',cierre_caja)">
                                                        <i class="fa fa-window-close"></i>
                                                    </button>
                                                    <button v-else type="button" class="btn btn-secondary btn-sm">
                                                        <i class="fa fa-window-close"></i>
                                                    </button>
                                                </template>
                                                <template v-else>
                                                    <button type="button" class="btn btn-secondary btn-sm">
                                                        <i class="fa fa-window-close"></i>
                                                    </button>
                                                </template>

                                                <template v-if="permisosUser.anular">
                                                    <button v-if="cierre_caja.estado==1" type="button" class="btn btn-danger btn-sm" @click="desactivarCierreXCaja(cierre_caja.id)">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                    <button v-else type="button" class="btn btn-secondary btn-sm">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </template>
                                                <template v-else>
                                                    <button type="button" class="btn btn-secondary btn-sm">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </template>
                                            </td>
                                        </tr>                                
                                    </tbody>
                                    <tbody v-else>
                                        <tr><td colspan="2">No hay registros para mostrar</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else-if="tipoAccionCierre==4" class="row">
                                <div class="col-md-12">
                                    <h3 v-text="nombre_caja"></h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6 float-left">
                                        <div class="col-md-12">
                                            <label class="col-md-12 float-left" v-text="'Valor inicial: '+vr_inicial_cierre"></label>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="col-md-3 float-left">Observacion inicial:</label>
                                            <div class="col-md-9 float-right">
                                                <p v-text="obs_inicial_cierre" class="col-md-12 float-left" style="overflow-y: auto;max-height: 8em;"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 float-right">
                                        <div class="col-md-12">
                                            <label class="col-md-12 float-left" v-text="'Valor inicial: '+vr_gastos_cierre"></label>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="col-md-3 float-left">Observacion inicial:</label>
                                            <div class="col-md-9 float-right">
                                                <p v-text="obs_gastos_cierre" class="col-md-12 float-left" style="overflow-y: auto;max-height: 8em;"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <label class="col-md-12 float-left" v-text="'Valor final: '+vr_final_cierre"></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <button type="button" @click="tipoAccionCierre=3" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Atras</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModalCierreCaja()">Cerrar</button>
                            <button type="button" v-if="tipoAccionCierre==1" class="btn btn-primary" @click="registrarCierreXCaja()">Guardar</button>
                            <button type="button" v-if="tipoAccionCierre==2" class="btn btn-primary" @click="cerrarCierreXCaja()">Cerrar Caja</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
</template>

<script>
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
                caja_id: 0,
                nombre : '',
                arrayCajas : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorCaja : 0,
                errorMostrarMsjCaja : [],
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

                // variables cierre de caja
                cierre_caja_id : 0,
                nombre_caja : '',
                id_caja_cierre : '',
                vr_inicial_cierre : 0,
                obs_inicial_cierre : '',
                vr_gastos_cierre : 0,
                obs_gastos_cierre : '',
                vr_software_cierre : 0,
                vr_final_cierre : 0,
                id_cajero : 0,
                arrayCajeros : [],
                arrayCierresXCajas : [],
                arrayCierresUsuario : [],
                arrayCajas: [],
                modalCierreCaja : 0,
                tituloModalCierre : '',
                tipoAccionCierre : 0,
                ban : 0,

                hasError : {
                    vr_inicial_cierre : 0,
                    vr_gastos_cierre : 0,
                    vr_final_cierre : 0,
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
            listarCajas (page,buscar,criterio){
                let me=this;
                var url= this.ruta +'/cajas?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCajas = respuesta.cajas.data;
                    me.pagination= respuesta.pagination;
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
                me.listarCajas(page,buscar,criterio);
            },
            registrarCaja(){
                if (this.validarCaja()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/cajas/registrar',{
                    'nombre': this.nombre,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCajas(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarCaja(){
               if (this.validarCaja()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta +'/cajas/actualizar',{
                    'nombre': this.nombre,
                    'id': this.caja_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCajas(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            validarCaja(){
                this.errorCaja=0;
                this.errorMostrarMsjCaja =[];

                if (!this.nombre) this.errorMostrarMsjCaja.push("Ingrese el nombre de la caja");

                if (this.errorMostrarMsjCaja.length) this.errorCaja = 1;

                return this.errorCaja;
            },
            desactivarCaja(id){
               Swal.fire({
                title: 'Esta seguro de desactivar esta caja?',
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

                    axios.put(this.ruta +'/cajas/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarCajas(1,'','nombre');
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
                    result.dismiss === Swal.fire.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarCaja(id){
               Swal.fire({
                title: 'Esta seguro de activar esta caja?',
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

                    axios.put(this.ruta +'/cajas/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarCajas(1,'','nombre');
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
                    result.dismiss === Swal.fire.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            SelectCierreXCaja(id){
                let me=this;
                var url= this.ruta +'/cierres_caja/SelectCierreXCaja?id='+id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data.cierres_caja[0];
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectCajas(){
                let me=this;
                var url= this.ruta +'/cajas/SelectCaja';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCajas = respuesta.cajas;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectCajeros(id){
                let me=this;
                var url= this.ruta +'/cajas_admin/listarCajerosAdmin?id='+id;
                 axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayCajeros = respuesta.cajas_admin;                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectValorInicialCaja(id){
                let me=this;
                var url= this.ruta +'/cierres_caja/selectValorInicialCaja?id='+id;
                if(id!=0 && id!='')
                {
                    axios.get(url).then(function (response) {
                        var respuesta= response.data;
                        if(respuesta.cierres_caja[0])
                        {
                            me.vr_inicial_cierre = respuesta.cierres_caja[0]['vr_final'];
                        }
                        else
                        {
                            me.vr_inicial_cierre = 0;
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
                else
                {
                    alert('id vacio');
                }
            },
            registrarCierreXCaja(){
                if (this.validarCierreXCaja()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/cierres_caja/registrar',{
                    'id_caja': this.id_caja_cierre,
                    'vr_inicial': this.vr_inicial_cierre,
                    'obs_inicial': this.obs_inicial_cierre,
                    'vr_gastos': this.vr_gastos_cierre,
                    'obs_gastos': this.obs_gastos_cierre,
                    'vr_final': this.vr_final_cierre,
                    'id_cajero': this.id_cajero,
                }).then(function (response) {
                    me.modalCierreCaja = 0;
                    me.listarCajas(1,me.buscar,me.criterio);
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarCierreXCaja(){
                if (this.validarCierreXCaja()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta +'/cierres_caja/actualizar',{
                    'id_caja': this.id_caja_cierre,
                    'vr_inicial': this.vr_inicial_cierre,
                    'obs_inicial': this.obs_inicial_cierre,
                    'vr_gastos': this.vr_gastos_cierre,
                    'obs_gastos': this.obs_gastos_cierre,
                    'vr_final': this.vr_final_cierre,
                    'id': this.cierre_caja_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCajas(1,me.buscar,me.criterio);
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            consultarCierreXCaja(id){
                let me=this;
                var url= this.ruta +'/cierres_caja/consultarCierreXCaja?id='+id;
                axios.get(url).then(function (response) {
                    // console.log(response);
                    var respuesta= response.data;
                    me.arrayCierresXCajas = respuesta.cierres_caja;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cerrarCierreXCaja(){
                if(this.validarCierreXCaja()){
                    return;
                }
                let me = this;
                
                Swal.fire({
                    title: 'Esta seguro de cerrar esta caja?',
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

                        axios.put(this.ruta +'/cierres_caja/cerrar',{
                            'id_caja': this.id_caja_cierre,
                            'obs_inicial': this.obs_inicial_cierre,
                            'vr_gastos': this.vr_gastos_cierre,
                            'obs_gastos': this.obs_gastos_cierre,
                            'vr_final': this.vr_final_cierre,
                            'id': this.cierre_caja_id
                        }).then(function (response) {
                            // me.id_caja_facturacion = 0;
                            // me.nom_caja_cierre_facturacion = '';
                            me.cerrarModalCierreCaja();
                            Swal.fire(
                            'Desactivado!',
                            'El registro ha sido cerrado con éxito.',
                            'success')
                            me.listarCajas(1,me.buscar,me.criterio);
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {}
                }) 
            },
            cerrarModalCierreCaja(){
                this.modalCierreCaja=0;
                this.tituloModalCierre='';

                this.id_caja_cierre='';
                this.vr_inicial_cierre=0;
                this.obs_inicial_cierre = '';
                this.vr_gastos_cierre = 0;
                this.obs_gastos_cierre = '';
                this.vr_software_cierre = 0;
                this.vr_final_cierre = 0;
                this.cierre_caja_id = 0;

                this.arrayCierresUsuario = 0;
                this.arrayCierresXCajas = 0;
                this.ban=0;

                // this.id_caja_facturacion = 0;
                // this.nom_caja_cierre_facturacion = '';
            },
            validarCierreXCaja(){
                this.hasError['vr_inicial_cierre'] = 0;
                this.hasError['vr_gastos_cierre'] = 0;
                this.hasError['vr_final_cierre'] = 0;
                var error = 0;

                if(!this.vr_inicial_cierre || this.vr_inicial_cierre<=0){error=1; this.hasError['vr_inicial_cierre']=1;}
                if(this.tipoAccionCierre==2)
                {
                    if(!this.vr_gastos_cierre || this.vr_gastos_cierre<=0){error=1; this.hasError['vr_gastos_cierre']=1;}
                    if(!this.vr_final_cierre || this.vr_final_cierre<=0){error=1; this.hasError['vr_final_cierre']=1;}
                }

                return error;
            },
            cerrarModalCierreCaja(){
                this.modalCierreCaja=0;
                this.tituloModalCierre='';
                // this.id_caja_cierre='';
                // this.vr_inicial_cierre=0;
                // this.obs_inicial_cierre = '';
                // this.vr_gastos_cierre = 0;
                // this.obs_gastos_cierre = '';
                // this.vr_software_cierre = 0;
                // this.vr_final_cierre = 0;
                // this.cierre_caja_id = 0;
                this.arrayCierresUsuario = 0;
                this.arrayCierresXCajas = 0;
                this.id_cajero = 0;
                this.arrayCajeros = [];
                this.ban=0;

                // this.id_caja_facturacion = 0;
                // this.nom_caja_cierre_facturacion = '';
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.errorCaja = 0;
                this.errorMostrarMsjCaja = [];
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "cajas":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Caja';
                                this.nombre= '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Caja';
                                this.tipoAccion=2;
                                this.caja_id=data['id'];
                                this.nombre = data['nombre'];
                                break;
                            }
                        }
                    }

                    case "cierres_caja":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                // console.log(data);
                                this.arrayCierresUsuario = [];
                                this.modalCierreCaja = 1;
                                this.tituloModalCierre = 'Abrir caja';
                                this.id_caja_cierre=data['id'];
                                this.id_cajero = 0;
                                this.vr_inicial_cierre=0;
                                this.obs_inicial_cierre = '';
                                this.vr_gastos_cierre = 0;
                                this.obs_gastos_cierre = '';
                                this.vr_software_cierre = 0;
                                this.vr_final_cierre = 0;
                                this.cierre_caja_id = 0;
                                this.tipoAccionCierre = 1;
                                break;
                            }
                            case 'cerrar_caja':
                            {
                                //console.log(data);

                                let me=this;
                                var url= this.ruta +'/cierres_caja/consultarCierreXCaja?id='+data['id'];
                                axios.get(url).then(function (response) {
                                    // console.log(response);
                                    var respuesta= response.data;
                                    me.arrayCierresXCajas = respuesta.cierres_caja;

                                    if(me.arrayCierresXCajas.length){
                                        me.arrayCierresUsuario = [];
                                        me.modalCierreCaja=1;
                                        me.tituloModalCierre='Cerrar caja';
                                        me.tipoAccionCierre=2;
                                        me.cierre_caja_id=me.arrayCierresXCajas[0]['id'];
                                        me.id_caja_cierre = me.arrayCierresXCajas[0]['id_caja'];
                                        me.id_cajeero = me.arrayCierresXCajas[0]['id_cajero'];
                                        me.vr_inicial_cierre = me.arrayCierresXCajas[0]['vr_inicial'];
                                        me.obs_inicial_cierre = me.arrayCierresXCajas[0]['obs_inicial'];
                                        me.vr_gastos_cierre = me.arrayCierresXCajas[0]['vr_gastos'];
                                        me.obs_gastos_cierre = me.arrayCierresXCajas[0]['obs_gastos'];
                                        me.vr_software_cierre = 0;
                                        me.vr_final_cierre = me.arrayCierresXCajas[0]['vr_final'];
                                        me.id_cajero = me.arrayCierresXCajas[0]['usu_crea'];
                                    }
                                    else
                                    {
                                        me.arrayCierresUsuario = [];
                                        me.modalCierreCaja=1;
                                        me.tituloModalCierre='Cerrar caja';
                                        me.tipoAccionCierre=2;
                                    }
                                })
                                .catch(function (error) {
                                    console.log(error);
                                });

                                /*if(this.arrayCierresXCajas.length)
                                {
                                    console.log('entra if');
                                    this.arrayCierresUsuario = [];
                                    this.modalCierreCaja=1;
                                    this.tituloModalCierre='Cerrar caja';
                                    this.tipoAccionCierre=2;
                                    this.cierre_caja_id=this.arrayCierresXCajas['id'];
                                    this.id_caja_cierre = this.arrayCierresXCajas['id_caja'];
                                    this.vr_inicial_cierre = this.arrayCierresXCajas['vr_inicial'];
                                    this.obs_inicial_cierre = this.arrayCierresXCajas['obs_inicial'];
                                    this.vr_gastos_cierre = this.arrayCierresXCajas['vr_gastos'];
                                    this.obs_gastos_cierre = this.arrayCierresXCajas['obs_gastos'];
                                    this.vr_software_cierre = 0;
                                    this.vr_final_cierre = this.arrayCierresXCajas['vr_final'];
                                }
                                else
                                {
                                    console.log('entra else');
                                    this.arrayCierresUsuario = [];
                                    this.modalCierreCaja=1;
                                    this.tituloModalCierre='Cerrar caja';
                                    this.tipoAccionCierre=2;
                                }*/
                                break;
                            }
                            case 'listar_cierres':
                            {
                                console.log(data);
                                Swal.fire({
                                title: 'ERROR!',
                                text: "Este usuario tiene una caja abierta desde hace mas de 24 horas",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok!'
                                }).then((result) => {
                                    if(result.value){
                                        this.arrayCierresUsuario.push({
                                            created_at : data['created_at'],
                                            estado : data['estado'],
                                            id : data['id'],
                                            id_caja : data['id_caja'],
                                            nombre : data['nombre'],
                                            obs_gastos : data['obs_gastos'],
                                            obs_inicial : data['obs_inicial'],
                                            vr_final : data['vr_final'],
                                            vr_gastos : data['vr_gastos'],
                                            vr_inicial : data['vr_inicial'],
                                            vr_software : data['vr_software'],
                                        });
                                        
                                        this.modalCierreCaja=1;
                                        this.tituloModalCierre='Listado de cierres de caja';
                                        this.tipoAccionCierre=3;
                                    }
                                    else{
                                        result.dismiss === Swal.DismissReason.cancel
                                    }
                                })
                                break;
                            }
                            case 'ver':
                            {
                                this.tipoAccionCierre=4;
                                this.id_caja = data['id_caja'];
                                this.nombre_caja = data['nombre'];
                                this.vr_inicial_cierre = data['vr_inicial'];
                                this.obs_inicial_cierre = data['obs_inicial'];
                                this.vr_gastos_cierre = data['vr_gastos'];
                                this.obs_gastos_cierre = data['obs_gastos'];
                                this.vr_software_cierre = data['vr_software'];
                                this.vr_final_cierre = data['vr_final'];
                                break;
                            }
                        }
                        this.selectCajeros(data['id']);
                        // this.selectCajas();
                        break;
                    }
                }
            }
        },
        mounted() {
            this.listarCajas(1,this.buscar,this.criterio);
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
