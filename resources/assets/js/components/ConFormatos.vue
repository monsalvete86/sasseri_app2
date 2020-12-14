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
                    <i class="fa fa-align-justify"></i> Conf. Formatos
                    <button v-if="permisosUser.crear" type="button" @click="abrirModal('conf_formatos','registrar')" class="btn btn-primary" title="Nuevo">
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
                                <select v-if="permisosUser.leer" class="form-control col-md-3" v-model="criterio" @change="listarConf_formatos(1,buscar,criterio)">
                                    <option value="nombre_formato">Nombre</option>
                                    <option value="tipo">Tipo Comprobante</option>
                                </select>
                                <select v-else disabled class="form-control col-md-3" v-model="criterio">
                                </select>

                                <input v-if="permisosUser.leer" type="text" v-model="buscar" @keyup="listarConf_formatos(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar" title="Texto a buscar">
                                <input v-else disabled type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" title="Texto a buscar">

                                <!--<button v-if="permisosUser.leer" type="submit" @click="listarConf_formatos(1,buscar,criterio)" class="btn btn-primary" title="Buscar"><i class="fa fa-search"></i> Buscar</button>
                                <button v-else type="submit" class="btn btn-secondary" title="Buscar"><i class="fa fa-search"></i> Buscar</button>-->
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Tipo</th>                                                              
                                <th>Nombre</th>                                     
                                <th>Estado</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody v-if="permisosUser.leer && arrayConf_formatos.length">
                            <tr v-for="conf_for in arrayConf_formatos" :key="conf_for.id">
                                <td v-text="conf_for.tipo"></td>           
                                <td v-text="conf_for.nombre_formato"></td>                                
                                <td>
                                    <div v-if="conf_for.condicion">
                                        <span class="badge badge-success">Activo</span>
                                    </div>
                                    <div v-else>
                                        <span class="badge badge-danger">Inactivo</span>
                                    </div>
                                    
                                </td>
                                <td>
                                    <button v-if="permisosUser.actualizar" type="button" @click="abrirModal('conf_formatos','actualizar',conf_for)" class="btn btn-warning btn-sm" title="Actualizar">
                                        <i class="icon-pencil"></i>
                                    </button>
                                    <button v-else type="button" class="btn btn-secondary btn-sm" title="Actualizar (Deshabilitado)">
                                        <i class="icon-pencil"></i>
                                    </button> &nbsp;   

                                    <template v-if="permisosUser.anular">
                                        <button v-if="conf_for.condicion" type="button" @click="desactivarConfFormato(conf_for.id)" class="btn btn-danger btn-sm" title="Desactivar">
                                            <i class="icon-trash"></i>
                                        </button>
                                        <button v-else type="button" @click="activarConfFormato(conf_for.id)" class="btn btn-info btn-sm" title="Activar">
                                            <i class="icon-check"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button v-if="conf_for.condicion" type="button" class="btn btn-secondary btn-sm" title="Desactivar (Deshabilitado)">
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
                            <tr><span>Nada para mostrar</span></tr>
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
        </div>
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >Detalles Formato</h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true" title="Cerrar">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-5">
                                    <input type="text" v-model="nombre_formato" class="form-control" placeholder="nombre">
                                </div>
                                <label class="col-md-2 form-control-label" for="text-input">Tipo</label>                      
                                <div class="col-md-3">
                                    
                                    <select v-model="tipo" class="form-control" placeholder="Tipo">                           
                                        <option value="Egreso">Egreso</option>
                                        <option value="Ingreso">Ingreso</option>
                                        <option value="Contables">Contables</option>
                                        <option value="Cuentas">Cuentas</option>                                        
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="text-input">Retencion</label>
                                <div class="col-md-1">                                        
                                    <input type="checkbox" v-model="retencion" class="form-control">
                                </div>
                                <label class="col-md-2 form-control-label" for="text-input">Cierre</label>
                                <div class="col-md-1">                                        
                                    <input type="checkbox" v-model="cierre" class="form-control">
                                </div>
                                <label class="col-md-2 form-control-label" for="text-input">Fiscal</label>
                                <div class="col-md-1">                                        
                                    <input type="checkbox" v-model="fiscal" class="form-control">
                                </div>
                                <label class="col-md-2 form-control-label" for="text-input">Acarreo</label>
                                <div class="col-md-1">                                        
                                    <input type="checkbox" v-model="acarreo" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="text-input">No. Inicio</label>
                                <div class="col-md-3">
                                    <input type="text" v-model="no_inicio" class="form-control" placeholder="No. inicio">
                                </div>                    
                                <label class="col-md-2 form-control-label" for="text-input">Estado</label>                    
                                <div class="col-md-2">
                                    <select v-model="condicion" class="form-control" placeholder="Estado">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>     
                                <label class="col-md-2 form-control-label" for="text-input">Fecha Vence</label>
                                <div class="col-md-1">                                        
                                    <input type="checkbox" v-model="fecha_vence" class="form-control">
                                </div>                              
                            </div>
                            <div v-show="errorConf_formatos" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjConf_formatos" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarConf_formatos()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-success" @click="actualizarConf_formatos()">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    export default {
        props : ['ruta', 'permisosUser'],
        data (){
            return {
                conf_formato_id: 0,
                tipo: '',
                retencion: '',
                no_inicio: '',
                cierre: '',
                acarreo: '',
                depreciacion: '',
                fiscal: '',
                fecha_vence : '',
                niif: '',
                nombre_formato: '',
                condicion: '' ,                
                arrayConf_formatos : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorConf_formatos : 0,
                errorMostrarMsjConf_formatos : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 2,
                criterio : 'nombre_formato',
                buscar : ''

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
            listarConf_formatos (page,buscar,criterio){
                let me=this;
                var url= this.ruta +'/conf_formatos?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayConf_formatos = respuesta.conf_formatos.data;
                    me.pagination = respuesta.pagination;

                    //console.log(response);
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
                me.listarConf_formatos(page,buscar,criterio);
            },
            registrarConf_formatos(){
                if (this.validarConf_formatos()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/conf_formatos/registrar',{
                    'tipo': this.tipo,
                    'retencion':  this.retencion,
                    'no_inicio':  this.no_inicio,
                    'cierre':  this.cierre,
                    'acarreo':  this.acarreo,
                    'depreciacion':  this.depreciacion,
                    'fiscal':  this.fiscal,
                    'niif':  this.niif,
                    'nombre_formato':  this.nombre_formato,
                    'condicion':  this.condicion ,
                    'fecha_vence': this.fecha_vence,
                    'descripcion': this.descripcion
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarConf_formatos(1,'','nombre_formato');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarConf_formatos(){
               if (this.validarConf_formatos()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta +'/conf_formatos/actualizar',{
                    'tipo': this.tipo,
                    'retencion':  this.retencion,
                    'no_inicio':  this.no_inicio,
                    'cierre':  this.cierre,
                    'acarreo':  this.acarreo,
                    'depreciacion':  this.depreciacion,
                    'fiscal':  this.fiscal,
                    'niif':  this.niif,
                    'nombre_formato':  this.nombre_formato,
                    'condicion':  this.condicion ,
                    'fecha_vence': this.fecha_vence,
                    'descripcion': this.descripcion,
                    'id': this.conf_formato_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarConf_formatos(1,'','nombre_formato');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },            
            validarConf_formatos(){
                this.errorConf_formatos=0;
                this.errorMostrarMsjConf_formatos =[];

                if (!this.nombre_formato) this.errorMostrarMsjConf_formatos.push("El nombre del formato no puede estar vacío.");

                if (this.errorMostrarMsjConf_formatos.length) this.errorConf_formatos = 1;

                return this.errorConf_formatos;
            },
            desactivarConfFormato(id){
               Swal.fire({
                title: 'Esta seguro de desactivar este formato?',
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

                    axios.put(this.ruta +'/conf_formatos/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarConf_formatos(1,'','nombre_formato');
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
            activarConfFormato(id){
               Swal.fire({
                title: 'Esta seguro de activar este formato?',
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

                    axios.put(this.ruta +'/conf_formatos/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarConf_formatos(1,'','nombre_formato');
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
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre_formato='';
                this.descripcion='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "conf_formatos":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Formato';
                                this.tipo= '',
                                this.retencion= '',
                                this.no_inicio= '',
                                this.cierre= '',
                                this.acarreo= '',
                                this.depreciacion= '',
                                this.fiscal= '',
                                this.fecha_vence= '',
                                this.niif= '',
                                this.nombre_formato= '',
                                this.condicion= 1 ,
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Formato';
                                this.tipoAccion=2;
                                this.conf_formato_id = data['id'];
                                this.tipo= data['tipo'];
                                this.retencion= data['retencion'];
                                this.no_inicio= data['no_inicio'];
                                this.cierre= data['cierre'];
                                this.acarreo= data['acarreo'];
                                this.depreciacion= data['depreciacion'];
                                this.fiscal= data['fiscalnombre'];
                                this.niif= data['niif'];
                                this.fecha_vence= data['fecha_vence'];
                                this.nombre_formato = data['nombre_formato'];
                                this.condicion= data['condicion'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted(){
            this.listarConf_formatos(1,this.buscar,this.criterio);
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