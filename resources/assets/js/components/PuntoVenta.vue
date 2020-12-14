<template>
        <main class="main">
            <div>
                <!-- Ejemplo de tabla Listado -->
                <div class="card" v-show="position==1">
                    <div class="card-header">
                        <div class="row">
                            
                            <div class="col-9">
                                <input class="form-control" type="search" placeholder="Buscar" aria-label="Search">
                            </div>
                            <div class="col-3">
                                <button class="btn btn-outline-success mt-1" type="submit">Buscar

                                </button>
                            </div>
                            
                        </div>
                        <div class="row">                            
                            <div class="col-12">
                                <div class="form-group">
                                <select class="mul-select" multiple="true">
                                    <option value="Cambodia">Cambodia</option>
                                    <option value="Khmer">Khmer</option>
                                    <option value="Thiland">Thiland</option>
                                    <option value="Koren">Koren</option>
                                    <option value="China">China</option>
                                    <option value="English">English</option>
                                    <option value="USA">USA</option>
                                </select>
                            </div> 
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-4">  
                                    <div class="thumbnail">
                                        <h6 class="precio-prod"><span class="badge  badge-primary">$ 5.000</span></h6>
                                        <img data-src="img/logo.png" class="img-thumbnail" alt="100x100" style="width: 100px; height: 100px;" src="img/logo.png" data-holder-rendered="true">
                                        
                                        <div class="caption">
                                            Corrientazo
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">  
                                    <div class="thumbnail">
                                        <h6 class="precio-prod"><span class="badge  badge-primary">$ 5.000</span></h6>
                                        <img data-src="img/logo.png" class="img-thumbnail" alt="100x100" style="width: 100px; height: 100px;" src="img/logo.png" data-holder-rendered="true">
                                        
                                        <div class="caption">
                                            Corrientazo
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">  
                                    <div class="thumbnail">
                                        <h6 class="precio-prod"><span class="badge  badge-primary">$ 5.000</span></h6>
                                        <img data-src="img/logo.png" class="img-thumbnail" alt="100x100" style="width: 100px; height: 100px;" src="img/logo.png" data-holder-rendered="true">
                                        
                                        <div class="caption">
                                            Corrientazo
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">  
                                    <div class="thumbnail">
                                        <h6 class="precio-prod"><span class="badge  badge-primary">$ 5.000</span></h6>
                                        <img data-src="img/logo.png" class="img-thumbnail" alt="100x100" style="width: 100px; height: 100px;" src="img/logo.png" data-holder-rendered="true">
                                        
                                        <div class="caption">
                                            Corrientazo
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">  
                                    <div class="thumbnail">
                                        <h6 class="precio-prod"><span class="badge  badge-primary">$ 5.000</span></h6>
                                        <img data-src="img/logo.png" class="img-thumbnail" alt="100x100" style="width: 100px; height: 100px;" src="img/logo.png" data-holder-rendered="true">
                                        
                                        <div class="caption">
                                            Corrientazo
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">  
                                    <div class="thumbnail">
                                        <h6 class="precio-prod"><span class="badge  badge-primary">$ 5.000</span></h6>
                                        <img data-src="img/logo.png" class="img-thumbnail" alt="100x100" style="width: 100px; height: 100px;" src="img/logo.png" data-holder-rendered="true">
                                        
                                        <div class="caption">
                                            Corrientazo
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">  
                                    <div class="thumbnail">
                                        <h6 class="precio-prod"><span class="badge  badge-primary">$ 5.000</span></h6>
                                        <img data-src="img/logo.png" class="img-thumbnail" alt="100x100" style="width: 100px; height: 100px;" src="img/logo.png" data-holder-rendered="true">
                                        
                                        <div class="caption">
                                            Corrientazo
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">  
                                    <div class="thumbnail">
                                        <h6 class="precio-prod"><span class="badge  badge-primary">$ 5.000</span></h6>
                                        <img data-src="img/logo.png" class="img-thumbnail" alt="100x100" style="width: 100px; height: 100px;" src="img/logo.png" data-holder-rendered="true">
                                        
                                        <div class="caption">
                                            Corrientazo
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">  
                                    <div class="thumbnail">
                                        <h6 class="precio-prod"><span class="badge  badge-primary">$ 5.000</span></h6>
                                        <img data-src="img/logo.png" class="img-thumbnail" alt="100x100" style="width: 100px; height: 100px;" src="img/logo.png" data-holder-rendered="true">
                                        
                                        <div class="caption">
                                            Corrientazo
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>

                    </div>
                </div>

                <div class="card" v-show="position==2">
                    <div class="row mt-1">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-9">
                                            <button class="btn btn-secondary" @click="position=1">Productos</button>
                                        </div>
                                        <div class="col-3">
                                            <button type="button" class="btn btn-outline-primary" style="margin-left: -69px;">
                                                Descartar
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor"       xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        
                                    </div>
                                    <div class="row">                            
                                        <div class="col-12">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="input-group mb-3">
                                                
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroup-sizing-default">Cliente</span>
                                                </div>
                                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                            
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="inputGroupSelect01">Mezas</label>
                                                </div>
                                                <select class="custom-select" id="inputGroupSelect01">
                                                    <option selected>Ubicacion...</option>
                                                    <option value="1">meza 1</option>
                                                    <option value="2">meza 2</option>
                                                    <option value="3">meza 3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-12">
                                               
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                                VISTA DE FACTURA 
                               
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-12">
                        <a @click="position=2" class="btn btn-block btn-lg active btn-success" href="#" role="button">Facturar</a>
                    </div>
                </div>
            </div>
            
        </main>
</template>

<script>

    import vSelect from 'vue-select';
    export default {
        props : ['ruta'],
        data (){
            return {
                position: 1,
                ingreso_id: 0,
                idproveedor:0,
                proveedor:'',
                nombre : '',
                tipo_comprobante : 'BOLETA',
                serie_comprobante : '',
                num_comprobante : '',
                impuesto: 0.18,
                total:0.0,
                totalImpuesto: 0.0,
                totalParcial: 0.0, 
                arrayIngreso : [],
                arrayProveedor: [],
                arrayDetalle : [],
                arrayDetalleT : [],
                listado:1,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                tipoAccion2 : 0,
                tipoAccionModalTerceros : 0,
                errorFacturacion : 0,
                errorMostrarMsjFacturacion : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                permisosUser: {
                    'leer' : 1,
                    'escribir':1,
                    'crear':1,
                    'actualizar':1,
                    'anular':1,
                },
                offset : 3,
                criterio : 'num_comprobante',
                buscar : '',
                criterioA:'nombre',
                buscarA: '',
                buscarCategoriaA : '',
                arrayCategoria2 : [],
                arrayArticulo: [],
                idarticulo: 0,
                codigo: '',
                articulo: '',
                precio: 0,
                cantidad:1,
                nom_presentacion : '',
                id_presentacion : 0,
                padreDetalle : '',
                idDetalleAsociado : 0,
                tipo_vista_articulo:1,

                // variables modal buscar tercero
                modal2 : '',
                tercero :'',
                id_tercero : '',
                tituloModal2 : '',
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

                // variables nuevas

                facturacion_id:0,
                num_factura:0,
                id_tercero_facturacion:0,
                tercero_facturacion:'',
                id_usuario:0,
                fec_edita:'',
                subtotal:0.0,
                valor_iva:0.0,
                total:0.0,
                abono:0.0,
                abono2:0.0,
                saldo:0.0,
                detalle:'',
                descuento:0,
                fec_registra:'',
                fec_envia:'',
                fec_anula:'',
                fecha : '',
                stock : 0,
                nom_caja_cierre_facturacion : '',
                id_caja_facturacion : 0,
                id_cierre_caja_facturacion : 0,

                arrayFacturacion : [],
                arrayFacturacionT : [],

                iva:0,

                fechaActual: '',
                fechaHoraActual:'',

                estado: 0,
                cambiarEstado: 0,

                // Variables filtro
                numFacturaFiltro : '',
                estadoFiltro : '',
                idTerceroFiltro : '',
                terceroFiltro : '',
                desdeFiltro : '2019-01-01',
                hastaFiltro : '',
                ordenFiltro : '',
                idVendedorFiltro : '',
                vendedorFiltro : '',
                
                // array del select de zonas
                arrayZonas : [],
                lugar : '',

                // modal cantidad articulo
                modalCantidadArticulo : 0,
                tituloModalCantidadArticulo : '',
                cantidadArticulo : 0,
                precioArticulo : 0,
                stockCantidadArticulo : 0,
                saldoParcialCantidadArticulo : false,
                arrayInfoArticuloModalCantidad : [],
                accionCodigoBarras : 0,

                // tarifarios
                id_tarifario : 0,
                arrayTarifario : [],

                // variables cierre de caja
                cierre_caja_id : 0,
                nombre_caja : '',
                id_caja_cierre : '',
                vr_inicial_cierre : 0,
                obs_inicial_cierre : '',
                vr_gastos_cierre : 0,
                obs_gastos_cierre : '',
                vr_software_cierre : 0,
                vr_final_cierre : 0,
                arrayCierresXCajas : [],
                arrayCierresUsuario : [],
                arrayCajas: [],
                modalCierreCaja : 0,
                tituloModalCierre : '',
                tipoAccionCierre : 0,
                ban : 0,

                hasError : {
                    vr_inicial_cierre : 0,
                    vr_gastos_cierre : 0,
                    vr_final_cierre : 0,
                }
            }
        },
        components: {
            vSelect
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
            calcularSubtotal: function(){
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+((this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)-this.arrayDetalle[i].valor_descuento);
                }
                resultado = resultado-this.calcularTotalIva;
                return resultado;
            },
            calcularDescuento: function(){
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+parseInt(this.arrayDetalle[i].valor_descuento);
                }
                return resultado;
            },
            calcularTotal: function(){
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+((this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)-this.arrayDetalle[i].valor_descuento)
                }
                return resultado;
            },
            calcularTotalIva: function(){
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado += this.arrayDetalle[i].valor_iva;
                }
                // resultado = this.total-resultado;
                resultado = Math.round(resultado);
                return resultado;
            },
            calcularSaldo: function(){
                var resultado=0.0;

                resultado=resultado+(this.calcularTotal-this.abono);
                
                return resultado;
            },
        },
        methods : {
            listarFacturacion (page,numFacturaFiltro,estadoFiltro,idTerceroFiltro,ordenFiltro,desdeFiltro,hastaFiltro,idVendedorFiltro){
                let me=this;

                var url= this.ruta +'/facturacion?page=' + page + '&numFacturaFiltro='+ numFacturaFiltro + '&estadoFiltro='+ estadoFiltro + '&idTerceroFiltro='+ idTerceroFiltro + '&ordenFiltro='+ ordenFiltro + '&desdeFiltro='+ desdeFiltro + '&hastaFiltro='+ hastaFiltro + '&idVendedorFiltro='+ idVendedorFiltro+'&id_cierre_caja='+me.id_cierre_caja_facturacion;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayFacturacion = respuesta.facturacion.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarDetalle(id_factura){
                let me=this;
                var url= this.ruta +'/detalle_facturacion/buscarDetalleFacturacion?id_factura=' + id_factura;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalles;
                    me.arrayDetalleT = respuesta.detalles;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectProveedor(search,loading){
                let me=this;
                loading(true)

                var url= this.ruta +'/proveedor/selectProveedor?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayProveedor=respuesta.proveedores;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectCategoria2(){
                let me=this;
                var url= this.ruta + '/categoria/selectCategoria';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayCategoria2 = respuesta.categorias;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectTarifarios(){
                let me=this;
                var url= this.ruta + '/con_tarifario/selectConTarifario2';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayTarifario = respuesta.tarifario;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            /*listarCajas(page,buscar,criterio){
                let me=this;
                var ban1 = 0;
                var ban2 = 0;
                var url= this.ruta +'/cierres_caja?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio+ '&fec_desde=&fec_hasta=';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCierresXCajas = respuesta.cierres_caja.data;

                    if(!me.arrayCierresXCajas.length){
                        me.mostrarDetalle('cierres_caja','registrar');
                    }
                    else
                    {
                        me.arrayCierresXCajas.forEach(function(cierre){
                            if(cierre['usu_crea']==respuesta.id_usuario)
                            {
                                ban1 = 1;
                                if(cierre['estado']==1)
                                {
                                    ban2 = 1;
                                    
                                    var d = new Date;
                                    var dd = d.getDate(); var mm = d.getMonth()+1; var yyyy = d.getFullYear();
                                    var h = d.getHours(); var min = d.getMinutes(); var sec = d.getSeconds();
                                    
                                    if(dd<10){dd='0'+dd;}  if(mm<10){mm='0'+mm;} if(h<10){h='0'+h;} if(min<10){min='0'+min;} if(sec<10){sec='0'+sec;}

                                    var fechaHora = yyyy+'-'+mm+'-'+dd+' '+h+':'+min+':'+sec;
                                    var fecha = yyyy+'-'+mm+'-'+dd;

                                    var n1 = cierre['created_at'].split(" "); var n2 = n1[0].split("-"); var n3 = n1[1].split(":");
                                                                        
                                    if(yyyy == n2[0])
                                    {
                                        if(mm == n2[1])
                                        {
                                            var restaDia = parseFloat(dd)-parseFloat(n2[2]);
                                            if(restaDia<=1)
                                            {
                                                if(restaDia==1)
                                                {
                                                    var horasDiaAnterior = 24-n3[0]
                                                    var sumaHoras = horasDiaAnterior+h;
                                                    if(sumaHoras<24)
                                                    {
                                                        me.id_cierre_caja_facturacion = cierre['id'];
                                                        me.nom_caja_cierre_facturacion = cierre['nombre'];
                                                        me.cierre_caja_id = cierre['id'];
                                                        me.id_caja_cierre = cierre['id_caja'];
                                                        me.nom_caja_cierre = cierre['nombre'];
                                                        me.vr_inicial_cierre = cierre['vr_inicial'];
                                                        me.obs_inicial_cierre = cierre['obs_inicial'];
                                                        
                                                        me.listarFacturacion(1,me.numFacturaFiltro,me.estadoFiltro,me.idTerceroFiltro,me.ordenFiltro,me.desdeFiltro,me.hastaFiltro,me.idVendedorFiltro);
                                                    }
                                                    else{ me.mostrarDetalle('cierres_caja','listar_cierres',cierre); }
                                                }
                                                else
                                                {
                                                    me.id_cierre_caja_facturacion = cierre['id'];
                                                    me.nom_caja_cierre_facturacion = cierre['nombre'];
                                                    me.cierre_caja_id = cierre['id'];
                                                    me.id_caja_cierre = cierre['id_caja'];
                                                    me.nom_caja_cierre = cierre['nombre'];
                                                    me.vr_inicial_cierre = cierre['vr_inicial'];
                                                    me.obs_inicial_cierre = cierre['obs_inicial'];

                                                    me.listarFacturacion(1,me.numFacturaFiltro,me.estadoFiltro,me.idTerceroFiltro,me.ordenFiltro,me.desdeFiltro,me.hastaFiltro,me.idVendedorFiltro);
                                                }
                                            }
                                            else{ me.mostrarDetalle('cierres_caja','listar_cierres',cierre); }
                                        }
                                        else{ me.mostrarDetalle('cierres_caja','listar_cierres',cierre); }
                                    }
                                    else{ me.mostrarDetalle('cierres_caja','listar_cierres',cierre); }
                                }
                            }
                        });

                        if(ban1 == 1)
                        {
                            if(ban2 == 0)
                            {
                                me.mostrarDetalle('cierres_caja','registrar');
                            }
                        }
                        else
                        {
                            me.mostrarDetalle('cierres_caja','registrar');
                        }
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },*/
            listarCajas(){
                let me=this;
                var url= this.ruta +'/cierres_caja/validarCierreCaja';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    var ban = respuesta.ban;
                    me.arrayCierresXCajas = respuesta.cierres_cajas;

                    if(ban==0 || ban==1)
                    {
                        // me.mostrarDetalle('cierres_caja','registrar');
                        Swal.fire({
                            // toast: true,
                            // position: 'top-end',
                            type: 'error',
                            title: 'Abir caja',
                            position: 'center',
                            showConfirmButton: false,
                            timer: 1700
                        })
                    }
                    else
                    {
                        if(ban==3)
                        {
                            me.id_caja_facturacion = me.arrayCierresXCajas[0]['id'];
                            me.id_cierre_caja_facturacion = me.arrayCierresXCajas[0]['id'];
                            me.nom_caja_cierre_facturacion = me.arrayCierresXCajas[0]['nombre'];
                            me.cierre_caja_id = me.arrayCierresXCajas[0]['id'];
                            me.id_caja_cierre = me.arrayCierresXCajas[0]['id_caja'];
                            me.nom_caja_cierre = me.arrayCierresXCajas[0]['nombre'];
                            me.vr_inicial_cierre = me.arrayCierresXCajas[0]['vr_inicial'];
                            me.obs_inicial_cierre = me.arrayCierresXCajas[0]['obs_inicial'];
                            
                            me.listarFacturacion(1,me.numFacturaFiltro,me.estadoFiltro,me.idTerceroFiltro,me.ordenFiltro,me.desdeFiltro,me.hastaFiltro,me.idVendedorFiltro);
                        }

                        if(ban==2)
                        {
                            // me.mostrarDetalle('cierres_caja','listar_cierres',me.arrayCierresXCajas[0]);
                            Swal.fire({
                                // toast: true,
                                // position: 'top-end',
                                type: 'error',
                                title: 'Abir caja',
                                position: 'center',
                                showConfirmButton: false,
                                timer: 1700
                            })
                        }
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            SelectCierreXCaja(id){
                let me=this;
                var url= this.ruta +'/cierres_caja/SelectCierreXCaja?id='+id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data.cierres_caja[0];
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
            selectValorInicialCaja(id){
                let me=this;
                var url= this.ruta +'/cierres_caja/selectValorInicialCaja?id='+id;
                if(id!=0 && id!='')
                {
                    axios.get(url).then(function (response) {
                        var respuesta= response.data;
                        if(respuesta.cierres_caja[0])
                        {
                            me.vr_inicial_cierre = respuesta.cierres_caja[0]['vr_final'];
                        }
                        else
                        {
                            me.vr_inicial_cierre = 0;
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
                else
                {
                    alert('id vacio');
                }
            },
            registrarCierreXCaja(){
                if (this.validarCierreXCaja()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/cierres_caja/registrar',{
                    'id_caja': this.id_caja_cierre,
                    'vr_inicial': this.vr_inicial_cierre,
                    'obs_inicial': this.obs_inicial_cierre,
                    'vr_gastos': this.vr_gastos_cierre,
                    'obs_gastos': this.obs_gastos_cierre,
                    'vr_final': this.vr_final_cierre,
                }).then(function (response) {
                    me.modalCierreCaja = 0;
                    me.listarCajas();
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
                    'id_caja': this.id_caja_cierre,
                    'vr_inicial': this.vr_inicial_cierre,
                    'obs_inicial': this.obs_inicial_cierre,
                    'vr_gastos': this.vr_gastos_cierre,
                    'obs_gastos': this.obs_gastos_cierre,
                    'vr_final': this.vr_final_cierre,
                    'id': this.cierre_caja_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCajas();
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            validarCierreXCaja(){
                this.hasError['vr_inicial_cierre'] = 0;
                this.hasError['vr_gastos_cierre'] = 0;
                this.hasError['vr_final_cierre'] = 0;
                var error = 0;

                if(!this.vr_inicial_cierre || this.vr_inicial_cierre<=0){error=1; this.hasError['vr_inicial_cierre']=1;}
                if(!this.vr_gastos_cierre || this.vr_gastos_cierre<=0){error=1; this.hasError['vr_gastos_cierre']=1;}
                if(this.tipoAccionCierre==2)
                {
                    if(!this.vr_final_cierre || this.vr_final_cierre<=0){error=1; this.hasError['vr_final_cierre']=1;}
                }

                return error;
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

                    axios.put(this.ruta +'/cierre_caja/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.cerrarModalCierreCaja();
                        me.listarCajas();
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
                        me.listarCajas();
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
            cerrarCierreXCaja(id){
                if(this.validarCierreXCaja()){
                    return;
                }
                let me = this;
                
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
                        let me = this;

                        axios.put(this.ruta +'/cierres_caja/cerrar',{
                            'id_caja': this.id_caja_cierre,
                            'obs_inicial': this.obs_inicial_cierre,
                            'vr_gastos': this.vr_gastos_cierre,
                            'obs_gastos': this.obs_gastos_cierre,
                            'vr_final': this.vr_final_cierre,
                            'id': this.cierre_caja_id
                        }).then(function (response) {
                            me.id_caja_facturacion = 0;
                            me.nom_caja_cierre_facturacion = '';
                            me.cerrarModalCierreCaja();
                            Swal.fire(
                            'Desactivado!',
                            'El registro ha sido cerrado con éxito.',
                            'success')
                            me.listarCajas();
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {}
                }) 
            },
            cerrarModalCierreCaja(){
                this.modalCierreCaja=0;
                this.tituloModalCierre='';
                // this.id_caja_cierre='';
                // this.vr_inicial_cierre=0;
                // this.obs_inicial_cierre = '';
                // this.vr_gastos_cierre = 0;
                // this.obs_gastos_cierre = '';
                // this.vr_software_cierre = 0;
                // this.vr_final_cierre = 0;
                // this.cierre_caja_id = 0;
                this.arrayCierresUsuario = 0;
                this.arrayCierresXCajas = 0;
                this.ban=0;

                // this.id_caja_facturacion = 0;
                // this.nom_caja_cierre_facturacion = '';
            },
            getDatosProveedor(val1){
                let me = this;
                me.loading = true;
                me.idproveedor = val1.id;
            },
            buscarArticulo(){
                let me=this;
                var url= this.ruta +'/articulo/buscarArticulo?filtro=' + me.codigo;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos;

                    if (me.arrayArticulo.length>0){
                        if (me.arrayArticulo[0]['productos_asociados'].length>0){
                            me.buscarA = me.arrayArticulo[0]['codigo'];
                            me.abrirModal();
                        }
                        else {
                            var p = '';
                            if(me.arrayArticulo[0]['padre']!='')
                            {
                                p = ' - (Presentacion asociada: '+me.arrayArticulo[0]['nom_presentacion']+')';
                            }
                            else
                            {
                                p = ' - '+me.arrayArticulo[0]['nom_presentacion'];
                            }
                            me.codigo=me.arrayArticulo[0]['codigo'];
                            me.articulo= me.arrayArticulo[0]['nombre'];
                            me.idarticulo=me.arrayArticulo[0]['id'];
                            me.precio = me.arrayArticulo[0]['precio_venta'];
                            me.cantidad = 1;
                            me.stock = me.arrayArticulo[0]['stock'];
                            for(var i=0; i<me.arrayArticulo[0]['productos_iva'].length; i++)
                            { 
                                if(me.arrayArticulo[0]['productos_iva'][i]['tipo_iva']=='Venta')
                                {
                                    me.porcentaje = me.arrayArticulo[0]['productos_iva'][i]['porcentaje'];
                                }
                            }
                            // me.porcentaje = me.arrayArticulo[0]['porcentaje'];
                            me.descuento = 0;
                            me.id_presentacion = me.arrayArticulo[0]['id_presentacion'];
                            me.idDetalleAsociado = me.arrayArticulo[0]['id_asociado'];
                            // me.cantidad=me.arrayArticulo[0]['stock'];
                        }
                    }
                    else{
                        me.articulo='No existe artículo';
                        me.idarticulo=0;
                        me.precio = 0;
                        me.cantidad = 0;
                        me.stock = 0;
                        me.padreDetalle = '';
                        me.idDetalleAsociado = 0;
                        me.descuento = 0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            sugerirNumFactura(){
                let me=this;
                var url= this.ruta +'/facturacion/buscarNumFacturaSugerida';
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data.facturacion;
                    
                    if(respuesta.length)
                    {
                        me.num_factura = parseInt(respuesta[0].num_factura)+1;
                    }
                    else
                    {
                        me.num_factura = 1;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarEstadoFacturacion(id_factura, accion){
                let me=this;
                var cambiarEstado = '';
                var nomEstado = '';

                switch(accion)
                {
                    case 'registrar':{
                        me.sugerirNumFactura();
                        cambiarEstado = '2';
                        nomEstado = '"'+'Registrado'+'"';
                        break;
                    };
                    case 'enviar':{
                        cambiarEstado = '3';
                        nomEstado = '"'+'Enviado'+'"';
                        break;
                    };
                    case 'anular':{
                        cambiarEstado = '4';
                        nomEstado = '"'+'Anulado'+'"';
                        break;
                    };
                }

                Swal.fire({
                title: 'Esta seguro de cambiar el estado a '+nomEstado+'?',
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

                    axios.put(this.ruta +'/facturacion/cambiarEstado',{
                        'estado': cambiarEstado,
                        'num_factura': me.num_factura,
                        'id': id_factura
                    }).then(function (response) {
                        me.ocultarDetalle();
                        me.listarFacturacion(1,'','','','','','','');
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    
                }
                }) 

                // axios.put(this.ruta +'/facturacion/cambiarEstado',{
                //     'estado': cambiarEstado,
                //     'id': id_factura
                // }).then(function (response) {
                //     me.listarFacturacion(1,'','','','','','','');
                // }).catch(function (error) {
                //     console.log(error);
                // });
            },
            cargarPreciosTarifarios(id){
                let me = this;

                var arrayIds = [];
                me.arrayDetalle.forEach(function(detalle){
                    arrayIds.push({id : detalle['idarticulo']});
                });

                if(arrayIds.length)
                {
                    var url= this.ruta + '/producto_tarifario/cargarPreciosTarifarios?arrayDetalle='+JSON.stringify(arrayIds)+'&id_tarifario='+id;
                    axios.get(url).then(function (response) {
                        var respuesta= response.data;
                        
                        for(var i=0; i<me.arrayDetalle.length; i++)
                        {
                            for(var j=0; j<respuesta.producto_tarifario.length; j++)
                            {
                                if(me.arrayDetalle[i].idarticulo==respuesta.producto_tarifario[j].id_producto){
                                    me.arrayDetalle[i].precio = respuesta.producto_tarifario[j].valor;
                                }
                            }
                        }
                        
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarFacturacion(1,numFacturaFiltro,estadoFiltro,idTerceroFiltro,ordenFiltro,desdeFiltro,hastaFiltro,idVendedorFiltro);
            },
            /*encuentra(id,presentacion){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].id==id && this.arrayDetalle[i].id_presentacion==presentacion){
                        sw=true;
                    }
                }
                return sw;
            },*/
            encuentra(id,id_asociado){
                let me=this;
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].id==id)
                    {
                        if(this.arrayDetalle[i].id_asociado=='' && id_asociado=='')
                        {
                            sw=true;
                        }
                    }
                }
                return sw;
            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index, 1);
            },
            agregarDetalle(){
                let me=this;
                if(me.idarticulo==0 || me.cantidad==0 || me.precio==0){
                }
                else{
                    if(me.encuentra(me.idarticulo, me.idDetalleAsociado)){
                        Swal.fire({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese artículo ya se encuentra agregado!',
                            })
                    }
                    else{
                        me.arrayDetalle.push({
                            idarticulo: me.idarticulo,
                            articulo: me.articulo,
                            cantidad: me.cantidad,
                            valor_descuento: me.descuento,
                            precio: me.precio,
                            iva: me.iva,
                            stock : me.stock,
                            descuento : me.descuento,
                            nom_presentacion : me.nom_presentacion,
                            id_presentacion : me.id_presentacion,
                            padre : me.padreDetalle
                        });
                        me.codigo="";
                        me.idarticulo=0;
                        me.articulo="";
                        me.cantidad=0;
                        me.precio=0;
                        me.iva = 0;
                        me.descuento = 0;
                        me.nom_presentacion = '';
                        me.id_presentacion = 0;
                        me.padreDetalle = '';
                        me.idDetalleAsociado = 0;
                    }
                    
                }
            },
            agregarDetalleModal(data =[]){
                let me=this;

                if(me.encuentra(data['id'], data['id_asociado'])){
                    Swal.fire({
                        type: 'error',
                        title: 'Error...',
                        text: 'Ese artículo ya se encuentra agregado!',
                        })
                }
                else{
                    var p = '';
                    if(data['padre']!='') {p = ' '+data['nom_presentacion']+' (Presentacion asociada)';}
                    else {p = ' - '+data['nom_presentacion'];}

                    var ivaVenta = 0;
                    data['productos_iva'].forEach(function(iva){
                        if(iva['tipo_iva']=='Venta'){ivaVenta=iva['porcentaje'];}
                    });

                    var descu = 0;
                    if(data['descuento'] && data['descuento']!='') {descu=data['descuento'];}

                    me.arrayDetalle.push({
                        idarticulo: data['id'],
                        id_asociado: data['id_asociado'],
                        codigo: data['codigo'],
                        articulo: data['nombre'],
                        porcentaje : ivaVenta,
                        cantidad: data['cant'],
                        precio: data['precio_venta'],
                        precio_venta: data['precio_venta'],
                        iva : ivaVenta,
                        nom_presentacion : data['nom_presentacion'],
                        id_presentacion : data['id_presentacion'],
                        padre : data['padre'],
                        unidades : data['unidades'],
                        descuento : 0,
                        valor_descuento : 0,
                    }); 
                }
            },
            agregarDetalleModalCantidadArticulo(){
                let me=this;
                
                if(me.encuentra(me.arrayInfoArticuloModalCantidad.id && me.arrayInfoArticuloModalCantidad.id_asociado)){
                    Swal.fire({
                        type: 'error',
                        title: 'Error...',
                        text: 'Ese artículo ya se encuentra agregado!',
                        })
                }
                else{
                    var p = ''
                    if(me.arrayInfoArticuloModalCantidad.padre!='') {p = ' '+data['nom_presentacion']+' (Presentacion asociada)';}
                    else {p = ' - '+me.arrayInfoArticuloModalCantidad.padre;}

                    var ivaVenta = 0;
                    me.arrayInfoArticuloModalCantidad.productos_iva.forEach(function(iva){
                        if(iva['tipo_iva']=='Venta'){ivaVenta=iva['porcentaje'];}
                    });

                    me.arrayDetalle.push({
                        idarticulo: me.arrayInfoArticuloModalCantidad.id,
                        id_asociado: me.arrayInfoArticuloModalCantidad.id_asociado,
                        articulo: me.arrayInfoArticuloModalCantidad.codigo+' - '+me.arrayInfoArticuloModalCantidad.nombre,
                        porcentaje : ivaVenta,
                        cantidad: me.cantidadArticulo,
                        precio: me.arrayInfoArticuloModalCantidad.precio_venta,
                        precio_venta : me.arrayInfoArticuloModalCantidad.precio_venta,
                        iva: ivaVenta,
                        nom_presentacion : me.arrayInfoArticuloModalCantidad.nom_presentacion,
                        id_presentacion : me.arrayInfoArticuloModalCantidad.id_presentacion,
                        padre : me.arrayInfoArticuloModalCantidad.padre,
                        descuento : 0,
                        valor_descuento : 0,
                    }); 
                }
                me.cerrarModalCantidadArticulo();
            },
            listarArticulo (buscar,criterio,categoria){
                let me=this;
                var var_categoria='';
                if(categoria && categoria!=''){var_categoria='&categoria='+categoria;}
                var url= this.ruta +'/articulo/listarArticulo?buscar='+ buscar + '&criterio='+ criterio+var_categoria+'&id_tarifario='+me.id_tarifario;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = [];
                    me.arrayArticulo = respuesta.articulos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarFacturacion(){
                if (this.validarFacturacion()){
                    return;
                }
                
                let me = this;
                
                // for(var i=0; i<me.arrayDetalle.length; i++)
                // {
                //     me.descuento += parseFloat(me.arrayDetalle[i]['valor_descuento']);
                //     me.iva += parseFloat(me.arrayDetalle[i]['valor_iva']);
                //     me.subtotal += parseFloat(me.arrayDetalle[i]['valor_subtotal']);
                // }
                // me.total += parseFloat(me.subtotal)+parseFloat(me.iva);
                // me.sugerirNumFactura();

                axios.post(this.ruta +'/facturacion/registrar',{
                    'num_factura': null,
                    'id_tercero': me.id_tercero,
                    'fec_edita': null,
                    'usu_edita': null,
                    'subtotal': me.subtotal,
                    'valor_iva': me.valor_iva,
                    'total': me.valor_final,
                    'abono': me.abono,
                    'saldo': me.saldo,
                    'detalle': me.detalle,
                    'lugar': me.lugar,
                    'descuento': me.calcularDescuento,
                    'fec_registra': null,
                    'fec_envia': null,
                    'fec_anula': null,
                    'usu_registra': null,
                    'usu_envia': null,
                    'usu_anula': null,
                    'fecha': me.fecha,
                    'id_tarifario': me.id_tarifario,
                    'id_cierre_caja': me.id_cierre_caja_facturacion,
                    'data': me.arrayDetalle,
                    'tipo_movimiento' : 4,
                    'sumatoria' : 0
                }).then(function (response) {
                    me.ocultarDetalle();
                    me.listarFacturacion(1,'','','','','','','');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarFacturacion(){
                if (this.validarFacturacion()){
                    return;
                }
                
                let me = this;
                
                // me.subtotal = 0;
                // me.iva = 0;
                // me.descuento = 0;
                // me.total = 0;
                // for(var i=0; i<me.arrayDetalle.length; i++)
                // {
                //     me.descuento += parseFloat(me.arrayDetalle[i].valor_descuento);
                //     me.iva += parseFloat(me.arrayDetalle[i].valor_iva);
                //     me.subtotal += parseFloat(me.arrayDetalle[i].valor_subtotal);
                // }
                
                // me.total = parseFloat(me.subtotal)+parseFloat(me.iva);
                if(me.estado==2)
                {
                    me.sugerirNumFactura();
                }
                
                axios.put(this.ruta +'/facturacion/actualizar',{
                    'num_factura': me.num_factura,
                    'id_tercero': me.id_tercero,
                    'fec_edita': me.fechaHoraActual,
                    'subtotal': me.subtotal,
                    'valor_iva': me.valor_iva,
                    'total': me.valor_final,
                    'abono': me.abono,
                    'saldo': me.saldo,
                    'detalle': me.detalle,
                    'lugar': me.lugar,
                    'descuento': me.calcularDescuento,
                    'fec_registra': null,
                    'fec_envia': null,
                    'fec_anula': null,
                    'usu_registra': null,
                    'usu_envia': null,
                    'usu_anula': null,
                    'fecha': me.fecha,
                    'id_tarifario': me.id_tarifario,
                    'estado': me.estado,
                    'data': me.arrayDetalle,
                    'tipo_movimiento' : 4,
                    'sumatoria' : 0,
                    'id' : me.facturacion_id
                }).then(function (response) {
                    me.ocultarDetalle();
                    me.listarFacturacion(1,'','','','','','','');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarFacturacion(){
                this.errorFacturacion=0;
                this.errorMostrarMsjFacturacion =[];

                if (this.fecha==0) this.errorMostrarMsjFacturacion.push("Ingrese la fecha");
                // if (this.num_factura==0) this.errorMostrarMsjFacturacion.push("Seleccione el comprobante");
                if (!this.id_tercero) this.errorMostrarMsjFacturacion.push("Seleccione un tercero");
                if (!this.lugar) this.errorMostrarMsjFacturacion.push("Seleccione un lugar");
                if (this.arrayDetalle.length<=0) this.errorMostrarMsjFacturacion.push("Ingrese detalles");

                if (this.errorMostrarMsjFacturacion.length) this.errorFacturacion = 1;

                return this.errorFacturacion;
            },
            selectZonas(){
                let me=this;
                var url= this.ruta + '/zona/selectZona';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayZonas = respuesta.zona;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            mostrarDetalle(modelo, accion, data=[]){
                let me=this;
                
                switch(modelo){
                    case 'facturacion':{
                        me.listado=0;
                        switch(accion){
                            case 'registrar':{
                                // me.sugerirNumFactura();
                                me.tipoAccion2 = 1;
                                me.facturacion_id=0;
                                me.num_factura=null;
                                me.id_tercero=0;
                                me.tercero = '';
                                me.tercero_facturacion='';
                                me.fec_edita='';
                                me.subtotal=0.0;
                                me.valor_iva=0.0;
                                me.total=0.0;
                                me.abono=0.0;
                                me.saldo=0.0;
                                me.detalle='';
                                me.lugar = '',
                                me.descuento=0.0;
                                me.fec_registra='';
                                me.fec_envia='';
                                me.fec_anula='';

                                me.arrayArticulo=[];
                                me.arrayDetalle=[];
                                me.arrayTerceros=[];
                                me.listarFacturacion(1,'','','','','','','');
                                break;
                            };
                            case 'actualizar':{
                                me.tipoAccion2 = 2;
                                me.facturacion_id=data['id'];
                                me.num_factura=data['num_factura'];
                                me.id_tercero=data['id_tercero'];
                                me.tercero=data['nom_tercero'];
                                me.fec_edita=me.fechaHoraActual;
                                me.subtotal=data['subtotal'];
                                me.valor_iva=data['valor_iva'];
                                me.total=data['total'];
                                me.abono=data['abono'];
                                me.abono2=data['abono'];
                                me.saldo=data['saldo'];
                                me.detalle=data['detalle'];
                                me.lugar = data['lugar'];
                                // me.descuento=data['descuento'];
                                me.fec_registra=data['fec_registra'];
                                me.fec_envia=data['fec_envia'];
                                me.fec_anula=data['fec_anula'];
                                me.fecha =data['fecha'];
                                me.id_tarifario =data['id_tarifario'];
                                me.estado = data['estado'];
                                

                                me.arrayArticulo=[];
                                me.arrayTerceros=[];
                                me.arrayDetalle=[]
                                // me.listarFacturacion(1,'','','','','','','');)
                                me.listarDetalle(data['id']);
                                break;
                            };
                        }
                        me.selectZonas();
                        me.selectTarifarios();
                        break;
                    }
                    case "cierres_caja":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.arrayCierresUsuario = [];
                                this.modalCierreCaja = 1;
                                this.tituloModalCierre = 'Abrir caja';
                                this.id_caja_cierre='';
                                this.vr_inicial_cierre=0;
                                this.obs_inicial_cierre = '';
                                this.vr_gastos_cierre = 0;
                                this.obs_gastos_cierre = '';
                                this.vr_software_cierre = 0;
                                this.vr_final_cierre = 0;
                                this.cierre_caja_id = 0;
                                this.tipoAccionCierre = 1;
                                break;
                            }
                            case 'cerrar_caja':
                            {
                                //console.log(data);
                                if(data.length!=0)
                                {
                                    this.arrayCierresUsuario = [];
                                    this.modalCierreCaja=1;
                                    this.tituloModalCierre='Cerrar caja';
                                    this.tipoAccionCierre=2;
                                    this.cierre_caja_id=data['id'];
                                    this.id_caja_cierre = data['id_caja'];
                                    this.vr_inicial_cierre = data['vr_inicial'];
                                    this.obs_inicial_cierre = data['obs_inicial'];
                                    this.vr_gastos_cierre = data['vr_gastos'];
                                    this.obs_gastos_cierre = data['obs_gastos'];
                                    this.vr_software_cierre = 0;
                                    this.vr_final_cierre = data['vr_final'];
                                }
                                else
                                {
                                    this.arrayCierresUsuario = [];
                                    this.modalCierreCaja=1;
                                    this.tituloModalCierre='Cerrar caja';
                                    this.tipoAccionCierre=2;
                                }
                                break;
                            }
                            case 'listar_cierres':
                            {
                                console.log(data);
                                Swal.fire({
                                title: 'ERROR!',
                                text: "Este usuario tiene una caja abierta desde hace mas de 24 horas",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok!'
                                }).then((result) => {
                                    if(result.value){
                                        this.arrayCierresUsuario.push({
                                            created_at : data['created_at'],
                                            estado : data['estado'],
                                            id : data['id'],
                                            id_caja : data['id_caja'],
                                            nombre : data['nombre'],
                                            obs_gastos : data['obs_gastos'],
                                            obs_inicial : data['obs_inicial'],
                                            vr_final : data['vr_final'],
                                            vr_gastos : data['vr_gastos'],
                                            vr_inicial : data['vr_inicial'],
                                            vr_software : data['vr_software'],
                                        });
                                        
                                        this.modalCierreCaja=1;
                                        this.tituloModalCierre='Listado de cierres de caja';
                                        this.tipoAccionCierre=3;
                                    }
                                    else{
                                        result.dismiss === Swal.DismissReason.cancel
                                    }
                                })
                                break;
                            }
                            case 'ver':
                            {
                                this.tipoAccionCierre=4;
                                this.id_caja = data['id_caja'];
                                this.nombre_caja = data['nombre'];
                                this.vr_inicial_cierre = data['vr_inicial'];
                                this.obs_inicial_cierre = data['obs_inicial'];
                                this.vr_gastos_cierre = data['vr_gastos'];
                                this.obs_gastos_cierre = data['obs_gastos'];
                                this.vr_software_cierre = data['vr_software'];
                                this.vr_final_cierre = data['vr_final'];
                                break;
                            }
                        }
                        this.selectCajas();
                        break;
                    }
                }
            },
            ocultarDetalle(){
                let me=this;
                me.listado=1;
                me.facturacion_id=0;
                me.num_factura=0,
                me.id_tercero=0,
                me.tercero_facturacion='',
                me.id_usuario=0,
                me.fec_edita='',
                me.subtotal=0.0,
                me.valor_iva=0.0,
                me.iva = 0,
                me.total=0.0,
                me.abono=0.0,
                me.saldo=0.0,
                me.detalle='',
                me.lugar='',
                me.descuento=0.0,
                me.fec_registra='',
                me.fec_envia='',
                me.fec_anula='',
                // me.fecha = '',
                me.id_tarifario = 0;
                me.estado = 0,
                // me.arrayFacturacion=[];
                // me.arrayFacturacionT=[];
                me.arrayDetalle=[];
                me.arrayTerceros=[];       
            },
            verFacturacion(id){
                let me=this;
                me.listado=2;

                //Obtener los datos de la factura
                var arrayFacturacionT=[];
                var url= this.ruta +'/facturacion/obtenerCabecera?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayFacturacionT = respuesta.facturacion;

                    me.fecha = arrayFacturacionT[0]['fecha'];
                    me.num_factura=arrayFacturacionT[0]['num_factura'];
                    me.tercero = arrayFacturacionT[0]['nom_tercero'];
                    me.detalle = arrayFacturacionT[0]['detalle'];
                    me.lugar = arrayFacturacionT[0]['nom_lugar'];
                    me.estado = arrayFacturacionT[0]['estado'];
                    me.subtotal=arrayFacturacionT[0]['subtotal'];
                    me.valor_iva=arrayFacturacionT[0]['valor_iva'];
                    me.abono=arrayFacturacionT[0]['abono'];
                    me.saldo=arrayFacturacionT[0]['saldo'];
                    me.total=arrayFacturacionT[0]['total'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles 
                me.listarDetalle(id);
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.buscar = '';
                this.arrayArticulo = [];
                this.buscarA = '';
                this.buscarCategoriaA = '';
                this.tipo_vista_articulo = 1;
            }, 
            abrirModal(){               
                this.arrayArticulo=[];
                this.modal = 1;
                this.tituloModal = 'Seleccione uno o varios artículos';
                this.selectCategoria2();
                this.listarArticulo(this.buscarA,this.criterioA,this.buscarCategoriaA)
            },
            cerrarModalCantidadArticulo(){
                this.modalCantidadArticulo=0;
                this.tituloModalCantidadArticulo='';
                this.cantidadArticulo = 0;
                this.idDetalleAsociado = 0;
                this.stockCantidadArticulo = 0;
                this.saldoParcialCantidadArticulo = false;
                this.arrayInfoArticuloModalCantidad = [];
            }, 
            abrirModalCantidadArticulo(data){               
                this.modalCantidadArticulo = 1;
                this.tituloModalCantidadArticulo = 'Cantidad del articulo';
                this.arrayInfoArticuloModalCantidad = data;
                this.stockCantidadArticulo = data['stock']
            },
            desactivarIngreso(id){
               Swal.fire({
                title: 'Esta seguro de anular este ingreso?',
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

                    axios.put(this.ruta +'/ingreso/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarFacturacion(1,'','','','','','','');
                        Swal.fire(
                        'Anulado!',
                        'El ingreso ha sido anulado con éxito.',
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

            // funcion abrir modal proveedores
            abrirModalT(accion){               
                this.arrayTerceros=[];
                this.modal2 = 1;
                switch(accion){
                    case 'terceros':{
                        this.tituloModal2 = 'Seleccione un tercero';
                        this.tipoAccionModalTerceros = 1;
                        break;
                    }
                    case 'tercero_filtro':{
                        this.tituloModal2 = 'Seleccione un tercero para el filtro';
                        this.tipoAccionModalTerceros = 2;
                        break;
                    }
                    case 'vendedor_filtro':{
                        this.tituloModal2 = 'Seleccione un vendedor';
                        this.tipoAccionModalTerceros = 3;
                        break;
                    }
                }
            },
            cerrarModalT(){
                this.modal2=0;
                this.tituloModal2='';
                this.terc_busq = '';
            },
            cargarTercero(tercero){
                if(this.tipoAccionModalTerceros==1)
                {
                    this.tercero = tercero['num_documento'];
                    this.id_tercero = tercero['id'];
                }
                if(this.tipoAccionModalTerceros==2)
                {
                    this.terceroFiltro = tercero['num_documento'];
                    this.idTerceroFiltro = tercero['id'];
                }
                if(this.tipoAccionModalTerceros==3)
                {
                    this.vendedorFiltro = tercero['num_documento'];
                    this.idVendedorFiltro = tercero['id'];
                }

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
                if(opc==4){
                    this.idTerceroFiltro = '';
                    this.terceroFiltro = '';
                }
                if(opc==5){
                    this.idVendedorFiltro = '';
                    this.vendedorFiltro = '';
                }
            },
            pdfFormato(id){
                window.open(this.ruta +'/facturacion/pdfFacturacion/'+ id);
            },
        },
        mounted() {
             $(".mul-select").select2({
                    placeholder: "selecione categoria", //placeholder
                    tags: true,
                    tokenSeparators: ['/',',',';'," "] 
                });
                console.log( $(".mul-select"));
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
            me.fechaActual = d;
            me.hastaFiltro = d;
            me.fecha = d;
            me.fechaHoraActual = d+' '+h+':'+min+':'+sec;

            me.listarCajas();

            // me.listarFacturacion(1,me.numFacturaFiltro,me.estadoFiltro,me.idTerceroFiltro,me.ordenFiltro,me.desdeFiltro,me.hastaFiltro,me.idVendedorFiltro);
        }
    }
</script>
<style> 
    .mul-select  {
         width: 100%;
    }
    .precio-prod{
            position: relative;
            float: right;
            top: em;
            right: 4px;
    }
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
    .mosaico{
        display: inline-block;
        float: left;
    }
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
