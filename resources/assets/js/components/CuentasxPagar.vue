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
                        <i class="fa fa-align-justify"></i> Cuentas Por Pagar
                        <button v-if="permisosUser.crear" type="button" @click="abrirModal('cuentasxpagar','registrar')" class="btn btn-primary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                        <button v-else type="button" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                       <div class="row col-md-12">
                            <div class="col-md-4">
                                <div class="form-group row">
                                <label class="col-md-3 form-control-label float-left" for="email-input">Tercero</label>
                                    <div class="form-inline  float-right col-md-9">
                                        <input type="text" readonly class="form-control" style="width: 70%;"   v-model="tercero_filtro" @keyup.enter="listarCuentasxPagar(tercero_id_filtro,Bdesde,Bhasta,Bestado)" >
                                        <button type="button" @click="abrirModal('cuentasxpagar','tercerofiltro')" class="btn btn-primary">...</button>
                                        <button type="button" @click="quitar()" class="btn btn-danger" style="padding: -0.1% 4% 3.1% 4%;">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label float-left" for="email-input">Desde</label>
                                    <div class="float-right col-md-9">
                                        <input type="date" v-model="Bdesde" @keyup.enter="listarCuentasxPagar(tercero_id_filtro,Bdesde,Bhasta,Bestado)" class="form-control col-md-12" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label float-left" for="email-input">Hasta</label>
                                    <div class="float-right col-md-9">
                                        <input type="date" v-model="Bhasta" @keyup.enter="listarCuentasxPagar(tercero_id_filtro,Bdesde,Bhasta,Bestado)" class="form-control col-md-12" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label float-left" for="email-input">Estado</label>
                                    <div class="float-right col-md-9">
                                        <select class="form-control col-md-12" v-model="Bestado" @keyup.enter="listarCuentasxPagar(tercero_id_filtro,Bdesde,Bhasta,Bestado)">
                                            <option value="1">Pendiente</option>
                                            <option value="2">Cancelada</option>
                                            <option value="3">Pagada</option>
                                            <option value="">Todas</option>
                                        </select>  
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group row">
                                    <button v-if="permisosUser.leer" type="submit" class="btn btn-primary" @click="listarCuentasxPagar(tercero_id_filtro,Bdesde,Bhasta,Bestado)"  title="Buscar">
                                    <i class="fa fa-search"></i> Buscar
                                </button>
                                <button v-else type="button" class="btn btn-secondary" title="Buscar">
                                    <i class="fa fa-search"></i> Buscar
                                </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-2">                                  
                                
                        </div>
                        <br>
                        <div class="table-responsive ">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tercero</th>
                                        <th>Fecha</th>
                                        <th>Valor</th>
                                        <th>Abono</th>
                                        <th>Saldo</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody v-if="permisosUser.leer">
                                    <tr v-for="(cuentasxpagar, index) in arrayCuentasxPagar" :key="index">
                                        <td>{{index+1}}</td>
                                        <td :value="cuentasxpagar.id_tercero" >
                                        <span v-if="cuentasxpagar.num_documento!=null" v-text="cuentasxpagar.num_documento + ' - '"></span>
                                        <span v-if="cuentasxpagar.nombre1!=null" v-text="cuentasxpagar.nombre1"></span>
                                        <span v-if="cuentasxpagar.nombre2!=null" v-text="cuentasxpagar.nombre2"></span>
                                        <span v-if="cuentasxpagar.apellido1!=null" v-text="cuentasxpagar.apellido1"></span>
                                        <span v-if="cuentasxpagar.apellido2" v-text="cuentasxpagar.apellido2"></span>
                                        </td>
                                        <td v-text="cuentasxpagar.fecha_pago"></td>
                                        <td style="text-align: right" v-text="cuentasxpagar.valor_deuda_moneda"></td>
                                        <td style="text-align: right" :value="cuentasxpagar.id" v-text="cuentasxpagar.abono_moneda"></td>
                                        <td style="text-align: right" v-text="cuentasxpagar.saldo_moneda"></td>
                                        <td>
                                            <template v-if="cuentasxpagar.estado_pago==1">
                                                <span class="badge badge-warning">
                                                    Pendiente
                                                </span>
                                            </template>
                                            <template v-if="cuentasxpagar.estado_pago==2">
                                                <span class="badge badge-danger">
                                                    Cancelados
                                                </span>
                                            </template>
                                            <template v-if="cuentasxpagar.estado_pago==3">
                                                <span class="badge badge-success">
                                                    Pagados
                                                </span>
                                            </template>
                                        </td>
                                        <td>   
                                            <template>
                                            <button v-if="cuentasxpagar.estado_pago!=2 && cuentasxpagar.saldo!=0" type="button" @click="abrirModal('cuentasxpagar','abono',cuentasxpagar)" class="btn btn-success btn-sm">Abonar</button>
                                            <button v-else type="button"  class="btn btn-secondary btn-sm">Abonar</button>
                                            &nbsp;
                                            </template>
                                            <button v-if="permisosUser.actualizar && cuentasxpagar.estado_pago!=2  && cuentasxpagar.saldo!=0 && cuentasxpagar.num_pago==1" type="button" @click="abrirModal('cuentasxpagar','actualizar',cuentasxpagar)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil"></i>
                                            </button>
                                            <button v-else type="button" class="btn btn-secondary btn-sm">
                                            <i class="icon-pencil"></i>
                                            </button> &nbsp;

                                           <template v-if="permisosUser.anular">
                                                <button v-if="cuentasxpagar.estado_pago!=2 " type="button" class="btn btn-danger btn-sm" @click="desactivarCuentasxPagar(cuentasxpagar.id)">
                                                    <i class="icon-trash"></i>
                                                </button>
                                                <button v-else type="button" class="btn btn-info btn-sm" @click="activarCuentasxPagar(cuentasxpagar.id)">
                                                    <i class="icon-check"></i>
                                                </button>
                                            </template>
                                            <template v-else>
                                                <button v-if="cuentasxpagar.estado" type="button" class="btn btn-secondary btn-sm">
                                                    <i class="icon-trash"></i>
                                                </button>
                                                <button v-else type="button" class="btn btn-secondary btn-sm">
                                                    <i class="icon-check"></i>
                                                </button>
                                            </template>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="3" style="text-align:right"><b>Total</b></td><td style="text-align:right" v-text="sumaValor"></td><td style="text-align:right" v-text="sumaAbono"></td><td style="text-align:right" v-text="sumaSaldo"></td>
                                    </tr>                             
                                </tbody>
                                
                                <tbody v-else>
                                    <tr><td colspan="2">No hay registros para mostrar</td></tr>
                                </tbody>
                            </table>
                            
                        </div>
                       
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content modal-width">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                    <label class="col-md-1 form-control-label float-left" for="email-input">Tercero</label>
                                        <div class="form-inline  float-right col-md-11">
                                            <input type="text" readonly class="form-control" style="width: 55%;" :class="{'is-invalid':NoTercero}"  v-model="tercero">
                                            <button type="button" @click="abrirModal('cuentasxpagar','tercero')" class="btn btn-primary">...</button>
                                            <button type="button" @click="quitar()" class="btn btn-danger" style="padding: -0.1% 4% 3.1% 4%;">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Valor Deuda</label>
                                        <div class="float-right col-md-9">
                                            <input type="number" v-model="valor_deuda"  class="form-control col-md-12" :class="{'is-invalid':NoValorDeuda}" placeholder="Valor deuda">
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Abono</label>
                                        <div class="float-right col-md-9">
                                            <input type="number" v-model="abono"  class="form-control col-md-12" :class="{'is-invalid':NoAbono}" placeholder="Abono">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Fecha</label>
                                        <div class="float-right col-md-9">
                                            <input type="date" v-model="fecha"  class="form-control col-md-12" :class="{'is-invalid':NoFecha}" placeholder="fecha">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div v-show="errorCuentasxPagar" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjCuentasxPagar" :key="error" v-text="error">

                                </div>
                            </div>
                        </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" @click="cerrarModal()">Cerrar</button>
                           
                            <button type="button" v-if="tipoAccion==1 " class="btn btn-success" @click="registrarCuentasxPagar()">Guardar</button>
                            <button v-if="tipoAccion==2" type="button"  class="btn btn-secondary" >Guardar</button>
                            <button type="button" v-if="tipoAccionActulizar==2" class="btn btn-success" @click="actualizarCuentasxPagar()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
              <!-- Modal busqueda tercero-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalTerceros}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="titulomodalTerceros"></h4>
                            <button type="button" class="close" @click="cerrarModalT()" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div style="max-width: 120px !important;" class="col-md-2   ">
                                    <label style='margin-top: 3px; '><b>Tercero</b></label>                                
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="cta_busq" v-model="terc_busq" @keyup="buscarTercero()">
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    
                                        <tr><th>Documento</th><th>Nombre</th><th style="    width: 35px;">-</th></tr>
                                    
                                        <tr v-for="tercero in arrayTerceros" :key="tercero.id">
                                            <td v-text="tercero.num_documento"></td>
                                            <td v-if="tercero.nombre && !tercero.nombre1">{{ tercero.nombre }}  </td>
                                            <td v-else>{{ tercero.nombre1 + ' ' + validarUnder(tercero.nombre2)+' '+tercero.apellido1+' '+validarUnder(tercero.apellido2) }} </td>
                                            <td>
                                                <button v-if="tipoAccionModalTerceros==1" type="button" style=" margin-right: -8px;" @click="cargarTercero(tercero)" class="btn btn-success btn-sm" title='Ver formato'>
                                                    <i class="icon-check"></i>
                                                </button>
                                                <button v-if="tipoAccionModalTerceros==2" type="button" style=" margin-right: -8px;" @click="cargarTerceroFiltro(tercero)" class="btn btn-success btn-sm" title='Ver formato'>
                                                    <i class="icon-check"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Modal buscar tercero -->
              <!--Inicio del modal abono-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalAbono}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="titulomodalAbono"></h4>
                            <button type="button" class="close" @click="cerrarModalA()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row col-md-12">
                             <div class="col-md-6">
                                    <div class="form-group row">
                                    <label class="col-md-3 form-control-label float-left" for="email-input">Tercero</label>
                                        <div class="float-right col-md-9">
                                            <input type="text" disabled class="form-control col-md-12"  
                                             v-model="tercero">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Valor Deuda</label>
                                        <div class="float-right col-md-9">
                                            <input type="number" disabled v-model="valor_deuda"  class="form-control col-md-12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Saldo </label>
                                        <div class="float-right col-md-9">
                                            <input type="number" disabled v-model="saldo"  class="form-control col-md-12" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Abono</label>
                                        <div class="float-right col-md-9">
                                            <!--<input type="number" v-model="abonoPago"  class="form-control col-md-12"  :class="{'is-invalid':NoPagoAbono}" @keyup.enter="listarSaldo(cuentasxcobrar_id,abonoPago)" @blur="listarSaldo(cuentasxcobrar_id,abonoPago)" placeholder="Abono">-->

                                            <input type="number" v-model="abonoPago"  class="form-control col-md-12"  :class="{'is-invalid':NoPagoAbono}" placeholder="Abono" @blur="
                                                    if(abonoPago>saldo)
                                                    {
                                                        abonoPago = saldo;
                                                    }
                                                    else if(abonoPago<=0)
                                                    {
                                                        abonoPago = 1;
                                                    }
                                                ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        <div v-show="errorCuentasxPagar" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjCuentasxPagar" :key="error" v-text="error">

                                </div>
                            </div>
                        </div>
                    </form>
                        </div>
                         <div class="row justify-content-center ">
                                <div class="col-md-6 ">
                        <div class="table-responsive" style="overflow-y: auto;max-height: 16em !important;display: block;border: none;">
                            <table class="table table-bordered table-striped table-sm" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Abonos</th>
                                        <th>Fecha</th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(abonos, index) in arrayAbono" :key="index">
                                        <td v-text="index+1"></td>
                                        <td style="text-align: right" v-text="abonos.abonos_tercero_moneda"></td>
                                        <td style="text-align: right" v-text="abonos.fecha_pago"></td>
                                        <td>
                                         <template v-if="permisosUser.anular && abonos.estado_abono==1">
                                                <button  type="button" class="btn btn-danger btn-sm" @click="desactivarAbono(abonos.id)">
                                                    <i class="icon-trash"></i>
                                                </button>
                                                
                                        </template>
                                        <template v-else>
                                            <button  type="button" class="btn btn-secondary btn-sm" >
                                                    <i class="icon-check"></i>
                                            </button>
                                        </template>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1" style="text-align:right"><b>Total</b></td><td style="text-align:right" v-text="suma_tercero_abonos"></td>
                                    </tr>                       
                                </tbody>
                            </table>     
                    </div>
                </div>
            </div>
            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" @click="cerrarModalA()">Cerrar</button>
                            <button type="button" v-if="tipoAccionAbono==1" class="btn btn-success" @click="registrarAbono(); ">Guardar</button>
                            <button v-if="tipoAccionAbono==2" type="button"  class="btn btn-secondary" >Guardar</button>
                            
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
                cuentasxpagar_id: 0,
                tercero : '',
                tercero_id: '',
                estado_pago:'',
                valor_deuda: '',
                abono: '',
                fecha: '',
                saldo:'',
                id_pago: '',
                id_abono: '',
                arrayCuentasxPagar : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                tipoAccionActulizar:0,
                errorCuentasxPagar : 0,
                errorMostrarMsjCuentasxPagar : [],
                
                //variables de validacion de campo vacio
                campo_obligatorio_form: false,
                //variables  tercero nombre
                arrayTerceroNombre: [],
              
              
                actividad : '',
                id_proyecto : 0,
                arrayProyecto : [],

                // variables modal buscar tercero
                modalTerceros: 0,
                titulomodalTerceros: '',
                tipoAccionModalTerceros: 0,
                tercero :'',
                id_tercero : '',
                buscar : '',   
                ctn_ban : 0,       
                tipo_cta : '',    
                cta_busq : '',  
                terc_busq : '',
                tipo_ingreso: '',
                arrayTerceros : [],
                cuenta_ini : '',
                id_cuenta_ini : '',
                cuenta_fin : '',
                id_cuenta_fin : '',
                //Variables de filtros
                tercero_filtro: '',
                tercero_id_filtro:'',
                Bdesde:'',
                Bhasta:'',
                Bestado:'',
                //variables abonos
                modalAbono: 0,
                abonoPago:'',
                titulomodalAbono: '',
                tipoAccionAbono: 0,
                //fecha de filtros
                fecha_actual:'',
                fecha_anterior:'',
                //variables validar lsitar abonos
                arrayAbono:[],
                suma_tercero_abonos:'',
                //valriables de totales
                sumaValor : 0,
                sumaAbono : 0,
                sumaSaldo : 0,
            }
        },
        computed:{
           
            NoTercero: function(){
                return this.campo_obligatorio_form && !this.tercero
            },
            NoValorDeuda: function(){
                return this.campo_obligatorio_form && !this.valor_deuda
            },
            NoAbono: function(){
                return this.campo_obligatorio_form && !this.abono
            },
            NoFecha: function(){
                return this.campo_obligatorio_form && !this.fecha
            },
            NoPagoAbono: function(){
                return this.campo_obligatorio_form && !this.abonoPago
            },
            NoSaldo: function(){
                return this.campo_obligatorio_form && this.arraySaldo==1
            },
        },
        methods : {
            //Modal terceros
             cargarTercero(tercero){
                this.tercero = tercero['num_documento']+' - '+tercero['nombre1']+' '+tercero['apellido1'];
                this.tercero_id = tercero['id'];
                this.direccion = tercero['direccion'];
                this.tercero_doc = tercero['num_documento'];
                this.tipoAutoretenedorTercero = tercero['autoretenedor']
                
                this.cerrarModalT();
            },
            cargarTerceroFiltro(tercero){
                this.tercero_filtro = tercero['num_documento']+' - '+tercero['nombre1']+' '+tercero['apellido1'];
                this.tercero_id_filtro = tercero['id'];
                this.tercero_doc_filtro = tercero['num_documento'];
                
                this.cerrarModalT();
            },
            buscarTercero(){
                let me=this;
                var search = this.terc_busq;
                var url= this.ruta +'/cliente/selectCliente?filtro='+search;
                    axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayTerceros = respuesta.clientes;                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validarUnder(valor)
            {
                if(valor == "undefined" || valor=="" || !valor)
                    return "";
                else
                    return valor;
            },
            quitar(){
                this.tercero_id_filtro = '';
                this.tercero_filtro = '';
                this.tercero_id = '';
                this.tercero = '';
                this.direccion = '';
            },
            cerrarModalT(){
                let me=this;
                me.modalTerceros=0;
                me.titulomodalTerceros='';
                me.terc_busq = '';
            },

            //Fin modal terceros
            listarCuentasxPagar(tercero_id_filtro,Bdesde,Bhasta,Bestado){
                let me=this;
                var url= this.ruta +'/cuentasxpagar?tercero_id_filtro='+ tercero_id_filtro + '&Bdesde=' + Bdesde + '&Bhasta=' + Bhasta + '&Bestado=' + Bestado;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCuentasxPagar = respuesta.cuentaspagar;
                    me.sumaValor = respuesta.sumaValor;
                    me.sumaAbono = respuesta.sumaAbono;
                    me.sumaSaldo = respuesta.sumaSaldo;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarTercero(id){
                let me=this;
                var url= this.ruta +'/terceronombre?id=' + id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayTerceroNombre= respuesta.nombres;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            
            registrarCuentasxPagar(){
                this.campo_obligatorio_form= true;
                if (this.validarCuentasxPagar()){
                    return;
                }
                this.tipoAccion=2;
                let me = this;

                axios.post(this.ruta +'/cuentasxpagar/registrar',{
                    'id_tercero': this.tercero_id,
                    'valor_deuda': this.valor_deuda,
                    'abono': this.abono,
                    'fecha': this.fecha
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCuentasxPagar('','','','');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            listarAbonos(id_pago){

                let me=this;
                var url= this.ruta +'/cuentasxpagar/saldo?id=' + id_pago;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayAbono = respuesta.valido;
                    me.suma_tercero_abonos = respuesta.suma_tercero_abonos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarAbono(){
                this.campo_obligatorio_form= true;
                if (this.validarAbono()){
                    return;
                }
                this.tipoAccionAbono=2;
                let me = this;

                axios.put(this.ruta +'/cuentasxpagar/registrarAbono',{
                    'abonoPago': this.abonoPago,
                    'id_pago': this.id_pago,
                    'saldo':this.saldo,
                    'id_tercero': this.tercero_id,
                    'valor_deuda': this.valor_deuda,
                    'abono': this.abono,
                    'fecha': this.fecha,
                    'id': this.cuentasxcobrar_id
                }).then(function (response) {
                    me.cerrarModalA();
                    me.listarCuentasxPagar('','','','');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarCuentasxPagar(){
                this.campo_obligatorio_form= true;
               if (this.validarCuentasxPagar()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta +'/cuentasxpagar/actualizar',{
                    'abonoPago': this.abonoPago,
                    'id_pago': this.id_pago,
                    'saldo':this.saldo,
                    'id_tercero': this.tercero_id,
                    'valor_deuda': this.valor_deuda,
                    'abono': this.abono,
                    'fecha': this.fecha,
                    'id_abono':this.id_abono,
                    'id': this.cuentasxpagar_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCuentasxPagar('','','','');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            validarCuentasxPagar(){
                let detener= false;
                if(this.NoTercero){detener=true;}
                if(this.NoValorDeuda){detener=true;}
                if(this.NoAbono){detener=true;}
                if(this.NoFecha){detener=true;}
                
                return detener;
            },
            validarAbono(){
                let detener= false;
                if(this.NoPagoAbono){detener=true;}
                if(this.NoSaldo){deteber=true;}
                if(this.arraySaldo==1){detener=true;}
                return detener; 
            },
            
            desactivarCuentasxPagar(id){
               Swal.fire({
                title: 'Esta seguro de desactivar esta cuenta por pagar?',
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

                    axios.put(this.ruta +'/cuentasxpagar/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarCuentasxPagar('','','','');
                        Swal.fire(
                        'Desactivado!',
                        'La cuenta ha sido desactivada con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.fire.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarCuentasxPagar(id){
               Swal.fire({
                title: 'Esta seguro de activar esta cuenta por pagar?',
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

                    axios.put(this.ruta +'/cuentasxpagar/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarCuentasxPagar('','','','');
                        Swal.fire(
                        'Activado!',
                        'La cuenta ha sido activada con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.fire.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
             desactivarAbono(id){
               Swal.fire({
                title: 'Esta seguro de desactivar esta abono?',
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

                    axios.put(this.ruta +'/cuentasxpagar/desactivarAbono',{
                        'id': id
                    }).then(function (response) {
                        me.listarAbonos(me.id_pago);
                         me.listarCuentasxPagar('','','','');
                        Swal.fire(
                        'Desactivado!',
                        'El abono ha sido desactivada con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.fire.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.id_tercero='';
                this.tercero='';
                this.valor_deuda='';
                this.abono='';
                this.fecha='';
                this.cuentasxcobrar_id='';
                this.campo_obligatorio_form= false;
            },
            cerrarModalA(){
                this.modalAbono=0;
                this.titulomodalAbono='';
                this.abonoPago='';
                this.tipoAccionAbono=0;
                this.campo_obligatorio_form= false;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "cuentasxpagar":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Cuenta por Pagar';
                                this.tercero='';
                                this.valor_deuda='';
                                this.abono='';
                                this.fecha='';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Cuenta Por Pagar';
                                this.tipoAccionActulizar=2;
                                this.cuentasxpagar_id=data['id'];
                                this.tercero_id = data['id_tercero'];
                                this.id_abono = data['id_abono'];
                                var nom = '';
                                if(data['nombre1']!=null){nom=data['nombre1'];}
                                if(data['nombre2']!=null){nom=nom+' '+data['nombre2'];}
                                if(data['apellido1']!=null){nom=nom+' '+data['apellido1'];}
                                if(data['apellido2']!=null){nom=nom+' '+data['apellido2'];}
                                this.tercero = nom;
                                this.valor_deuda = data['valor_deuda'];
                                this.abono = data['abono'];
                                this.saldo = data['saldo'];
                                this.fecha = data['fecha_pago'];
                            
                                break;
                            }
                            case 'tercero':
                            {
                                this.arrayTerceros=[];
                                this.modalTerceros = 1;
                                this.titulomodalTerceros = 'Seleccione un tercero';
                                this.tipoAccionModalTerceros = 1;
                                break;
                            }
                            case 'tercerofiltro':
                            {
                                this.arrayTerceros=[];
                                this.modalTerceros = 1;
                                this.titulomodalTerceros = 'Seleccione un tercero';
                                this.tipoAccionModalTerceros = 2;
                                break;
                            }
                            case 'abono':
                            {   
                                 this.cuentasxcobrar_id=data['id'];
                                this.tercero_id = data['id_tercero'];
                                var nom = '';
                                if(data['nombre1']!=null){nom=data['nombre1'];}
                                if(data['nombre2']!=null){nom=nom+' '+data['nombre2'];}
                                if(data['apellido1']!=null){nom=nom+' '+data['apellido1'];}
                                if(data['apellido2']!=null){nom=nom+' '+data['apellido2'];}
                                this.tercero = nom;
                                this.valor_deuda = data['valor_deuda'];
                                this.abono = data['abono'];
                                this.fecha = data['fecha_pago'];
                                this.saldo = data['saldo'];
                                this.id_pago = data['id_pago'];
                                this.modalAbono = 1;
                                this.titulomodalAbono = 'Abonar saldo';
                                this.abonoPago='';
                                this.tipoAccionAbono = 1;
                                this.listarAbonos(this.id_pago);
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            let me= this;
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
            me.anio = yyyy;
            //fecha_un año antes
            
            var a = new Date();
            
            
            var dd = a.getDate();
            var mm = a.getMonth()+1;
            var yyyy = a.getFullYear()-1;
            var h = a.getHours();
            var min = a.getMinutes();
            var sec = a.getSeconds();
            
            if(dd<10){
                dd='0'+dd;
            } 
            if(mm<10){
                mm='0'+mm;
            } 
            a = yyyy+'-'+mm+'-'+dd;
            me.anio = yyyy;

            this.Bhasta = d;
            this.Bdesde = a;

            this.Bestado = "1";
            this.listarCuentasxPagar(this.tercero_id_filtro,this.Bdesde,this.Bhasta,this.Bestado);
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .modal-width{
        width: 1000px !important;
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
