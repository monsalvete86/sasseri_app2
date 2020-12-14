<template>
        <main class="main">
            <!-- Breadcrumb -->
            
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Administradores de cajas
                        <button v-if="permisosUser.crear" type="button" @click="abrirModal('cajas_admin','registrar')" class="btn btn-primary">
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

                                    <input v-if="permisosUser.leer" type="text" v-model="buscar" @keyup="listarCajasAdmin(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <input v-else disabled type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar">

                                    <!--<button v-if="permisosUser.leer" type="submit" @click="listarCajasAdmin(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    <button v-else type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> Buscar</button>-->
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm table-responsive table-earning">
                            <thead>
                                <tr>
                                    <th class="col-md-11">Nombre</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody v-if="permisosUser.leer && arrayCajasAdmin.length">
                                <tr v-for="cajas_admin in arrayCajasAdmin" :key="cajas_admin.id">
                                    <td v-text="cajas_admin.usuario"></td>
                                    <td>
                                        <button v-if="permisosUser.actualizar" type="button" @click="abrirModal('cajas_admin','actualizar',cajas_admin)" class="btn btn-warning btn-sm" title="Actualizar">
                                          <i class="icon-pencil"></i>
                                        </button>
                                        <button v-else type="button" class="btn btn-secondary btn-sm" title="Actualizar (Deshabilitado)">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;

                                        <template v-if="permisosUser.anular">
                                            <button v-if="cajas_admin.estado" type="button" class="btn btn-danger btn-sm" @click="desactivarConcentracion(cajas_admin.id)" title="Desactivar">
                                                <i class="icon-trash"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-info btn-sm" @click="activarConcentracion(cajas_admin.id)" title="Activar">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button v-if="cajas_admin.estado" type="button" class="btn btn-secondary btn-sm" title="Desactivar (Deshabilitado)">
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
                                    <div class="col-md-5">
                                        <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                        <div class="form-inline float-right col-md-9">
                                            <input type="text" readonly style="max-width: 130px;" class="form-control" name="cuenta_fin" v-model="tercero">

                                            <button type="button" v-if="permisosUser.leer" @click="abrirModalT()" style="min-width: 30px;" class="btn btn-primary form-control">...</button>
                                            <button v-else  style="min-width: 30px;" class="btn btn-secondary form-control">...</button>

                                            <button v-if="permisosUser.leer" type="button" @click="quitar(4)" style="min-width: 30px;" class="btn btn-danger form-control">
                                                <i class="icon-trash"></i>
                                            </button>
                                            <button v-else type="button" style="min-width: 30px;" class="btn btn-secondary form-control">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control" v-model="idCajaAgregar">
                                            <option>Buscar <input type="text" value=""></option>
                                            <option value="0">Seleccione</option>
                                            <option v-for="(caja, index) in arrayCajas" :value="caja.id" v-text="caja.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" v-if="idCajaAgregar!=0" class="btn btn-success btn-sm" @click="agregarDetalleCajasAdmin()">
                                            <i class="fa fa-plus-circle"></i>
                                        </button>
                                        <button type="button" v-else class="btn btn-secondary btn-sm">
                                            <i class="fa fa-plus-circle"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="container">
                                        <table class="table table-bordered table-striped table-sm table-responsive table-earning" v-if="arrayCajasModal.length">
                                            <tr>
                                                <th>Nombre</th>
                                            </tr>
                                            <tr v-for="(cajamodal, index) in arrayCajasModal">
                                                <td v-text="cajamodal.nom_caja"></td>
                                            </tr>
                                        </table>
                                        <table class="table table-bordered table-striped table-sm table-responsive table-earning" v-else>
                                            <tr>
                                                <th>Nombre</th>
                                            </tr>
                                            <tr>
                                                <td>No hay registros para mostrar.</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div v-show="errorCajasAdmin" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjCajasAdmin" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarCajasAdmin()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-success" @click="actualizarCajasAdmin()">Actualizar</button>
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
                                <div>
                                    <table class="table table-bordered table-striped table-sm table-responsive table-earning">
                                        
                                            <!--<tr><th>Documento</th><th>Nombre</th><th style="    width: 35px;">-</th></tr>-->
                                            <tr><th>Usuario</th><th>-</th></tr>
                                                <tr v-for="tercero in arrayTerceros" :key="tercero.id">
                                                    <td>
                                                        {{tercero.usuario}}
                                                    </td>
                                                    <td>
                                                    <button type="button" style=" margin-right: -8px;" @click="cargarTercero(tercero)" class="btn btn-success btn-sm" title='Ver formato'>
                                                        <i class="icon-check"></i>
                                                    </button>
                                                </td>
                                                </tr>
                                            <!-- <tr v-for="tercero in arrayTerceros" :key="tercero.id">
                                                <td v-text="tercero.num_documento"></td>
                                                <td v-if="tercero.nombre && !tercero.nombre1">{{ tercero.nombre }}  </td>
                                                <td v-else>{{ tercero.nombre1 + ' ' + validarUnder(tercero.nombre2)+' '+tercero.apellido1+' '+validarUnder(tercero.apellido2) }} </td>
                                                <td>
                                                    <button type="button" style=" margin-right: -8px;" @click="cargarTercero(tercero)" class="btn btn-success btn-sm" title='Ver formato'>
                                                        <i class="icon-check"></i>
                                                    </button>
                                                </td>
                                            </tr> -->
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
                caja_admin_id: 0,
                nombre : '',
                //array para listar los administradores
                arrayCajasAdmin : [],
                //array para listar las cajas en el select del modal registrar/actualizar
                arrayCajas : [],
                //array para listar las cajas por administrador en el modal registrar/actualizar
                arrayCajasModal : [],
                idCajaAgregar : 0,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorCajasAdmin : 0,
                errorMostrarMsjCajasAdmin : [],
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

                // variables modal buscar tercero
                modal2 : '',
                tercero :'',
                id_tercero : '',
                tituloModal2 : '',
                buscar : '',
                terc_busq : '',
                arrayTerceros : [],
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
            listarCajasAdmin (page,buscar,criterio){
                let me=this;
                var url= this.ruta +'/cajas_admin?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCajasAdmin = respuesta.users.data;
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
                me.listarCajasAdmin(page,buscar,criterio);
            },
            registrarCajasAdmin(){
                // if (this.validarConcentracion()){
                //     return;
                // }
                
                let me = this;

                axios.post(this.ruta +'/cajas_admin/registrar',{
                    'id_tercero': this.id_tercero,
                    'arrayCajasAdmin' : this.arrayCajasModal,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCajasAdmin(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarCajasAdmin(){
                // if (this.validarConcentracion()){
                //     return;
                // }
                
                let me = this;

                axios.put(this.ruta +'/cajas_admin/actualizar',{
                    'id_tercero': this.id_tercero,
                    'arrayCajasAdmin' : this.arrayCajasModal,
                    'id': this.caja_admin_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCajasAdmin(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            validarConcentracion(){
                this.errorCajasAdmin=0;
                this.errorMostrarMsjCajasAdmin =[];

                if (!this.nombre) this.errorMostrarMsjCajasAdmin.push("Ingrese el nombre de la concentración.");

                if (this.errorMostrarMsjCajasAdmin.length) this.errorCajasAdmin = 1;

                return this.errorCajasAdmin;
            },
            desactivarConcentracion(id){
               Swal.fire({
                title: 'Esta seguro de desactivar esta concentracion?',
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

                    axios.put(this.ruta +'/cajas_admin/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarCajasAdmin(1,'','nombre');
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
            activarConcentracion(id){
               Swal.fire({
                title: 'Esta seguro de activar esta concentracion?',
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

                    axios.put(this.ruta +'/cajas_admin/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarCajasAdmin(1,'','nombre');
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
            selectCajas(){
                let me=this;
                var url= this.ruta +'/cajas/SelectCaja';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCajas = respuesta.cajas;
                    me.validarSelectCajas();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            agregarDetalleCajasAdmin(){
                let me = this;
                
                var url= this.ruta +'/cajas/SelectCaja?id_caja='+me.idCajaAgregar;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCajasModal.push({
                        'id_caja' : respuesta.cajas2[0].id,
                        'nom_caja' : respuesta.cajas2[0].nombre,
                    });
                    me.selectCajas();
                })
                .catch(function (error) {
                    console.log(error);
                });

            },
            listarDetalleCajasAdmin(id){
                let me = this;

                var url= this.ruta +'/cajas_admin/listarCajasAdmin?id=' + id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCajasModal = respuesta.cajas_admin;
                    me.validarSelectCajas();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validarSelectCajas(){
                let me = this;

                var array = [];
                me.arrayCajas.forEach(function(caja, index) {
                    me.arrayCajasModal.forEach(function(cajamodal, index2){
                        if(caja.id === cajamodal.id_caja)
                        {
                            me.arrayCajas.splice(index, 1);
                            me.idCajaAgregar = 0;
                        }
                    });
                });
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.tipoAccion = 0;
                this.id_tercero='';
                this.tercero = '';
                this.idCajaAgregar = 0;
                this.arrayCajas = [];
                this.arrayCajasModal = [];
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "cajas_admin":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Cajas de administrador';
                                this.nombre= '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Cajas de administrador';
                                this.tipoAccion=2;
                                this.caja_admin_id=data['id'];
                                this.id_tercero = data['id_usuario'];
                                this.tercero = data['usuario'];
                                
                                this.listarDetalleCajasAdmin(data['id_usuario']);
                                break;
                            }
                        }

                        this.selectCajas();
                    }
                }
            },
            abrirModalT(){
                this.arrayTerceros=[];
                this.modal2 = 1;
                
                this.tituloModal2 = 'Seleccione un tercero';
                this.tipoAccionModalTerceros = 1;
            },
            cerrarModalT(){
                this.modal2=0;
                this.tituloModal2='';
                this.terc_busq = '';
                this.arrayTerceros = [];
            },
            cargarTercero(tercero){
                this.tercero = tercero['usuario'];
                this.id_tercero = tercero['id'];
                this.cerrarModalT();
            },
            buscarTercero(){
                let me=this;
                var search = this.terc_busq;
                var url= this.ruta +'/cajas_admin/listarVendedores?filtro='+search;
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
                if(opc==4){
                    this.idTerceroFiltro = '';
                    this.terceroFiltro = '';
                }
                if(opc==5){
                    this.idVendedorFiltro = '';
                    this.vendedorFiltro = '';
                }
            },
        },
        mounted() {
            this.listarCajasAdmin(1,this.buscar,this.criterio);
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
