<template>
            <main class="main">
            <!-- Breadcrumb -->
            
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Roles
                        <button type="button" @click="abrirModal('roles','registrar')" class="btn btn-primary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio" @change="listarRol(1,buscar,criterio)">
                                      <option value="nombre">Nombre</option>
                                    </select>

                                    <input type="text" v-model="buscar" @keyup="listarRol(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">

                                    <!--<button type="submit" @click="listarRol(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>-->
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm  table-responsive">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th class="col-md-1">Estado</th>
                                    <th class="col-md-1">Opciones</th>
                                </tr>
                            </thead>
                            <tbody v-if="arrayRol.length">
                                <tr v-for="rol in arrayRol" :key="rol.nombre">
                                    <td v-text="rol.nombre"></td>
                                    <td>
                                        <div v-if="rol.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                    </td>
                                    <td>
                                        <button  v-if="rol.estado" type="button" @click="abrirModal('roles','actualizar',rol)" class="btn btn-warning btn-sm" title="Actualizar">
                                          <i class="icon-pencil"></i>
                                        </button>

                                        <button  v-else type="button" class="btn btn-secondary btn-sm" title="Actualizar (Deshabilitado)">
                                          <i class="icon-pencil"></i>
                                        </button>

                                        <template>
                                            <button v-if="rol.estado" type="button" class="btn btn-danger btn-sm" @click="desactivarRol(rol.id)" title="Desactivar">
                                                <i class="icon-trash"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-info btn-sm" @click="activarRol(rol.id)" title="Activar">
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
                                        <label class="col-md-3 form-control-label" for="text-input">Nombre (*)</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del rol">
                                        </div>
                                    </div>
                                    <div class="row" style="padding: 0em 1em;">
                                        <table class="table table-bordered table-striped table-sm  table-responsive" style="overflow-y: auto;max-height: 26em !important;display: block;border: none;">
                                            <thead>
                                                <tr>
                                                    <th>Modulo</th>
                                                    <th>Ver</th>
                                                    <th>Crear</th>
                                                    <th>Editar</th>
                                                    <th>Anular</th>
                                                    <th>Imprimir</th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="arrayPermisos.length">
                                                <tr v-for="permisos in arrayPermisos" :key="permisos.id">
                                                    <td v-if="permisos.tipo==1" v-text="permisos.nombre" style="background: #dae3e8;"></td>
                                                    <td v-else v-text="permisos.nombre" style="background: #ffffff; padding-left: 1em;"></td>

                                                    <td v-if="permisos.tipo==1" style="background: #dae3e8;" ><input type="checkbox" v-model="permisos.lectura" value=""></td>
                                                    <td v-else style="background: #ffffff;" ><input type="checkbox" v-model="permisos.lectura" value=""></td>

                                                    <td v-if="permisos.tipo==1" style="background: #dae3e8;" ><input type="checkbox" v-model="permisos.escritura" value=""></td>
                                                    <td v-else style="background: #ffffff;" ><input type="checkbox" v-model="permisos.escritura" value=""></td>

                                                    <td v-if="permisos.tipo==1" style="background: #dae3e8;" ><input type="checkbox" v-model="permisos.edicion" value=""></td>
                                                    <td v-else style="background: #ffffff;" ><input type="checkbox" v-model="permisos.edicion" value=""></td>

                                                    <td v-if="permisos.tipo==1" style="background: #dae3e8;" ><input type="checkbox" v-model="permisos.anular" value=""></td>
                                                    <td v-else style="background: #ffffff;" ><input type="checkbox" v-model="permisos.anular" value=""></td>

                                                    <td v-if="permisos.tipo==1" style="background: #dae3e8;" ><input type="checkbox" v-model="permisos.imprimir" value=""></td>
                                                    <td v-else style="background: #ffffff;" ><input type="checkbox" v-model="permisos.imprimir" value=""></td>
                                                </tr>

                                                <!--<tr v-for="permisos in arrayPermisos" :key="permisos.id">
                                                    <td v-text="permisos.nombre"></td>

                                                    <td><input type="checkbox" v-model="permisos.lectura" value=""></td>

                                                    <td><input type="checkbox" v-model="permisos.escritura" value=""></td>

                                                    <td><input type="checkbox" v-model="permisos.edicion" value=""></td>

                                                    <td><input type="checkbox" v-model="permisos.anular" value=""></td>

                                                    <td><input type="checkbox" v-model="permisos.imprimir" value=""></td>
                                                </tr>-->
                                            </tbody>
                                            <tbody v-else>
                                                <tr colspan="6">No hay registros para mostrar</tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                            <div v-show="errorRol" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjRol" :key="error" v-text="error">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarRol()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-success" @click="actualizarRol()">Actualizar</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!--Fin del modal-->
            </div>
        </main>
</template>

<script>
    export default {
        props : ['ruta'],
        data (){
            return {
                rol_id: 0,
                nombre : '',
                validarNombre : '',
                id_modulo: 0,
                lectura : 0,
                escritura: 0,
                edicion : 0,
                imprimir : 0,
                arrayRol : [],
                arrayModulos: [],
                arrayNombresRoles:[],
                arrayPermisos : [],
                errorRol : [],
                errorMostrarMsjRol : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
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
            listarRol (page,buscar,criterio){
                let me=this;
                
                var url= this.ruta+'/rol?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRol = respuesta.roles;
                    me.pagination= respuesta.pagination;
                    me.arrayNombresRoles = respuesta.roles2.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarModulos(page,buscar,criterio){
                let me=this;
                var url= this.ruta+'/modulo' ;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayModulos = respuesta.modulos;
                    // me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarPermisos(rol_id){
                let me=this;
                
                var url= this.ruta+'/rol/permisos?id_rol='+rol_id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPermisos = respuesta.permisos;
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
                me.listarRol(page,buscar,criterio);
            },
            registrarRol(){
                if (this.validarRol()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/rol/registrar',{
                    'nombre': this.nombre,
                    'id_modulo': this.id_modulo,
                    'lectura': this.lectura,
                    'escritura': this.escritura,
                    'edicion': this.edicion,
                    'anular': this.anular,
                    'imprimir': this.imprimir,
                    'modulos' : this.arrayPermisos
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarRol(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarRol(){
                if (this.validarRol()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta +'/rol/actualizar',{
                    'nombre': this.nombre,
                    'nombreAnterior': this.validarNombre,
                    'modulos' : this.arrayPermisos,
                    'id': this.rol_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarRol(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },            
            validarRol(){
                let me = this;
                me.errorRol=0;
                me.errorMostrarMsjRol =[];

                if (!me.nombre) me.errorMostrarMsjRol.push("El nombre de la Rol no puede estar vacío.");
                
                for(var r=0; r<me.arrayRol.length; r++)
                {
                    if(me.tipoAccion==1 && me.arrayRol[r]['nombre']==me.nombre) me.errorMostrarMsjRol.push("El nombre del rol ya se encuentra registrado");

                    if(me.tipoAccion==2 && me.validarNombre!=me.nombre && me.nombre==me.arrayRol[r]['nombre']) me.errorMostrarMsjRol.push("El nombre del rol ya se encuentra registrado");
                }

                var ban = 0;
                if(me.arrayPermisos.length!=0)
                {
                    for(var p=0; p<me.arrayPermisos.length; p++)
                    {
                        if((!me.arrayPermisos[p]['lectura'] || me.arrayPermisos[p]['lectura']!=true) && (!me.arrayPermisos[p]['escritura'] || me.arrayPermisos[p]['escritura']!=true) && (!me.arrayPermisos[p]['edicion'] || me.arrayPermisos[p]['edicion']!=true) && (!me.arrayPermisos[p]['anular'] || me.arrayPermisos[p]['anular']!=true) && (!me.arrayPermisos[p]['imprimir'] || me.arrayPermisos[p]['imprimir']!=true))
                        {
                            ban = 1;
                        }
                    }
                }

                if (ban) me.errorMostrarMsjRol.push("Debe asignar por lo menos un permiso.");

                if (me.errorMostrarMsjRol.length) me.errorRol = 1;

                return me.errorRol;
            },
            desactivarRol(id){
               Swal.fire({
                title: 'Esta seguro de desactivar este rol?',
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

                    axios.put(this.ruta +'/rol/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarRol(1,'','nombre');
                        Swal.fire(
                        'Desactivado!',
                        'El rol ha sido desactivado con éxito.',
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
            activarRol(id){
               Swal.fire({
                title: 'Esta seguro de activar este rol?',
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

                    axios.put(this.ruta +'/rol/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarRol(1,'','nombre');
                        Swal.fire(
                        'Activado!',
                        'El rol ha sido activado con éxito.',
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
                this.tipoAccion = 0;
                this.nombre = '';
                this.id_modulo = 0;
                this.lectura = 0;
                this.escritura = 0;
                this.edicion = 0;
                this.anular = 0;
                this.imprimir = 0;
                this.rol_id = 0;
                this.errorRol = 0;
                this.errorMostrarMsjRol = [];
                this.arrayModulos = [];
                this.arrayPermisos = [];
            },
            abrirModal(modelo, accion, data = []){
                let me = this;
                switch(modelo){
                    case "roles":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar rol';
                                this.tipoAccion = 1;
                                this.nombre= '';
                                this.id_modulo = 0;
                                this.lectura = 0;
                                this.escritura = 0;
                                this.edicion = 0;
                                this.anular = 0;
                                this.imprimir = 0;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.rol_id = data['id'];
                                this.modal=1;
                                this.tituloModal='Actualizar Rol';
                                this.tipoAccion=2;
                                this.nombre = data['nombre'];
                                this.validarNombre = data['nombre'];
                                break;
                            }
                        }
                        this.listarPermisos(this.rol_id);
                    }
                }
            }
        },
        mounted() {
            this.listarRol(1,this.buscar,this.criterio);
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
