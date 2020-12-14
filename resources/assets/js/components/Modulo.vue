<template>
        <main class="main">
            <!-- Breadcrumb -->
            
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Modulos
                        <button type="button" @click="abrirModal('modulo','registrar')" class="btn btn-primary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarModulo(buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarModulo(buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm" style="overflow-y: auto;max-height: 23.7em !important;display: block;border: none;">
                            <thead>
                                <tr>
                                    <th class="col-md-2">Nombre</th>
                                    <th class="col-md-2">Descripcion</th>
                                    <th class="col-md-1">Componente</th>
                                    <th class="col-md-1">Menu</th>
                                    <th class="col-md-1">Tipo</th>
                                    <th class="col-md-1">Icono</th>
                                    <th class="col-md-1">Template</th>
                                    <th class="col-md-1">Padre</th>
                                    <th class="col-md-1">Estado</th>
                                    <th class="col-md-1">Opciones</th>
                                </tr>
                            </thead>
                            <tbody v-if="arrayModulo.length">
                                <tr v-for="modulo in arrayModulo" :key="modulo.id">
                                    <!-- si tipo es igual a 1 -->
                                    <td v-if="modulo.tipo==1" v-text="modulo.nombre" style="background: #dae3e8;"></td>
                                    <td v-if="modulo.tipo==1" v-text="modulo.descripcion" style="background: #dae3e8;"></td>
                                    <td v-if="modulo.tipo==1" v-text="modulo.componente" style="background: #dae3e8;"></td>
                                    <td v-if="modulo.tipo==1" v-text="modulo.menu" style="background: #dae3e8;"></td>
                                    <td v-if="modulo.tipo==1" v-text="modulo.tipo" style="background: #dae3e8;"></td>
                                    <td v-if="modulo.tipo==1" v-text="modulo.icono" style="background: #dae3e8;"></td>
                                    <td v-if="modulo.tipo==1" v-text="modulo.template" style="background: #dae3e8;"></td>
                                    <td v-if="modulo.tipo==1" v-text="modulo.padre" style="background: #dae3e8;"></td>
                                    <td v-if="modulo.tipo==1" style="background: #dae3e8;">
                                        <div v-if="modulo.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td v-if="modulo.tipo==1" style="background: #dae3e8;">

                                        <button v-if="modulo.estado == 1" type="button" @click="abrirModal('modulo','actualizar',modulo)" class="btn btn-warning btn-sm" title="Actualizar">
                                          <i class="icon-pencil"></i>
                                        </button>
                                        <button v-else type="button" class="btn btn-secondary btn-sm" title="Actualizar (Deshabilitado)">
                                          <i class="icon-pencil"></i>
                                        </button>

                                        <template v-if="modulo.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarModulo(modulo.id)" title="Desactivar">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarModulo(modulo.id)" title="Activar">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>

                                    <!-- si tipo es igual a 2 -->
                                    <td v-if="modulo.tipo==2" v-text="modulo.nombre" style="background: #ffffff;"></td>
                                    <td v-if="modulo.tipo==2" v-text="modulo.descripcion" style="background: #ffffff;"></td>
                                    <td v-if="modulo.tipo==2" v-text="modulo.componente" style="background: #ffffff;"></td>
                                    <td v-if="modulo.tipo==2" v-text="modulo.menu" style="background: #ffffff;"></td>
                                    <td v-if="modulo.tipo==2" v-text="modulo.tipo" style="background: #ffffff;"></td>
                                    <td v-if="modulo.tipo==2" v-text="modulo.icono" style="background: #ffffff;"></td>
                                    <td v-if="modulo.tipo==2" v-text="modulo.template" style="background: #ffffff;"></td>
                                    <td v-if="modulo.tipo==2" v-text="modulo.padre" style="background: #ffffff;"></td>
                                    <td v-if="modulo.tipo==2" style="background: #ffffff;">
                                        <div v-if="modulo.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td v-if="modulo.tipo==2" style="background: #ffffff;">
                                        <button type="button" @click="abrirModal('modulo','actualizar',modulo)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button>
                                        <template v-if="modulo.estado">
                                            <button type="button" class="btn btn-danger btn-sm"  @click="desactivarModulo(modulo.id)" title="Desactivar">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarModulo(modulo.id)" title="Activar">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                </tr>                                
                            </tbody>
                            <tbody v-else>
                                <tr colspan="10">No hay registros para mostrar</tr>
                            </tbody>
                        </table>
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
                                        <label class="col-md-1 form-control-label float-left" for="text-input">Nombre (*)</label>
                                        <div class="col-md-11 float-right">
                                            <input type="text" v-model="nombre" class="form-control float-right" placeholder="Nombre del modulo">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="col-md-3 form-control-label float-left" for="text-input">Descripcion</label>
                                        <div class="col-md-9 float-right">
                                            <input type="text" v-model="descripcion" class="form-control" placeholder="Descripcion del modulo">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Componente</label>
                                        <div class="col-md-9 float-right">
                                            <input type="text" v-model="componente" class="form-control" placeholder="Componente">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Menú</label>
                                        <div class="col-md-9 float-right">
                                            <input type="text" v-model="menu" class="form-control" placeholder="Menú">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Icono</label>
                                        <div class="col-md-9 float-right">
                                            <input type="text" v-model="icono" class="form-control" placeholder="Icono">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Template</label>
                                        <div class="col-md-9 float-right">
                                            <input type="text" v-model="template" class="form-control" placeholder="Template">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Tipo</label>
                                        <div class="col-md-9 float-right">
                                            <select v-model="tipo" class="form-control">
                                                <option value="0" disabled="disabled">--Seleccione--</option>
                                                <option value="1">Padre</option>
                                                <option value="2">Hijo</option>
                                            </select>                                    
                                        </div>
                                    </div>
                                </div>
                                <div class="row" v-if="tipo==2">
                                    <div class="form-group col-md-6">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Padre</label>
                                        <div class="col-md-9 float-right">
                                            <select v-model="padre" class="form-control">
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="padre in arrayPadre" :key="padre.id" :value="padre.id" v-text="padre.nombre"></option>
                                            </select>                                   
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                    </div>
                                </div>
                                <div v-show="errorModulo" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjModulo" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarModulo()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-success" @click="actualizarModulo()">Actualizar</button>
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
                modulo_id: '',
                nombre : '',
                descripcion: '',
                componente : '',
                menu : '',
                validarMenu : '',
                tipo : '',
                icono : '',
                template : '',
                padre: '',
                arrayModulo : [],
                arrayPadre : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorModulo : 0,
                errorMostrarMsjModulo : [],
                arrayHijos: [],
                offset : 3,
                criterio : 'nombre',
                buscar : ''
            }
        },
        methods : {
            listarModulo(buscar,criterio){
                let me=this;
                var url= this.ruta +'/modulo?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayModulo = respuesta.modulos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectPadre(){
                let me=this;
                var url= this.ruta +'/modulo/selectPadre';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPadre = respuesta.modulos;
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
                me.listarModulo(buscar,criterio);
            },
            registrarModulo(){
                if (this.validarModulo()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/modulo/registrar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'componente': this.componente,
                    'menu': this.menu,
                    'tipo': this.tipo,
                    'icono': this.icono,
                    'template': this.template,
                    'padre':this.padre
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarModulo('','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarModulo(){
               if (this.validarModulo()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta +'/modulo/actualizar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'componente': this.componente,
                    'menu': this.menu,
                    'tipo': this.tipo,
                    'icono': this.icono,
                    'template': this.template,
                    'padre':this.padre,
                    'id': this.modulo_id
                }).then(function (response) {
                    // console.log(me.modulo_id);
                    // Aqui tienen que ir con me en lugar de this
                    me.cambiarHijos(me.modulo_id,me.tipo);
                    me.cerrarModal();
                    me.listarModulo('','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            cambiarHijos(id,tipo){
                let me = this;
                // console.log('hijos');
                // console.log('id: '+id);
                // console.log('tipo: '+tipo);
                axios.put(me.ruta +'/modulo/cambiarHijos',{
                    'id':id,
                    'tipo':tipo,
                }).catch(function (error) {
                    console.log(error);
                });
            },         
            validarModulo(){
                let me = this;

                this.errorModulo=0;
                this.errorMostrarMsjModulo =[];

                if (!this.nombre) this.errorMostrarMsjModulo.push("El nombre del modulo no puede estar vacío.");
                if (!this.componente) this.errorMostrarMsjModulo.push("El campo componente no puede estar vacío");
                if (!this.menu) this.errorMostrarMsjModulo.push("El campo menú no puede estar vacío");
                if (!this.tipo) this.errorMostrarMsjModulo.push("Se debe seleccionar el tipo de modulo");
                if (!this.icono) this.errorMostrarMsjModulo.push("Se debe seleccionar el icono  del modulo");
                if (!this.template) this.errorMostrarMsjModulo.push("Se debe seleccionar el template del modulo");

                console.log('tipo_accion: '+me.tipoAccion);
                for(var r=0; r<me.arrayModulo.length; r++)
                {
                    if(me.tipoAccion==1 && me.arrayModulo[r]['menu']==me.menu) me.errorMostrarMsjModulo.push("El numero del menu ya se encuentra registrado");

                    if(me.tipoAccion==2 && me.validarMenu!=me.menu && me.menu==me.arrayModulo[r]['menu']) me.errorMostrarMsjModulo.push("El numero del menu ya se encuentra registrado");
                }
                
                if (this.errorMostrarMsjModulo.length) this.errorModulo = 1;

                return this.errorModulo;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.descripcion='';
                this.componente= '';
                this.menu= '';
                this.tipo= '';
                this.icono='';
                this.template='';
                this.padre= '';
                this.errorModulo=0;

            },
            abrirModal(modelo, accion, data = []){
                this.selectPadre();
                switch(modelo){
                    case "modulo":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Crear Modulo';
                                this.nombre= '';
                                this.descripcion= '';
                                this.componente= '';
                                this.menu= '';
                                this.tipo= '';
                                this.icono= '';
                                this.template= '';
                                this.padre= '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Modulo';
                                this.tipoAccion=2;
                                this.modulo_id=data['id'];
                                this.nombre = data['nombre'];
                                this.descripcion = data['descripcion'];
                                this.componente = data['componente'];
                                this.menu = data['menu'];
                                this.validarMenu = data['menu'];
                                this.tipo = data['tipo'];
                                this.icono = data['icono'];
                                this.template = data['template'];
                                this.padre = data['padre'];
                                break;
                            }
                        }
                    }
                }
            },
            desactivarModulo(id){
               Swal.fire({
                title: 'Esta seguro de desactivar este modulo?',
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
                    // console.log('hijos');
                    // console.log('id: '+id);
                    axios.put(me.ruta +'/modulo/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.desactivarHijos(id);
                        me.listarModulo('','nombre');
                        Swal.fire(
                        'Desactivado!',
                        'El modulo ha sido desactivado con éxito.',
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
            desactivarHijos(id){
                let me = this;
                //  console.log('hijos');
                //  console.log('id: '+id);
                axios.put(me.ruta +'/modulo/desactivarHijos',{
                    'id': id,
                }).catch(function (error) {
                    console.log(error);
                });
            },
            activarModulo(id){
               Swal.fire({
                title: 'Esta seguro de activar este modulo?',
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

                    axios.put(this.ruta +'/modulo/activar',{
                        'id': id
                    }).then(function (response) {
                        me.activarHijos(id);
                        me.listarModulo('','nombre');
                        Swal.fire(
                        'Activado!',
                        'El modulo ha sido activado con éxito.',
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
            activarHijos(id){
                let me = this;
                console.log('hijos');
                console.log('id: '+id);
                axios.put(me.ruta +'/modulo/activarHijos',{
                    'id': id,
                }).catch(function (error) {
                    console.log(error);
                });
            },
        },
        mounted() {
            this.listarModulo(this.buscar,this.criterio);
           
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
