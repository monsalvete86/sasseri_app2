<template>
        <main class="main">
            <!-- Breadcrumb -->
            
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Tarifario
                        <button v-if="permisosUser.crear" type="button" @click="abrirModal('tarifario','registrar')" class="btn btn-secondary">
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
                                    <select class="form-control col-md-3" v-model="criterio" @change="listarTarifario(1,buscar,criterio)">
                                      <option value="nombre">Nombre</option>>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup="listarTarifario(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <!--<button type="submit" @click="listarTarifario(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>-->
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="col-md-5">Nombre</th>
                                    <th class="col-md-6">descripcion</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody v-if="permisosUser.leer && arrayTarifario.length">
                                <tr v-for="tarifario in arrayTarifario" :key="tarifario.id">
                                    <td v-text="tarifario.nombre"></td>
                                    <td v-text="tarifario.descripcion"></td>
                                    <td>
                                        <button v-if="permisosUser.actualizar &&tarifario.estado" type="button" @click="abrirModal('tarifario','actualizar',tarifario)" class="btn btn-warning btn-sm" title="Actualizar">
                                          <i class="icon-pencil"></i>
                                        </button>
                                        <button v-else type="button" class="btn btn-secondary btn-sm" title="Actualizar (Deshabilitado)">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;

                                        <template v-if="permisosUser.actualizar">
                                            <button type="button" v-if="tarifario.estado==1" class="btn btn-danger btn-sm" @click="desactivarTarifario(tarifario.id)" title="Desactivar">
                                                <i class="icon-trash"></i>
                                            </button>
                                            
                                            <button type="button" v-else class="btn btn-info btn-sm" @click="activarTarifario(tarifario.id)" title="Activar">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" v-if="tarifario.estado==1" class="btn btn-secondary btn-sm" title="Desactivar (Deshabilitado)">
                                                <i class="icon-trash"></i>
                                            </button>
                                            
                                            <button type="button" v-else class="btn btn-secondary btn-sm"  title="Activar (Deshabilitado)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                </tr>                                
                            </tbody>
                            <tbody v-else>
                                <tr colspan="3">No hay registros para mostrar</tr>
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
                                    <div class="col-md-6">
                                        <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del tarifario">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-md-3 form-control-label" for="text-input">descripcion</label>
                                        <div class="col-md-9">
                                            <textarea v-model="descripcion" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div v-show="errorTarifario" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjTarifario" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarTarifario()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-success" @click="actualizarTarifario()">Actualizar</button>
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
    export default {
        props : ['ruta', 'permisosUser'],
        data (){
            return {
                tarifario_id: 0,
                nombre : '',
                descripcion: '',
                arrayTarifario : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorTarifario : 0,
                errorMostrarMsjTarifario : [],
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
            listarTarifario (page,buscar,criterio){
                let me=this;
                var url= this.ruta +'/tarifario?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayTarifario = respuesta.tarifario.data;
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
                me.listarTarifario(page,buscar,criterio);
            },
            registrarTarifario(){
                if (this.validarTarifario()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/tarifario/registrar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarTarifario(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarTarifario(){
               if (this.validarTarifario()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta +'/tarifario/actualizar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'id': this.tarifario_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarTarifario(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            validarTarifario(){
                this.errorTarifario=0;
                this.errorMostrarMsjTarifario =[];

                if (!this.nombre) this.errorMostrarMsjTarifario.push("El nombre de la presentación no puede estar vacío.");

                if (this.errorMostrarMsjTarifario.length) this.errorTarifario = 1;

                return this.errorTarifario;
            },
            desactivarTarifario(id){
               Swal.fire({
                title: 'Esta seguro de desactivar este tarifario?',
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

                    axios.put(this.ruta +'/tarifario/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarTarifario(1,'','nombre');
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
            activarTarifario(id){
               Swal.fire({
                title: 'Esta seguro de activar este tarifario?',
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

                    axios.put(this.ruta +'/tarifario/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarTarifario(1,'','nombre');
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
                this.nombre='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "tarifario":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar tarifario';
                                this.nombre= '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar tarifario';
                                this.tipoAccion=2;
                                this.tarifario_id=data['id'];
                                this.nombre = data['nombre'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarTarifario(1,this.buscar,this.criterio);
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
