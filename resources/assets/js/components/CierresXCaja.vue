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
                    <i class="fa fa-align-justify"></i> Cierres por caja
                    <!--<button v-if="permisosUser.crear && tipoAccion!=3" type="button" @click="abrirModal('cierres_caja','registrar')" class="btn btn-primary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                    <button v-else type="button" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>-->
                </div>
                <div class="card-body">
                    <div v-if="tipoAccion!=3" class="form-group row">
                        <div class="col-md-4">
                            <input v-if="permisosUser.leer" type="text" v-model="buscar" @keyup="listarCajas(1,buscar,criterio,fec_desde,fec_hasta)" class="form-control" placeholder="Texto a buscar">
                            <input v-else disabled type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar">
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-3 float-left">Desde: </label>
                            <input v-if="permisosUser.leer" type="date" v-model="fec_desde" @change="listarCajas(1,buscar,criterio,fec_desde,fec_hasta)" class="form-control col-md-9 float-right">
                            <input v-else disabled type="date" v-model="fec_desde" class="form-control col-md-9 float-right">
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-3 float-left">Hasta: </label>
                            <input v-if="permisosUser.leer" type="date" v-model="fec_hasta" @change="listarCajas(1,buscar,criterio,fec_desde,fec_hasta)" class="form-control col-md-9 float-right">
                            <input v-else disabled type="date" v-model="fec_hasta" class="form-control col-md-9 float-right">
                        </div>
                    </div>
                    <table v-if="tipoAccion!=3" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th class="col-md-19">Nombre</th>
                                <th class="col-md-1">Fecha</th>
                                <th class="col-md-1">Cajero</th>
                                <th class="col-md-1">Opciones</th>
                            </tr>
                        </thead>
                        <tbody v-if="permisosUser.leer && arrayCierresXCajas.length">
                            <tr v-for="cierre_caja in arrayCierresXCajas" :key="cierre_caja.id">
                                <td v-text="cierre_caja.nombre"></td>
                                <td v-text="cierre_caja.created_at"></td>
                                <td v-text="cierre_caja.nom_cajero"></td>
                                <td>
                                    <button v-if="permisosUser.leer" type="button" @click="abrirModal('cierres_caja','ver',cierre_caja)" class="btn btn-info btn-sm" title="Detalle caja">
                                        <i class="icon-eye"></i>
                                    </button>
                                    <button v-else type="button" class="btn btn-secondary btn-sm" title="Detalle caja">
                                        <i class="icon-eye"></i>
                                    </button>

                                    <!--<button v-if="permisosUser.actualizar && cierre_caja.estado" type="button" @click="abrirModal('cierres_caja','actualizar',cierre_caja)" class="btn btn-warning btn-sm">
                                        <i class="icon-pencil"></i>
                                    </button>
                                    <button v-else type="button" class="btn btn-secondary btn-sm">
                                        <i class="icon-pencil"></i>
                                    </button> &nbsp;-->

                                    <template v-if="permisosUser.actualizar">
                                        <button v-if="cierre_caja.estado==1" type="button" class="btn btn-warning btn-sm" @click="abrirModal('cierres_caja','actualizar',cierre_caja)" title="Cerrar caja">
                                            <i class="fa fa-window-close"></i>
                                        </button>
                                        <button v-else type="button" class="btn btn-secondary btn-sm" title="Cerrar caja (Deshabilitado)">
                                            <i class="fa fa-window-close"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-secondary btn-sm" title="Cerrar caja (Deshabilitado)">
                                            <i class="fa fa-window-close"></i>
                                        </button>
                                    </template>

                                    <template v-if="permisosUser.anular">
                                        <button v-if="cierre_caja.estado==1" type="button" class="btn btn-danger btn-sm" @click="desactivarCierreXCaja(cierre_caja.id)" title="Anular">
                                            <i class="icon-trash"></i>
                                        </button>
                                        <button v-else type="button" class="btn btn-secondary btn-sm" title="Anular (Deshabilitado)">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-secondary btn-sm" title="Anular (Deshabilitado)">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </template>
                                </td>
                            </tr>                                
                        </tbody>
                        <tbody v-else>
                            <tr><td colspan="3">No hay registros para mostrar</td></tr>
                        </tbody>
                    </table>
                    <div v-else>
                        <div class="row">
                            <div class="col-md-12">
                                <h3 v-text="nombre_caja"></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-md-12 float-left" v-text="'Valor inicial: '+vr_inicial"></label>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 float-left">Observacion inicial:</label>
                                    <div class="col-md-9 float-right">
                                        <p v-text="obs_inicial" class="col-md-12 float-left" style="overflow-y: auto;max-height: 8em;"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-md-12 float-left" v-text="'Valor inicial: '+vr_gastos"></label>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 float-left">Observacion inicial:</label>
                                    <div class="col-md-9 float-right">
                                        <p v-text="obs_gastos" class="col-md-12 float-left" style="overflow-y: auto;max-height: 8em;"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-md-12 float-left" v-text="'Valor final: '+vr_final"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-md-12 float-left" v-text="'Cajero: '+nom_cajero"></label>
                                </div>
                            </div>
                        </div>

                        <button type="button" @click="cerrarModal()" class="btn btn-danger btn-sm">Cerrar</button>
                    </div>
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

        <!-- Modal crear actualizar -->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-md-1 float-left">Caja</label>
                                <div class="float-right col-md-11">
                                    <select v-if="tipoAccion==1" class="form-control float-right" v-model="id_caja" style="width: 95.7% !important;">
                                        <option></option>
                                        <option v-for="(caja, index) in arrayCajas" :value="caja.id" v-text="caja.nombre"></option>
                                    </select>
                                    <select v-else disabled class="form-control float-right" v-model="id_caja" style="width: 95.7% !important;">
                                        <option></option>
                                        <option v-for="(caja, index) in arrayCajas" :value="caja.id" v-text="caja.nombre"></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="col-md-3 float-left">Vr. Inicial</label>
                                <div class="col-md-9 float-right">
                                    <input v-if="tipoAccion==1" type="number" class="form-control" v-model="vr_inicial">
                                    <input v-else disabled type="number" class="form-control" v-model="vr_inicial">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-3 float-left">Obs. Inicial</label>
                                <div class="col-md-9 float-right">
                                    <input v-if="tipoAccion==1" type="text" class="form-control" v-model="obs_inicial">
                                    <input v-else disabled type="text" class="form-control" v-model="obs_inicial">
                                </div>
                            </div>
                        </div>
                        <div v-if="tipoAccion==2" class="form-group row">
                            <div class="col-md-6">
                                <label class="col-md-3 float-left">Vr. Gastos</label>
                                <div class="col-md-9 float-right">
                                    <input type="number" class="form-control" v-model="vr_gastos">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-3 float-left">Obs. Gastos</label>
                                <div class="col-md-9 float-right">
                                    <input type="text" class="form-control" v-model="obs_gastos">
                                </div>
                            </div>
                        </div>
                        <div v-if="tipoAccion==2" class="form-group row">
                            <div class="col-md-6">
                                <label class="col-md-3 float-left">Vr. Final</label>
                                <div class="col-md-9 float-right">
                                    <input type="number" class="form-control" v-model="vr_final">
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                        <div v-show="errorCierreXCaja" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjCierreXCaja" :key="error" v-text="error">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarCierreXCaja()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-success" @click="cerrarCierreXCaja(id_caja)">Cerrar Caja</button>
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
                cierre_caja_id: 0,
                id_caja : '',
                nombre_caja : '',
                vr_inicial : 0,
                obs_inicial : '',
                vr_gastos : 0,
                obs_gastos : '',
                vr_software : 0,
                vr_final : 0,
                nom_cajero : '',
                arrayCierresXCajas : [],
                arrayCajas: [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorCierreXCaja : 0,
                errorMostrarMsjCierreXCaja : [],
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
                fec_desde : '',
                fec_hasta: '',
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
            },
        },
        methods : {
            listarCajas(page,buscar,criterio,fec_desde,fec_hasta){
                let me=this;
                var url= this.ruta +'/cierres_caja?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio+ '&fec_desde='+ fec_desde+ '&fec_hasta='+ fec_hasta;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCierresXCajas = respuesta.cierres_caja.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectCajas(){
                let me=this;
                var url= this.ruta +'/cajas/SelectCaja';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCajas = respuesta.cajas;
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
                me.listarCajas(page,buscar,criterio,fec_desde,fec_hasta);
            },
            registrarCierreXCaja(){
                if (this.validarCierreXCaja()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/cierres_caja/registrar',{
                    'id_caja': this.id_caja,
                    'vr_inicial': this.vr_inicial,
                    'obs_inicial': this.obs_inicial,
                    'vr_gastos': this.vr_gastos,
                    'obs_gastos': this.obs_gastos,
                    'vr_final': this.vr_final,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCajas(1,this.buscar,this.criterio,this.fec_desde,this.fec_hasta);
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarCierreXCaja(){
                if (this.validarCierreXCaja()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta +'/cierres_caja/actualizar',{
                    'id_caja': this.id_caja,
                    'vr_inicial': this.vr_inicial,
                    'obs_inicial': this.obs_inicial,
                    'vr_gastos': this.vr_gastos,
                    'obs_gastos': this.obs_gastos,
                    'vr_final': this.vr_final,
                    'id': this.cierre_caja_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCajas(1,'','nombre','','');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            validarCierreXCaja(){
                this.errorCierreXCaja=0;
                this.errorMostrarMsjCierreXCaja =[];

                if (!this.id_caja || this.id_caja==0) this.errorMostrarMsjCierreXCaja.push("El nombre de la presentación no puede estar vacío.");
                if(!this.vr_inicial || this.vr_inicial==0) this.errorMostrarMsjCierreXCaja.push("Ingrese valor inicial");
                if(this.tipoAccion==2)
                {
                    if(!this.vr_gastos || this.vr_gastos==0) this.errorMostrarMsjCierreXCaja.push("Ingrese valor gastos");
                    if(!this.vr_final || this.vr_final==0) this.errorMostrarMsjCierreXCaja.push("Ingrese valor final");
                }

                if (this.errorMostrarMsjCierreXCaja.length) this.errorCierreXCaja = 1;

                return this.errorCierreXCaja;
            },
            desactivarCierreXCaja(id){
               Swal.fire({
                title: 'Esta seguro de desactivar esta cierre de caja?',
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

                    axios.put(this.ruta +'/cierres_caja/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarCajas(1,'','nombre','','');
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
                title: 'Esta seguro de activar este cierre de caja?',
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

                    axios.put(this.ruta +'/concentracion/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarCajas(1,'','nombre','','');
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
            cerrarCierreXCaja(){
                let me = this;
                if(me.id_caja!=0 && me.vr_inicial!=0 && me.vr_final!=0 && me.vr_gastos!=0)
                {
                    Swal.fire({
                        title: 'Esta seguro de cerrar esta caja?',
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

                            axios.put(me.ruta +'/cierres_caja/cerrar',{
                                'id_caja': me.id_caja,
                                'obs_inicial': me.obs_inicial,
                                'vr_gastos': me.vr_gastos,
                                'obs_gastos': me.obs_gastos,
                                'vr_final': me.vr_final,
                                'id': me.cierre_caja_id
                            }).then(function (response) {
                                me.cerrarModal();
                                me.listarCajas(1,me.buscar,me.criterio,me.fec_desde,me.fec_hasta);
                                Swal.fire(
                                'Cerrado!',
                            'El registro ha sido cerrado con éxito.',
                            'success'
                            )
                            }).catch(function (error) {
                                console.log(error);
                            });
                        } else if (
                            // Read more about handling dismissals
                            result.dismiss === Swal.DismissReason.cancel
                        ) {}
                    }) 
                }
                else
                {
                    me.validarCierreXCaja();
                }
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.tipoAccion = 0;
                this.id_caja=0;
                this.nombre_caja = '';
                this.vr_inicial=0;
                this.obs_inicial = '';
                this.vr_gastos = 0;
                this.obs_gastos = '';
                this.vr_software = 0;
                this.vr_final = 0;
                this.cierre_caja_id = 0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "cierres_caja":
                    {
                        this.cerrarModal();
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Cierre de caja';
                                this.id_caja='';
                                this.vr_inicial=0;
                                this.obs_inicial = '';
                                this.vr_gastos = 0;
                                this.obs_gastos = '';
                                this.vr_software = 0;
                                this.vr_final = 0;
                                this.cierre_caja_id = 0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Cierre de caja';
                                this.tipoAccion=2;
                                this.cierre_caja_id=data['id'];
                                this.id_caja = data['id_caja'];
                                this.vr_inicial = data['vr_inicial'];
                                this.obs_inicial = data['obs_inicial'];
                                this.vr_gastos = data['vr_gastos'];
                                this.obs_gastos = data['obs_gastos'];
                                this.vr_software = data['vr_software'];
                                this.vr_final = data['vr_final'];
                                break;
                            }
                            case 'ver':
                            {
                                this.modal=0;
                                this.tituloModal='';
                                this.tipoAccion=3;
                                this.cierre_caja_id=data['id'];
                                this.id_caja = data['id_caja'];
                                this.nombre_caja = data['nombre'];
                                this.vr_inicial = data['vr_inicial'];
                                this.obs_inicial = data['obs_inicial'];
                                this.vr_gastos = data['vr_gastos'];
                                this.obs_gastos = data['obs_gastos'];
                                this.vr_software = data['vr_software'];
                                this.vr_final = data['vr_final'];
                                this.nom_cajero = data['nom_cajero'];
                                break;
                            }
                        }
                        this.selectCajas();
                    }
                }
            }
        },
        mounted() {
            let me=this;
            var d = new Date();
            
            var dd = d.getDate();
            var mm = d.getMonth()+1;
            var yyyy = d.getFullYear();
            var h = d.getHours();
            var min = d.getMinutes();
            var sec = d.getSeconds();
            
            if(dd<10){
                dd='0'+dd;
            } 
            if(mm<10){
                mm='0'+mm;
            } 
            d = yyyy+'-'+mm+'-'+dd;
            this.fec_desde = d;
            this.fec_hasta = d;

            me.listarCajas(1,'','',this.fec_desde,this.fec_hasta);
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