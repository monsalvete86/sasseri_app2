<template>
            <main class="main">
            <!-- Breadcrumb -->
            
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Usuarios
                        <button type="button" @click="abrirModal('persona','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="num_documento">Documento</option>
                                      <option value="email">Email</option>
                                      <option value="telefono">Teléfono</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm table-earning table-responsive table-earning">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tipo Documento</th>
                                    <th>Número</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Usuario</th>
                                    <th>Role</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="persona in arrayPersona" :key="persona.id">
                                    <td v-text="persona.nombre"></td>
                                    <td v-text="persona.tipo_documento"></td>
                                    <td v-text="persona.num_documento"></td>
                                    <td v-text="persona.direccion"></td>
                                    <td v-text="persona.telefono1"></td>
                                    <td v-text="persona.email"></td>
                                    <td v-text="persona.usuario"></td>
                                    <td v-text="persona.rol"></td>
                                    <td class="td-estado">
                                        <template v-if="persona.condicion">
                                            <a href="#" class="btn text-success" title="Desactivar usuario" @click="desactivarUsuario(persona.id)">
                                                <i class="fa fa-check-circle"></i>
                                            </a>
                                        </template>
                                        <template v-else>
                                            <a href="#" class="btn text-danger" title="Activar Usuario" @click="activarUsuario(persona.id)">
                                                <i class="fa fa-times-circle"></i>
                                            </a>
                                        </template>
                                    </td>
                                    <td>
                                        <button href="#" @click="abrirModal('persona','permisos', [persona.id, persona.nombre])" class="btn btn-primary btn-sm">
                                          <i class="icon-list"></i>
                                        </button> &nbsp;
                                        <button href="#" @click="abrirModal('persona','actualizar',persona)" class="btn btn-success btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example">
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
                <div class="modal-dialog modal-primary modal-lgx" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                
                                <div class="form-group">
                                    <label for="text-input">Nombre(*)</label>                                   
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de la persona">
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="text-input">Tipo documento</label>                                       
                                        <select v-model="tipo_documento" class="form-control">
                                            <option value="DNI">DNI</option>
                                            <option value="RUC">RUC</option>
                                            <option value="CEDULA">CEDULA</option>
                                            <option value="PASS">PASS</option>
                                        </select>  
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="dni-input">Número documento</label>                                     
                                        <input type="text" v-model="num_documento" class="form-control" placeholder="Número de documento">                                     
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="address-input">Dirección</label>                                        
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Dirección">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email-input">Teléfono</label>                                        
                                        <input type="tel" v-model="telefono" class="form-control" placeholder="Teléfono">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="email-input">Email</label>                                       
                                        <input type="email" v-model="email" class="form-control" placeholder="Email">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email-input">Role</label>                                       
                                        <select v-model="idrol" class="form-control">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="role in arrayRol" :key="role.id" :value="role.id" v-text="role.nombre"></option>
                                        </select>
                                       
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="email-input">Usuario</label>                                       
                                        <input type="text" v-model="usuario" class="form-control" placeholder="Nombre del usuario">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email-input">password</label>                                       
                                        <input type="password" v-model="password" class="form-control" placeholder="password del usuario">
                                    </div>
                                </div>
                                <div v-show="errorPersona" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            <!--Inicio modal permisos-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalPermisos}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModalPermisos()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                    <div class="form-group row">
                                        <h5 class="col-md-4">Marcar permisos como</h5>
                                        <select class="col-md-4 custom-select custom-select-sm" @change="marcarPermisosRol" v-model="idrol">
                                            <option value="" disabled>Seleccione un rol</option>
                                            <option v-for="rol in arrRolesEmpresa" :value="rol.id" v-text="rol.nombre"></option>
                                        </select>
                                    </div>
                                <!-- Inicio tabla permisos -->
                                <!--<div class="card">
                                    <div class="card-header">
                                    <!--</div>-->
                                    <!--<div class="card-body">-->
                                        <table class="table table-bordered table-sm" style="overflow-y: auto;max-height: 26em !important;display: block;border: none;">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-7">Módulo</th>
                                                    <th class="col-md-1">Crear</th>
                                                    <th class="col-md-1">Leer</th>
                                                    <th class="col-md-1">Actualizar</th>
                                                    <th class="col-md-1">Anular</th>
                                                    <th class="col-md-1">Imprimir</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr :class="moduloPermisos.padre == null ? 'table-info' : 'table-light'" v-for="(moduloPermisos, key) in arrModulosPermisos" :key="moduloPermisos.id_modulos_empresas">
                                                    <td v-text="moduloPermisos.nombre"></td>
                                                    <td>
                                                        <input v-if="moduloPermisos.padre == null" v-model="moduloPermisos.crear" @click="alternarMarcaHijos(key, 'crear')" type="checkbox">
                                                        <input v-else v-model="moduloPermisos.crear" @click="marcarPadre(key, 'crear')" type="checkbox">
                                                    </td>
                                                    <td>
                                                        <input v-if="moduloPermisos.padre == null" v-model="moduloPermisos.leer" @click="alternarMarcaHijos(key, 'leer')" type="checkbox">
                                                        <input v-else v-model="moduloPermisos.leer" @click="marcarPadre(key, 'leer')" type="checkbox">
                                                    </td>
                                                    <td>
                                                        <input v-if="moduloPermisos.padre == null" v-model="moduloPermisos.actualizar" @click="alternarMarcaHijos(key, 'actualizar')" type="checkbox">
                                                        <input v-else v-model="moduloPermisos.actualizar" @click="marcarPadre(key, 'actualizar')" type="checkbox">
                                                    </td>
                                                    <td>
                                                        <input v-if="moduloPermisos.padre == null" v-model="moduloPermisos.anular" @click="alternarMarcaHijos(key, 'anular')" type="checkbox">
                                                        <input v-else v-model="moduloPermisos.anular" @click="marcarPadre(key, 'anular')" type="checkbox">
                                                    </td>
                                                    <td>
                                                        <input v-if="moduloPermisos.padre == null" v-model="moduloPermisos.imprimir" @click="alternarMarcaHijos(key, 'imprimir')" type="checkbox">
                                                        <input v-else v-model="moduloPermisos.imprimir" @click="marcarPadre(key, 'imprimir')" type="checkbox">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <!--</div>-->
                                <!--</div>-->
                                <!--Fin tabla permisos-->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModalPermisos()">Cerrar</button>
                            <!-- DEBE MODIFICARSE------------------------------------------------------------------------------------------>
                            <button type="button" class="btn btn-primary" @click="guardarPermisos()">Guardar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin modal permisos-->
                        
        </main>
</template>

<script>
    export default {
        props : ['ruta'],
        data ()
        {
            return {
                persona_id: 0,
                nombre : '',
                tipo_documento : '',
                num_documento : '',
                direccion : '',
                telefono : '',
                email : '',
                usuario: '',
                password:'',
                idrol: '',
                arrayPersona : [],
                arrayRol : [],
                arrRolesEmpresa: [],
                arrRolesPermisos : [],
                arrModulosPermisos : [], // Carga la tabla permisos
                cargarSelectorRoles : true,
                modal : 0,
                modalPermisos : 0, // Para abrir y cerrar el modal permisos
                tituloModal : '',
                tipoAccion : 0,
                errorPersona : 0,
                errorMostrarMsjPersona : [],
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
        computed :
        {
            isActived: function ()
            {
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function ()
            {
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
        methods :
        {
            listarPersona (page,buscar,criterio)
            {
                let me=this;
                var url= this.ruta +'/user?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPersona = respuesta.personas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            
            // Obtiene los permisos del usuario por módulo
            listarPermisos (usuario_id)
            {
                let me = this;
                var url = `${this.ruta}/listar_permisos`;
                axios.post(url, {'usuario_id':usuario_id, 'cargarSelector':me.cargarSelectorRoles}).then(function (response) {
                    if (me.cargarSelectorRoles) {
                        me.arrRolesEmpresa = response.data.roles;
                        me.arrRolesPermisos = response.data.rolesPermisos;
                        me.cargarSelectorRoles = false;
                    }
                    me.arrModulosPermisos = response.data.permisos;
                    me.arrModulosPermisos.forEach((moduloPermisos) => {
                            moduloPermisos.usuarios_id = usuario_id;
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            guardarPermisos ()
            {
                let me = this;
                var url = `${this.ruta}/permisos`;
                
                axios.post(url, me.arrModulosPermisos).then(function (response) {
                    me.cerrarModalPermisos();
                    me.recargarPermisos();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            marcarPermisosRol ()
            {
                var idPadre = 0;

                this.arrRolesPermisos.forEach((rolPermisos) => {
                    if(rolPermisos.id_rol == this.idrol) {
                        this.arrModulosPermisos.forEach((moduloPermisos, indice) => {
                            if (moduloPermisos.modulos_id == rolPermisos.id_modulo) {
                                if (moduloPermisos.padre != idPadre && moduloPermisos.padre != null) {
                                    idPadre = moduloPermisos.padre;
                                    if (rolPermisos.escritura == 1) {this.marcarPadre(indice, 'crear');}
                                    if (rolPermisos.lectura == 1) {this.marcarPadre(indice, 'leer');}
                                    if (rolPermisos.edicion == 1) {this.marcarPadre(indice, 'actualizar');}
                                    if (rolPermisos.anular == 1) {this.marcarPadre(indice, 'anular');}
                                    if (rolPermisos.imprimir == 1) {this.marcarPadre(indice, 'imprimir');}
                                }
                                moduloPermisos.crear = rolPermisos.escritura;
                                moduloPermisos.leer = rolPermisos.lectura;
                                moduloPermisos.actualizar = rolPermisos.edicion;
                                moduloPermisos.anular = rolPermisos.anular;
                                moduloPermisos.imprimir = rolPermisos.imprimir;
                            }
                        }, this);
                    }
                }, this);
            },
            alternarMarcaHijos (claveModulo, accion)
            {
                var marcaHijos = this.arrModulosPermisos[claveModulo][accion] = !this.arrModulosPermisos[claveModulo][accion];
                for (var i = claveModulo + 1; (i < (this.arrModulosPermisos.length)) ? (this.arrModulosPermisos[i].padre != null) ? true : false : false; i++) {
                    this.arrModulosPermisos[i][accion] = marcaHijos;
                }
            },
            marcarPadre (claveModulo, accion)
            {
                for (var i = claveModulo - 1; i >= 0; i--) {
                    if (this.arrModulosPermisos[i].padre == null) {
                        this.arrModulosPermisos[i][accion] = true;
                        break;
                    }
                }
            },
            selectRol ()
            {
                let me=this;
                var url= this.ruta +'/rol/selectRol';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayRol = respuesta.roles;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            cambiarPagina (page,buscar,criterio)
            {
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarPersona(page,buscar,criterio);
            },
            registrarPersona ()
            {
                if (this.validarPersona()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/user/registrar',{
                    'nombre': this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'idrol' : this.idrol,
                    'usuario': this.usuario,
                    'password': this.password

                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarPersona ()
            {
               if (this.validarPersona()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta +'/user/actualizar',{
                    'nombre': this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'idrol' : this.idrol,
                    'usuario': this.usuario,
                    'password': this.password,
                    'id': this.persona_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            validarPersona ()
            {
                this.errorPersona=0;
                this.errorMostrarMsjPersona =[];

                if (!this.nombre) this.errorMostrarMsjPersona.push("El nombre de la pesona no puede estar vacío.");
                if (!this.usuario) this.errorMostrarMsjPersona.push("El nombre de usuario no puede estar vacío.");
                if (!this.password) this.errorMostrarMsjPersona.push("La password del usuario no puede estar vacía.");
                if (this.idrol==0) this.errorMostrarMsjPersona.push("Seleccione una Role.");
                if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;

                return this.errorPersona;
            },
            cerrarModal ()
            {
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.tipo_documento='DNI';
                this.num_documento='';
                this.direccion='';
                this.telefono='';
                this.email='';
                this.usuario='';
                this.password='';
                this.idrol=0;
                this.errorPersona=0;
            },
            cerrarModalPermisos ()
            {
                this.modalPermisos = 0;
                this.tituloModal = '';
                this.arrModulosPermisos = [];
                this.idrol = '';
            },
            recargarPermisos()
            {
                let me=this;
                var url= this.ruta +'/permisos/recargarPermisos';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    // var respuesta= response.data;
                    // me.arrayRol = respuesta.roles;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            abrirModal (modelo, accion, data = [])
            {
                this.selectRol();
                switch(modelo){
                    case "persona":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Usuario';
                                this.nombre= '';
                                this.tipo_documento='DNI';
                                this.num_documento='';
                                this.direccion='';
                                this.telefono='';
                                this.email='';
                                this.usuario='';
                                this.password='';
                                this.idrol=0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Usuario';
                                this.tipoAccion=2;
                                this.persona_id=data['id'];
                                this.nombre = data['nombre'];
                                this.tipo_documento = data['tipo_documento'];
                                this.num_documento = data['num_documento'];
                                this.direccion = data['direccion'];
                                this.telefono = data['telefono'];
                                this.email = data['email'];
                                this.usuario = data['usuario'];
                                this.password=data['password'];
                                this.idrol=data['idrol'];
                                break;
                            }
                            case 'permisos':
                            {
                                this.modalPermisos = 1;
                                this.tituloModal = 'Permisos ' + data[1];
                                this.persona_id = data[0];
                                this.listarPermisos(data[0]);
                                break;
                            }
                        }
                    }
                }
            },
            desactivarUsuario (id)
            {
               Swal.fire({
                title: 'Esta seguro de desactivar este usuario?',
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

                    axios.put(this.ruta +'/user/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarPersona(1,'','nombre');
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
            activarUsuario (id)
            {
               Swal.fire({
                title: 'Esta seguro de activar este usuario?',
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

                    axios.put(this.ruta +'/user/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarPersona(1,'','nombre');
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
        },
        mounted() {
            this.listarPersona(1,this.buscar,this.criterio);
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
