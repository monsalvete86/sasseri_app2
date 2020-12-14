<template>
    <main class="main">
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Clientes
                    <button v-if="permisosUser.crear" type="button" @click="abrirModal('persona','registrar')" class="btn btn-primary">
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
                                <select v-if="permisosUser.leer" class="form-control col-md-3" v-model="criterio" @click="listarPersona(1,buscar,criterio)">
                                    <option value="nombre">Nombre</option>
                                    <option value="num_documento">Documento</option>
                                    <option value="email">Email</option>
                                    <option value="telefono">Teléfono</option>
                                </select>
                                <select v-else disabled class="form-control col-md-3" v-model="criterio">
                                </select>

                                <input v-if="permisosUser.leer" type="text" v-model="buscar" @keyup="listarPersona(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <input v-else disabled type="text" v-model="buscar"  class="form-control" placeholder="Texto a buscar">

                                <!--<button v-if="permisosUser.leer" type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                <button v-else type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> Buscar</button>-->
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Tipo Documento</th>
                                <th>Número</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody v-if="permisosUser.leer">
                            <tr v-for="persona in arrayPersona" :key="persona.id">
                                <td v-text="persona.nombre"></td>
                                <td v-text="persona.tipo_documento"></td>
                                <td v-text="persona.num_documento"></td>
                                <td v-text="persona.direccion"></td>
                                <td v-text="persona.telefono"></td>
                                <td v-text="persona.email"></td>
                                <td>
                                    <button v-if="permisosUser.actualizar" type="button" @click="abrirModal('persona','actualizar',persona)" class="btn btn-warning btn-sm" title="Actualizar">
                                        <i class="icon-pencil"></i>
                                    </button>
                                    <button v-else type="button" class="btn btn-secondary btn-sm" title="Actualizar (Deshabilitado)">
                                        <i class="icon-pencil"></i>
                                    </button>
                                </td>
                            </tr>                                
                        </tbody>
                        <tbody v-else>
                            <tr><td colspan="7">No hay resultados para mostrar</td></tr>
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
                                <label class="col-md-3 form-control-label" for="text-input">Nombre (*)</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de la persona" v-bind:class="{ 'is-invalid' : hasError.nombre==1 }">                                        
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Tipo Documento</label>
                                <div class="col-md-9">
                                    <select v-model="tipo_documento" class="form-control"  v-bind:class="{ 'is-invalid' : hasError.tipo_documento==1 }">
                                        <option value="CC">Cedula de Ciudadania</option>
                                        <option value="NIT">NIT</option>
                                        <option value="CE">Cedula de Extrangeria</option>
                                        <option value="NA">Otro</option>
                                    </select>                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Número</label>
                                <div class="col-md-9">
                                    <input type="number" v-model="num_documento" class="form-control" placeholder="Número de documento"  v-bind:class="{ 'is-invalid' : hasError.num_documento==1 }" :min="1" @blur="function(){if(num_documento<=0) num_documento=1;}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Dirección</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="direccion" class="form-control" placeholder="Dirección"  v-bind:class="{ 'is-invalid' : hasError.direccion==1 }">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Teléfono</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="telefono" class="form-control" placeholder="Teléfono"  v-bind:class="{ 'is-invalid' : hasError.telefono==1 }" :min="1" @blur="function(){if(telefono<=0) telefono=1;}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Email</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="email" class="form-control" placeholder="Email"  v-bind:class="{ 'is-invalid' : hasError.email==1 }">
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
    </main>
</template>

<script>
    export default {
        props : ['ruta', 'permisosUser'],
        data (){
            return {
                persona_id: 0,
                nombre : '',
                tipo_documento : 'DNI',
                num_documento : '',
                direccion : '',
                telefono : '',
                email : '',
                arrayPersona : [],
                modal : 0,
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
                buscar : '',
                hasError: {
                    nombre : 0,
                    tipo_documento : 0,
                    num_documento : 0,
                    direccion : 0,
                    telefono : 0,
                    email : 0,
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
            listarPersona (page,buscar,criterio){
                let me=this;
                var url= this.ruta +'/cliente?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPersona = respuesta.personas.data;
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
                me.listarPersona(page,buscar,criterio);
            },
            registrarPersona(){
                if (this.validarPersona()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/cliente/registrar',{
                    'nombre': this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarPersona(){
               if (this.validarPersona()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta +'/cliente/actualizar',{
                    'nombre': this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'id': this.persona_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },            
            validarPersona(){
                this.hasError['nombre'] = 0;
                this.hasError['tipo_documento'] = 0;
                this.hasError['num_documento'] = 0;
                this.hasError['direccion'] = 0;
                this.hasError['telefono'] = 0;
                this.hasError['email'] = 0;

                this.errorPersona=0;
                this.errorMostrarMsjPersona =[];

                if (!this.nombre) { this.errorPersona=1; this.hasError['nombre']=1;}
                if (!this.tipo_documento || this.tipo_documento=='' || this.tipo_documento==0) { this.errorPersona=1; this.hasError['tipo_documento']=1;}
                if (!this.num_documento || this.num_documento<=0 || this.num_documento==null || this.num_documento=='') { this.errorPersona=1; this.hasError['num_documento']=1;}
                if (!this.direccion || this.direccion<=0 || this.direccion==null || this.direccion=='') { this.errorPersona=1; this.hasError['direccion']=1;}
                if (!this.telefono || this.telefono<=0 || this.telefono==null || this.telefono=='') { this.errorPersona=1; this.hasError['telefono']=1;}
                if (!this.email || this.email<=0 || this.email==null || this.email=='') { this.errorPersona=1; this.hasError['email']=1;}

                // if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;

                return this.errorPersona;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.tipo_documento='DNI';
                this.num_documento='';
                this.direccion='';
                this.telefono='';
                this.email='';
                this.errorPersona=0;

            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "persona":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Cliente';
                                this.nombre= '';
                                this.tipo_documento='DNI';
                                this.num_documento='';
                                this.direccion='';
                                this.telefono='';
                                this.email='';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Cliente';
                                this.tipoAccion=2;
                                this.persona_id=data['id'];
                                this.nombre = data['nombre'];
                                this.tipo_documento = data['tipo_documento'];
                                this.num_documento = data['num_documento'];
                                this.direccion = data['direccion'];
                                this.telefono = data['telefono'];
                                this.email = data['email'];
                                break;
                            }
                        }
                    }
                }
            }
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
