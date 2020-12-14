<template>
        <main class="main">
        <!-- Breadcrumb -->
       
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                
                <div class="card-body">
                   

                    <div style="    margin-bottom: -0.5em !important;" class="form-group row">
                        <div style="max-width: 120px !important; min-width: 100px;" class="col-md-1   ">
                            <label style='margin-top: 3px; '><b>Informe*</b></label>                                
                        </div>
                        <div class="col-md-2 col-sm-4">
                            <div class="form-group">                                                                  
                                <select class="form-control" v-model="id_informe">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="informe in arrayInformes" :key="informe.numero" :value="informe.numero" v-text="informe.nom_informe"></option>-
                                </select> 
                            </div>
                        </div>
                        <div class="col-md-1    ">
                            <label style='margin-top: 3px;'><b>Año</b></label>                                
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <!--<input type="date" class="form-control" name="fecha_ini" v-model="fecha_ini">-->
                               
                                <select class="form-control" v-model="anio" name="anio" >
                                    <option v-for="an in lista_anios" :value="an.num_anio" :key="an.num_anio" v-text="an.num_anio"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1   ">
                            <label style='margin-top: 3px;'><b>Desde*</b></label>                                
                        </div>
                        <div class="col-md-1">
                            <select class="form-control" v-model="mes" name="mes" @change="listar_dias()">
                                <option v-for="me in lista_meses" :value="me.num_mes" :key="me.num_mes" v-text="me.nom_mes"></option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <select class="form-control" v-model="dia1">
                                <option v-for="d1 in lista_dias1" :value="d1" :key="d1" v-text="d1"></option>
                            </select>

                        </div>
                        <div class="col-md-1   ">
                            <label style='margin-top: 3px;'><b>Hasta*</b></label>                                
                        </div>
                        <div class="col-md-1">
                            <select class="form-control" v-model="mes2" name="mes2" >
                                <option v-for="me in lista_meses" :value="me.num_mes" :key="me.num_mes" v-text="me.nom_mes"></option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <select class="form-control" v-model="dia2">
                                <option v-for="d2 in lista_dias2" :value="d2" :key="d2" v-text="d2"></option>
                            </select>

                        </div>
                        
                       <!-- <div class="col-md-2">
                            <div class="form-group" >
                                <input type="date" class="form-control" name="fecha_fin" v-model="fecha_fin">
                            </div>
                        </div>-->
                    </div>
                    <div v-if="id_informe=='3'">
                        <div style="    margin-bottom: -0.5rem;" class="form-group row">
                            <div class="col-12  text-center">
                                <input type="button" style="max-width: 11em;" class="btn btn-success form-control" value="Ver Balance General" @click="verBlanceGeneral()">
                            </div>
                        </div>
                    </div>
                    <div v-if="id_informe=='1'">
                        <div style="    margin-bottom: -0.5rem;" class="form-group row">
                            <div class="col-md-12">
                                <table border="0" cellpadding="2">
                                    <tr>
                                        <td><label ><b>Cta Inicial</b></label></td>
                                        <td>
                                            <div class="form-group" >
                                                <div class="form-inline">
                                                    <input type="text" readonly style="    max-width: 90px;" class="form-control" name="cuenta_ini" v-model="cuenta_ini">
                                                    <button @click="abrirModal(1)" style="    min-width: 30px;" class="btn btn-primary form-control">...</button>
                                                    <button @click="quitar(1)" style="    min-width: 30px;" class="btn btn-danger form-control">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td><label ><b>Cta Final</b></label></td>
                                        <td>
                                            <div class="form-group" >
                                                <div class="form-inline">
                                                    <input type="text" readonly style="    max-width: 90px;" class="form-control" name="cuenta_fin" v-model="cuenta_fin">
                                                    <button @click="abrirModal(2)" style="    min-width: 30px;" class="btn btn-primary form-control">...</button>
                                                    <button @click="quitar(2)" style="    min-width: 30px;" class="btn btn-danger form-control">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td><label ><b>Tercero</b></label></td>
                                        <td>
                                            <div class="form-group" >
                                                <div class="form-inline">
                                                    <input type="text" readonly style="    max-width: 90px;" class="form-control" name="cuenta_fin" v-model="tercero">
                                                    <button @click="abrirModalT()" style="    min-width: 30px;" class="btn btn-primary form-control">...</button>
                                                    <button @click="quitar(3)" style="    min-width: 30px;" class="btn btn-danger form-control">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                            <td><label ><b>Formato</b></label></td>
                                        <td>
                                            <div class="form-group" >
                                                <div class="form-inline">
                                                    <select style="float: left;" class="form-control" v-model="tipo_formato" id="tipo_formato_new">
                                                        <option value=""></option>
                                                        <option v-for="TipoFormato in arrayTiposFormatos" :key="TipoFormato.id" :value="TipoFormato.id" v-text="TipoFormato.nombre_formato"></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td><button @click="verAuxConSaldos()" style="margin-top: -18px; min-width: 30px;" class="btn btn-success form-control">Ver</button></td>
                                    </tr>
                                </table>
                            </div>
                            
                        </div>
                        <br>
                        <div class="form-group row">
                            <div class="col-md-12">                            
                                <center><button type="button" class="btn btn-danger btn-sm" @click="pdfFormato()">PDF</button></center>
                            </div>
                        </div> 
                        <div v-if="informe!=''">
                            <div class="table-responsive"  v-html="informe">
                            
                                
                            </div>
                        </div>
                        
                    </div>
                    <div v-if="id_informe=='3'">
                        <div v-if="info_bal_geral!=''"> 
                            <div class="table-responsive"  v-html="info_bal_geral">
                            
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!-- Modal busqueda cuentas-->
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
                            <div style="max-width: 120px !important;" class="col-md-2   ">
                                <label style='margin-top: 3px; '><b>Cuenta</b></label>                                
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="cta_busq" v-model="cta_busq" @keyup="buscarCuenta()">
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                
                                    <tr><th>Codigo</th><th>Cuenta</th><th>-</th></tr>
                                
                                    <tr v-for="cuentas in arrayCuentas" :key="cuentas.id">
                                        <td v-text="cuentas.codigo"></td>
                                        <td v-text="cuentas.nombre"></td>
                                        <td>
                                            <button type="button" style=" margin-right: -8px;" @click="cargarCuenta(cuentas)" class="btn btn-success btn-sm" title='Ver formato'>
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

        <!-- Modal busqueda tercero-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal2}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal2"></h4>
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
                                            <button type="button" style=" margin-right: -8px;" @click="cargarTercero(tercero)" class="btn btn-success btn-sm" title='Ver formato'>
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
    </main>
</template>

<script>
    import VueBarcode from 'vue-barcode';
    export default {
        props : ['ruta'],
        data (){
            return {
                id_informe: 0,
                fecha_ini :'',
                fecha_fin : '', 
                mes: '',
                mes2: '',   
                lista_meses : [
                    {num_mes:'1', nom_mes: 'Ene'},
                    {num_mes:'2', nom_mes:'Feb'},
                    {num_mes:'3', nom_mes:'Mar'},
                    {num_mes:'4', nom_mes:'Abr'},
                    {num_mes:'5', nom_mes:'May'},
                    {num_mes:'6', nom_mes:'Jun'},
                    {num_mes:'7', nom_mes:'Jul'},
                    {num_mes:'8', nom_mes:'Ago'},
                    {num_mes:'9', nom_mes:'Sep'},
                    {num_mes:'10', nom_mes:'Oct'},
                    {num_mes:'11', nom_mes:'Nov'},
                    {num_mes:'12', nom_mes:'Dic'},
                ],
                lista_anios : [
                    {num_anio:'2018'},
                    {num_anio:'2019'},
                    {num_anio:'2020'},
                    {num_anio:'2021'},
                    {num_anio:'2022'},
                    {num_anio:'2023'},
                    {num_anio:'2024'},
                    {num_anio:'2025'}   
                ],      
                dia1: '',
                dia2:'',
                dias_mes1: '',
                dias_mes2: '', 
                lista_dias1: [],
                lista_dias2: [],
                cuenta_ini : '',
                id_cuenta_ini : '',
                cuenta_fin : '',
                id_cuenta_fin : '',
                tercero : '',
                id_tercero : '',
                id_comprobante: '',            
                arrayCuentas : [],     
                arrayInformes : [],
                arrayTerceros : [],
                arrayTiposFormatos : [],
                informe : [],
                info_bal_geral : [],
                tipo_formato : '',
                id_rercero : '',
                tituloModal : '',
                tituloModal2 : '',
                modal : '',
                modal2 : '',
                buscar : '',   
                ctn_ban : 0,       
                tipo_cta : '',    
                cta_busq : '',  
                terc_busq : '',  
                anio : '',
            }
        },
        components: {
            
        
        },
        computed:{
           
            //Calcula los elementos de la paginación
            
        },
        methods : {
            listarInformes()
            {
                let me=this;
                var url=  this.ruta +'/info_auxiliares/selectInformes';
                axios.get(url).then(function (response) {
                     var respuesta= response;
                    //console.log(respuesta.informes);
                    me.arrayInformes = respuesta.data.informes;   
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            abrirModal(tipo_cta){               
                this.arrayCuentas=[];
                this.modal = 1;
                this.tipo_cta = tipo_cta;
                this.tituloModal = 'Seleccione una cuenta';
            },
            abrirModalT(tipo_cta){               
                this.arrayTerceros=[];
                this.modal2 = 1;
                this.tipo_cta = tipo_cta;
                this.tituloModal = 'Seleccione un tercero';
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal2='';
                this.tipo_cta = '';
                this.cta_busq = '';
            }, 
            cerrarModalT(){
                this.modal2=0;
                this.tituloModal2='';
                this.terc_busq = '';
            }, 
            buscarCuenta(){
                let me=this;            
                var url= this.ruta +'/planCuentas/selectCuentaInfo?busqueda=' + me.cta_busq;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCuentas = respuesta.cuentas;

                    
                })
                .catch(function (error) {
                    console.log(error);
                });

            },
            cargarCuenta(cuenta){
                
                if(this.tipo_cta == "1")
                {
                    this.cuenta_ini = cuenta['codigo'];
                    this.id_cuenta_ini = cuenta['id'];
                }
                if(this.tipo_cta == "2")
                {
                    this.cuenta_fin = cuenta['codigo'];
                    this.id_cuenta_fin = cuenta['id'];
                }
                
                this.cerrarModal();
            },
            cargarTercero(tercero){
                
                this.tercero = tercero['num_documento'];
                this.id_tercero = tercero['id'];                
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
            
            verAuxConSaldos(){
                let me=this;
                var aux_c1 =''; var aux_c2 =''; var aux_c3 =''; var aux_c4 ='';
                this.cargar_fechas();
                if(this.fecha_ini>this.fecha_fin){
                    alert("La fecha inicial debe ser menor a la final!!!");
                }
                else{
                    var url= this.ruta +'/info_auxiliares/aux_con_saldos?id_tercero=' + me.id_rercero + '&cuenta_ini='+ me.cuenta_ini + '&cuenta_fin='+ me.cuenta_fin + '&cuenta_fin='+ me.cuenta_fin + '&id_cuenta_ini=' +me.id_cuenta_ini+ '&id_cuenta_fin=' + me.id_cuenta_fin+'&id_tercero=' + me.id_tercero + '&fecha_ini=' + me.fecha_ini + '&fecha_fin=' + me.fecha_fin + '&id_formato='+me.tipo_formato;
                    axios.get(url).then(function (response) {
                        var respuesta= response.data;
                        console.log(response.data); 
                        me.informe = respuesta.html;                    
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            
            verBlanceGeneral(){
                let me = this;

                this.cargar_fechas();
                if(this.fecha_ini>this.fecha_fin){
                    alert("La fecha inicial debe ser menor a la final!!!");
                }
                else{
                    var url = this.ruta + '/info_auxiliares/balance_general?fecha_ini='+this.fecha_ini+'&fecha_fin='+this.fecha_fin;
                      axios.get(url).then(function (response) {
                        var respuesta= response.data;
                        console.log(response.data); 
                        me.info_bal_geral = respuesta.html;                    
                    })
                    .catch(function (error) {
                        console.log(error);
                    });                    
                }                
            },
            selectTipoFormato(){ 
                let me=this;
                var url= this.ruta +'/conf_formatos/get_tipos_formatos';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayTiposFormatos = respuesta.conf_formatos;
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
            quitar(opc){
                //alert(opc);
                if(opc==1){
                    this.id_cuenta_ini = '';
                    this.cuenta_ini = '';
                }
                if(opc==2){
                    this.id_cuenta_fin = '';
                    this.cuenta_fin = '';
                }
                if(opc==3){
                    this.id_tercero = '';
                    this.tercero = '';
                }
            },
            
            pdfFormato(){
                let me=this;
                //window.open('http://localhost:8000/fab_Cilindros/listado_pdf?id_proyecto='+ me.id_proyecto + '&fecha_ini='+me.fecha_ini+'&fecha_fin='+me.fecha_fin);
                window.open( this.ruta +'/auxiliares_conta/id_informe?id_proyecto='+ me.id_proyecto + '&fecha_ini='+me.fecha_ini+'&fecha_fin='+me.fecha_fin);
            }, 
            cargar_fechas(){
                 var aux_c1 =''; var aux_c2 =''; var aux_c3 =''; var aux_c4 ='';
                if(this.mes < 10){  aux_c1 = '0'; }
                if(this.mes2 < 10){  aux_c2 = '0'; }
                if(this.dia1 < 10){  aux_c3 = '0'; }
                if(this.dia2 < 10){  aux_c4 = '0'; }
                this.fecha_ini = this.anio + '-' + aux_c1 + '' + this.mes + '-' + aux_c3 + '' + this.dia1;
                this.fecha_fin = this.anio + '-' + aux_c2 + '' + this.mes2 + '-' + aux_c4 + '' + this.dia2;
                
            },
            listar_dias(){
                this.dias_mes1 = new Date(this.anio || new Date().getFullYear(), this.mes, 0).getDate();
                this.dias_mes2 = new Date(this.anio || new Date().getFullYear(), this.mes2, 0).getDate();

                this.lista_dias1 = [];
                this.lista_dias2 = [];
                for(var i=1; i<=this.dias_mes1;i++){
                    this.lista_dias1.push(i);
                }
                for(var i=1; i<=this.dias_mes2;i++){
                    this.lista_dias2.push(i);
                }
            }

        },

        mounted() {
            var d = new Date();
            var n = d.getMonth() +1;
            if(n < 10){ n = '0'+n;}
            this.mes= n;
            this.mes2= n;
            var dd = d.getDate();
            var mm = d.getMonth()+1;
            var yyyy = d.getFullYear();
            this.anio = yyyy;

            this.dia1 = '1'
            this.dia2 = dd;
            
            this.listar_dias();
            
            if(dd<10){
                dd='0'+dd;
            } 
            if(mm<10){
                mm='0'+mm;
            } 
            
            
            var f = yyyy+'-'+mm+'-'+'01';
            d = yyyy+'-'+mm+'-'+dd;
            this.fecha_fin = d;
            this.fecha_ini = f;
            this.selectTipoFormato();
            this.listarInformes();
        }
    }
</script>

