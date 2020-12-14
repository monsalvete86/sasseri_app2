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
                        <i class="fa fa-align-justify"></i> Formatos por proceso
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-md-4 float-left">Compras</label>
                                <div class="col-md-8 float-right">
                                    <select class="form-control"  @change="registrarFormatoContrato()" v-model="idFormatoCompras">
                                        <option v-for="conf_formato in arrayConf_formatos" :key="conf_formato.id" :value="conf_formato.id" v-text="conf_formato.nombre_formato"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-md-4 float-left">Ventas</label>
                                <div class="col-md-8 float-right">
                                    <select class="form-control" @change="registrarFormatoContrato()" v-model="idFormatoVentas">
                                        <option v-for="conf_formato in arrayConf_formatos" :key="conf_formato.id" :value="conf_formato.id" v-text="conf_formato.nombre_formato"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-md-4 float-left">Salidas</label>
                                <div class="col-md-8 float-right">
                                    <select class="form-control" @change="registrarFormatoContrato()" v-model="idFormatoSalidas">
                                        <option v-for="conf_formato in arrayConf_formatos" :key="conf_formato.id" :value="conf_formato.id" v-text="conf_formato.nombre_formato"></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <!---<div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
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
                                <div v-show="errorFormato" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjFormatoProceso" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarFormatoContrato()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarFormatoContrato()">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>-->
            <!--Fin del modal-->
        </main>
</template>

<script>
    export default {
        props : ['ruta', 'permisosUser'],
        data (){
            return {
                formatoProceso_id: 0,
                nombre : '',
                idFormatoCompras : 0,
                idFormatoVentas : 0,
                idFormatoSalidas : 0,
                arrayFormatoProceso : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorFormato : 0,
                errorMostrarMsjFormatoProceso : [],
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

                arrayConf_formatos : [],
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
            listarFormatoProcesos (page,buscar,criterio){
                let me=this;
                var url= this.ruta +'/formato_proceso';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayFormatoProceso = respuesta.formato_proceso.data;
                    me.idFormatoCompras = me.arrayFormatoProceso[0]['idFormatoCompras'];
                    me.idFormatoVentas = me.arrayFormatoProceso[0]['idFormatoVentas'];
                    me.idFormatoSalidas = me.arrayFormatoProceso[0]['idFormatoSalidas'];
                    
                    me.pagination= respuesta.pagination;
                    me.listarConf_formatos(1,'','');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarConf_formatos(page,buscar,criterio){
                let me=this;
                var url= this.ruta +'/conf_formatos?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayConf_formatos = respuesta.conf_formatos.data;
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
                me.listarFormatoProcesos(page,buscar,criterio);
            },
            registrarFormatoContrato(){
                // if (this.validarConcentracion()){
                //     return;
                // }
                
                let me = this;

                axios.post(this.ruta +'/formato_proceso/registrar',{
                    'idFormatoCompras': this.idFormatoCompras,
                    'idFormatoVentas': this.idFormatoVentas,
                    'idFormatoSalidas': this.idFormatoSalidas,
                }).then(function (response) {
                    Swal.fire({
                        // toast: true,
                        // position: 'top-end',
                        type: 'success',
                        title: 'Registro Guardado',
                        position: 'center',
                        showConfirmButton: false,
                        timer: 1700
                    })

                    // me.cerrarModal();
                    // me.listarFormatoProcesos(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarFormatoContrato(){
            //    if (this.validarConcentracion()){
            //         return;
            //     }
                
                let me = this;

                axios.put(this.ruta +'/formato_proceso/actualizar',{
                    'idFormatoCompras': this.idFormatoCompras,
                    'idFormatoVentas': this.idFormatoVentas,
                    'idFormatoSalidas': this.idFormatoSalidas,
                    'id': this.formatoProceso_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarFormatoProcesos(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            validarConcentracion(){
                this.errorFormato=0;
                this.errorMostrarMsjFormatoProceso =[];

                if (!this.nombre) this.errorMostrarMsjFormatoProceso.push("El nombre de la presentación no puede estar vacío.");

                if (this.errorMostrarMsjFormatoProceso.length) this.errorFormato = 1;

                return this.errorFormato;
            },
            desactivarFormatoProceso(id){
               swal({
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

                    axios.put(this.ruta +'/formato_proceso/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarFormatoProcesos(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
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
            activarFormatoProceso(id){
               swal({
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

                    axios.put(this.ruta +'/formato_proceso/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarFormatoProcesos(1,'','nombre');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
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
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "formatoProceso":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar formato proceso';
                                this.nombre= '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar formato proceso';
                                this.tipoAccion=2;
                                this.formatoProceso_id=data['id'];
                                this.nombre = data['nombre'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarFormatoProcesos(1,this.buscar,this.criterio);
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
