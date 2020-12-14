<template>
    <main class="main">
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Unidad de medida
                    <button v-if="permisosUser.crear" type="button" @click="abrirModal('und_medida','registrar')" class="btn btn-primary">
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

                                <input v-if="permisosUser.leer" type="text" v-model="buscar" @keyup="listarUndMedida(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <input v-else disabled type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar">

                                <!--<button v-if="permisosUser.leer" type="submit" @click="listarUndMedida(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                <button v-else type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> Buscar</button>-->
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm table-responsive table-earning">
                        <thead>
                            <tr>
                                <th class="col-md-11">Nombre</th>
                                <th class="td-estado">Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody v-if="permisosUser.leer && arrayUndMedida.length">
                            <tr v-for="und_medida in arrayUndMedida" :key="und_medida.id">
                                <td v-text="und_medida.nombre"></td>
                                <td class="td-estado">
                                     <template v-if="permisosUser.anular">
                                        <a v-if="und_medida.estado" href="#" class="btn text-success" @click="desactivarUndMedida(und_medida.id)" title="Desactivar">
                                            <i class="fa fa-check-circle"></i>
                                        </a>
                                        <a v-else href="#" class="btn text-danger" @click="activarUndMedida(und_medida.id)" title="Activar">
                                            <i class="fa fa-times-circle"></i>
                                        </a>
                                    </template>
                                    <template v-else>
                                        <a v-if="und_medida.estado" href="#" class="btn text-secondary" title="Desactivar (Deshabilitado)">
                                            <i class="fa fa-check-circle"></i>
                                        </a>
                                        <a v-else href="#" class="btn text-secondary" title="Activar (Deshabilitado)">
                                            <i class="fa fa-times-circle"></i>
                                        </a>
                                    </template>
                                </td>
                                <td>
                                    <button v-if="permisosUser.actualizar && und_medida.estado" type="button" @click="abrirModal('und_medida','actualizar',und_medida)" class="btn btn-success btn-sm" title="Actualizar">
                                        <i class="icon-pencil"></i>
                                    </button>
                                    <button v-else type="button" class="btn btn-secondary btn-sm" title="Actualizar (Deshabilitado)">
                                        <i class="icon-pencil"></i>
                                    </button> &nbsp;                                   
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
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de la unidad de medida">
                                    
                                </div>
                            </div>
                            <div v-show="errorUndMedida" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjUndMedida" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarUndMedida()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-success" @click="actualizarUndMedida()">Actualizar</button>
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
                und_medida_id: 0,
                nombre : '',
                arrayUndMedida : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorUndMedida : 0,
                errorMostrarMsjUndMedida : [],
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
            listarUndMedida (page,buscar,criterio){
                let me=this;
                var url= this.ruta +'/und_medida?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayUndMedida = respuesta.und_medida.data;
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
                me.listarUndMedida(page,buscar,criterio);
            },
            registrarUndMedida(){
                if (this.validarUndMedida()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/und_medida/registrar',{
                    'nombre': this.nombre,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarUndMedida(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarUndMedida(){
               if (this.validarUndMedida()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta +'/und_medida/actualizar',{
                    'nombre': this.nombre,
                    'id': this.und_medida_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarUndMedida(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            validarUndMedida(){
                this.errorUndMedida=0;
                this.errorMostrarMsjUndMedida =[];

                if (!this.nombre) this.errorMostrarMsjUndMedida.push("El nombre de la presentación no puede estar vacío.");

                if (this.errorMostrarMsjUndMedida.length) this.errorUndMedida = 1;

                return this.errorUndMedida;
            },
            desactivarUndMedida(id){
               Swal.fire({
                title: 'Esta seguro de desactivar esta unidad de medida?',
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

                    axios.put(this.ruta +'/und_medida/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarUndMedida(1,'','nombre');
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
            activarUndMedida(id){
               Swal.fire({
                title: 'Esta seguro de activar esta unidad de medida?',
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

                    axios.put(this.ruta +'/und_medida/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarUndMedida(1,'','nombre');
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
                    case "und_medida":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Unidad De Medida';
                                this.nombre= '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Unidad De Medida';
                                this.tipoAccion=2;
                                this.und_medida_id=data['id'];
                                this.nombre = data['nombre'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarUndMedida(1,this.buscar,this.criterio);
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
