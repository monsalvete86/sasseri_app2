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
                        <i class="fa fa-align-justify"></i> Colaboradores
                        <button v-if="permisosUser.crear" type="button" @click="abrirModal('colaboradores','registrar')" class="btn btn-primary">
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

                                    <input v-if="permisosUser.leer" type="text" v-model="buscar" @keyup="listarColaboradores(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <input v-else disabled type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar">

                                    <!--<button v-if="permisosUser.leer" type="submit" @click="listarColaboradores(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    <button v-else type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> Buscar</button>-->
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th class="col-md-1">Opciones</th>
                                </tr>
                            </thead>
                            <tbody v-if="permisosUser.leer && arrayColaboradores.length">
                                <tr v-for="colaborador in arrayColaboradores" :key="colaborador.id">
                                    <td v-text="colaborador.colaborador"></td>
                                    <td>
                                        <button v-if="permisosUser.actualizar && colaborador.estado" type="button" @click="abrirModal('colaboradores','actualizar',colaborador)" class="btn btn-warning btn-sm" title="Actualizar">
                                          <i class="icon-pencil"></i>
                                        </button>
                                        <button v-else type="button"  class="btn btn-secondary btn-sm" title="Actualizar (Deshabilitado)">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;

                                        <template v-if="permisosUser.anular">
                                            <button v-if="colaborador.estado" type="button" class="btn btn-danger btn-sm" @click="desactivarColaborador(colaborador.id)" title="Desactivar">
                                                <i class="icon-trash"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-info btn-sm" @click="activarColaborador(colaborador.id)" title="Activar">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button v-if="colaborador.estado" type="button" class="btn btn-secondary btn-sm" title="Desactivar (Deshabilitado)">
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
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="col-md-1 form-control-label float-left" for="text-input">Nombre</label>
                                        <div class="col-md-11 float-right">
                                            <input type="text" v-model="colaborador"  style="width: 96%;" class="form-control float-right">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="col-md-3 form-control-label float-left" for="text-input">Observación</label>
                                        <div class="col-md-9 float-right">
                                            <textarea type="text" v-model="observacion" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="col-md-3 form-control-label float-left" for="text-input">Vendedor</label>
                                        <div class="col-md-9 float-right">
                                            <input type="checkbox" v-model="vendedor" class="form-control" placeholder="Nombre de la concentración">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="col-md-3 form-control-label float-left" for="text-input">Cobrador</label>
                                        <div class="col-md-9 float-right">
                                            <input type="checkbox" v-model="cobrador" class="form-control" placeholder="Nombre de la concentración">
                                        </div>
                                    </div>
                                </div>
                                <div v-show="errorColaboradores" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjColaboradores" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarColaborador()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-success" @click="actualizarColaborador()">Actualizar</button>
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
                colaborador_id: 0,
                colaborador : '',
                observacion : '',
                vendedor : 0,
                cobrador : 0,
                arrayColaboradores : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorColaboradores : 0,
                errorMostrarMsjColaboradores : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 10,
                criterio : 'colaborador',
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
            listarColaboradores (page,buscar,criterio){
                let me=this;
                var url= this.ruta +'/colaboradores?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayColaboradores = respuesta.colaboradores.data;
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
                me.listarColaboradores(page,buscar,criterio);
            },
            registrarColaborador(){
                if (this.validarColaborador()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/colaboradores/registrar',{
                    'colaborador': this.colaborador,
                    'observacion': this.observacion,
                    'vendedor': this.vendedor,
                    'cobrador': this.cobrador,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarColaboradores(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarColaborador(){
                if (this.validarColaborador()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta +'/colaboradores/actualizar',{
                    'colaborador': this.colaborador,
                    'observacion': this.observacion,
                    'vendedor': this.vendedor,
                    'cobrador': this.cobrador,
                    'id': this.colaborador_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarColaboradores(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            validarColaborador(){
                this.errorColaboradores=0;
                this.errorMostrarMsjColaboradores =[];

                if (!this.colaborador || this.colaborador=='') this.errorMostrarMsjColaboradores.push("Ingrese el nombre del colaborador.");

                if (this.errorMostrarMsjColaboradores.length) this.errorColaboradores = 1;

                return this.errorColaboradores;
            },
            desactivarColaborador(id){
               Swal.fire({
                title: 'Esta seguro de desactivar este registro?',
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

                    axios.put(this.ruta +'/colaboradores/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarColaboradores(1,'','nombre');
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
            activarColaborador(id){
               Swal.fire({
                title: 'Esta seguro de activar este registro?',
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

                    axios.put(this.ruta +'/colaboradores/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarColaboradores(1,'','nombre');
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
                this.errorColaboradores = 0;
                this.errorMostrarMsjColaboradores = [];
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "colaboradores":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Colaborador';
                                this.colaborador= '';
                                this.observacion= '';
                                this.vendedor= '';
                                this.cobrador= '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar': 
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Colaborador';
                                this.tipoAccion=2;
                                this.colaborador_id=data['id'];
                                this.colaborador = data['colaborador'];
                                this.observacion = data['observacion'];
                                this.vendedor = data['vendedor'];
                                this.cobrador = data['cobrador'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarColaboradores(1,this.buscar,this.criterio);
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
