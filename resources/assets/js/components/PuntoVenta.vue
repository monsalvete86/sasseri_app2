<template>
    <main class="main">
        <div>
            <div class="card" v-show="position==1">  <!-- listado de productos de factura -->
                <div class="card-header"> 
                    <div class="row mb-1">
                        
                        <div class="col-10">
                            <input class="form-control" type="search" placeholder="Buscar" aria-label="Search" v-model="buscarA" @keyup="listarArticulo(buscarA,criterioA,buscarCategoriaA)">
                        </div>
                        <div class="col-2">
                            <button class="btn btn-success  fa fa-search btn-buscar float-right" type="submit" @click="listarArticulo(buscarA,criterioA,buscarCategoriaA)">
                            </button>
                        </div>
                        
                    </div>
                    <div class="row">                            
                        <div class="col-12">
                            <div class="form-group">
                       
                       
                                <select size="2" class="form-control" multiple  v-model="buscarCategoriaA"  placeholder="- Categorias -" @change="listarArticulo(buscarA,criterioA,buscarCategoriaA)">
                                    <option value="">- Categorias -</option>
                                    <option v-for="categoria in arrayCategoria2" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                   
                                </select>

                            </div> 
                        </div>  
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div v-for="(articulo, index) in arrayArticulo" :key="index" class="col-4 separa-cards">
                                <div class="card text-center mb-1" style="cursor:pointer" @click="agregaDetalleMesero(articulo)">
                                    <div class=" txt-price-prod btn-primary">
                                        <span class="num text-white "> $ {{articulo.precio_venta}} </span>
                                    </div>
                                    <div class="card mx-auto">
                                        <img sv-if="`${articulo.img}`!='default.png'" :src="`${ruta}/Empresas/${articulo.id_empresa}_empresa/ImgProductos/${articulo.img}`" class="img-prods">
                                    </div>
                                    <div class="txt-nom-prod bg-success">
                                        <small class="mb-0 text-white">{{articulo.nombre}}</small>
                                    </div>
                                </div>
                            </div>
                            

                        </div>  
                    </div>
                </div>
            </div>
            <div v-show="position==2">  <!-- VISTA NUEVA FACTURA -->
                
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-info" @click="position=1"><i class="fa fa-arrow-left"></i> Productos 
                                    </button>
                            </div>
                            <div class="col-5 pr-1">
                                <button class="btn btn-danger" style="margin-left: -31px;" @click="ocultarDetalle(); position=7;">Descartar <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            
                        </div>                                
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="input-group mb-3">
                                    <div class="col-1">
                                        <h3><i class="fa fa-user"></i></h3>
                                    </div>
                                    <div class="col-9 nombre-tercero"><small class="text-muted ">{{tercero}}</small></div>
                                    <div class="col-1">
                                        <h3  v-if="!tercero" style="cursor:pointer" class="text-primary" @click="position=3">
                                            <i class="fa fa-plus-circle" href="#59981A"></i>
                                        </h3> 
                                        <h3 v-else style="cursor:pointer" class="text-primary" @click="quitar(3)">
                                            <i class="fa fa-times-circle" href="#59981A"></i>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Mezas</label>
                                        </div>
                                        <select class="custom-select form-control" v-model="lugar" id="inputGroupSelect01">
                                            <option selected>Ubicacion...</option>                                            
                                            <option v-for="zonas in arrayZonas" :key="zonas.id" :value="zonas.id" v-text="zonas.zona"></option>
                                        </select>                                        
                                    </div>
                                </div>                                            
                            </div>
                            <div class="row ">
                                <div class="col-12">
                                    <div class="row border-bottom" v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                        <div class="col-5">
                                            <div class="row">
                                                <div class="col-12" v-if="detalle.padre==null || detalle.padre==''" >
                                                    <small class="text-muted">{{detalle.articulo+' - '+detalle.nom_presentacion}}</small>
                                                </div>
                                                <div class="col-12" v-else >
                                                    <small class="text-muted">{{detalle.articulo+' - '+detalle.nom_presentacion+' (Presentación asociada)'}}</small>
                                                </div>
                                            </div>    
                                            <div class="row">
                                                <div class="col-12">
                                                    <small > 
                                                        $ {{detalle.precio}} | IVA = $ {{detalle.valor_iva}}
                                                    </small>
                                                </div>
                                            </div>    
                                        </div>
                                        <div class="col-2 "><p class="text-right">{{detalle.cantidad}}</p></div>
                                        <div class="col-3 float-right"><p class="text-right"> $ {{Math.round(parseFloat((detalle.precio*detalle.cantidad)))}} </p></div>
                                        <div class="col-1 ">
                                            <h3 class="text-danger"  @click="eliminarDetalle(index)"><i class="fa fa-times-circle"></i></h3>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div> 
                            <div class="row mt-1">
                                <div class="col-6">
                                    <b>Subtotal</b>
                                </div>
                                <div class="col-4 text-righ text-right">
                                    $ {{subtotal=calcularSubtotal}}
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-6">
                                    <b>IVA</b>
                                </div>
                                <div class="col-4 text-righ text-right">
                                    $ {{valor_iva=calcularTotalIva}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>      
                
            </div>
            <div v-show="position==3"> <!-- listado de clientes -->
                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-2">
                                <button @click="position=4" class="btn btn-success fa fa-plus"></button>
                            </div>
                            <div class="col-2">
                                <button @click="position=2" class="btn btn-primary fa fa-undo"></button>
                            </div>
                            <div class="col-6 pr-1">
                               <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search" name="cta_busq" v-model="terc_busq" @keyup="buscarTercero()">
                            </div> 
                        </div>                                
                    </div>

                    <div class="card-body">  
                        
                        <div class="row " :class=" id_selected_row_acitve==tercero.id ? 'border border-primary ' : 'border-bottom resaltar'" @click="showUserOpts(tercero.id); id_selected_row=tercero.id"  v-for="tercero in arrayTerceros" :key="tercero.id"  v-bind:id="'person_row_'+tercero.id" > 
                            <div v-if="tercero.nombre && !tercero.nombre1" class="col-8" >
                                {{ tercero.nombre }} 
                            </div>
                            <div v-else class="col-8" >
                                {{ tercero.nombre1 + ' ' + validarUnder(tercero.nombre2)+' '+tercero.apellido1+' '+validarUnder(tercero.apellido2) }} 
                            </div>
                            <div class="col-2 text-right">
                                <h3 v-if="id_selected_row==tercero.id&&id_selected_row_acitve!=tercero.id" class="text-primary" v-bind:id="'person_opts_'+tercero.id" style="margin: auto; font-size: 19px;" @click="cargarTercero(tercero);id_selected_row_acitve=tercero.id;"><i class="fa fa-check"></i></h3>
                                <h3 v-if="id_selected_row==tercero.id&&id_selected_row_acitve==tercero.id" class="text-danger" v-bind:id="'person_opts_'+tercero.id" style="margin: auto; font-size: 19px;" @click="id_selected_row_acitve='';"><i class="fa fa-times-circle"></i></h3>
                                 
                            </div> 
                            <div class="col-2 text-center">
                                <h3 v-if="id_selected_row==tercero.id" class="text-success ex1" v-bind:id="'person_opts_'+tercero.id" style="margin: auto; font-size: 19px;"><i class="fa fa-pencil"></i></h3>
                            </div>
                        </div>                        
                    </div>                    
                </div>      
            </div>
            <div v-show="position==4"> <!-- agregar clientes -->
            
                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-3">
                                <button  class="btn btn-success fa fa-save"></button>
                            </div>
                            <div class="col-8">
                                <button @click="position=2" class="btn btn-primary fa fa-undo"></button>
                            </div>
                        </div>                                
                    </div>

                    <div class="card-body">                                                       
                        <form>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Tipo de documento</label>
                                <select class="form-control" id="exampleFormControlSelect1">
                                <option>Cedula Ciudadania</option>
                                <option>Cedula Extrangera</option>
                                <option>Tarjeta Identidad</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputDocument">Documento</label>
                                <input type="num" class="form-control" id="exampleInputDocument" aria-describedby="documentHelp" placeholder="document">
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="exampleInputNombre1">Nombre 1</label>
                                    <input type="text" class="form-control" placeholder="First name">
                                </div>
                                <div class="col">
                                    <label for="exampleInputNombre2">Nombre 2</label>
                                    <input type="text" class="form-control" placeholder="First name">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="exampleInputApellido1">Apellido 1</label>
                                    <input type="text" class="form-control" placeholder="Last name">
                                </div>
                                <div class="col">
                                    <label for="exampleInputApellido2">Apellido 2</label>
                                    <input type="text" class="form-control" placeholder="Last name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPhone">Celular</label>
                                <input type="num" class="form-control" id="exampleInputPhone" aria-describedby="phoneHelp" placeholder="57+">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Correo electronico</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="email@example.com">
                            </div>
                        </form> 
                    </div>                    
                </div> 
            </div>
            <div v-show="position==5"> <!-- tickets imprimir factura -->
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-3">
                                <button @click="position=6" class="btn btn-success fa fa-plus"></button>
                            </div>
                            <div class="col-3">   
                            </div>
                            <div class="col-6 pr-1">  
                            </div> 
                        </div>                                  
                    </div>
                    <div class="ticket">
                        <img class="img-logo espacio-1" src="http://localhost/sasseri_app2/public/Empresas/1_empresa/ImgLogos/f4f72620874a541d0113ea86bcf699a8.jpg" alt="img-logo">
                        <p class="centrado espacio-1">SASSERI_APP_2<br>NIT: 81245875-0<br>BR/DIAGONAL LAS AMERICAS 20_CRA 15-25<br>TEL: 2448484154<br>RES DIAN 100000554554 DE DICIEMBRE 20/2020<br>PERSONA JURUDICA DECLARANTE - REGIMEN COMUN<br>FACTURA DE VENTA N°. 155455<br>FECHA 20/12/2020 - 04:44:42 P.M.</p>
                        -----------------------------------------
                        <table class="table table-sm espacio-1">
                            <thead>
                                <tr>
                                    <th scope="col">CANT</th>
                                    <th colspan="2" scope="col">DESCRIPCION</th>
                                    <th scope="col">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="centrado">2</td>
                                    <td colspan="2">LECHE ALQUERIA</td>
                                    <td>$5000</td>
                                </tr>
                                <tr>
                                    <td class="centrado">1</td>
                                    <td colspan="2">CAFE NEGRO</td>
                                    <td>$2500</td>
                                </tr>
                                <tr>
                                    <td class="centrado">1</td>
                                    <td colspan="2">PAN DE QUESO</td>
                                    <td>$2000</td>
                                </tr>    
                                <tr>
                                    <th colspan="2" scope="col">SUBTOTAL:</th>
                                    <th scope="col"></th>
                                    <td>$9500</td>
                                </tr>
                                <tr class="table-borderless">
                                    <th colspan="2" scope="col">IVA:</th>
                                    <th scope="col"></th>
                                    <td>$950</td>
                                </tr>
                                <tr>
                                    <th colspan="2" scope="col">TOTAL:</th>
                                    <th scope="col"></th>
                                    <th>$10450</th>
                                </tr>
                            </tbody>
                        </table>
                        -----------------------------------------
                        <br>
                        <p class="centrado minimizar espacio-1">POWERE BY - FRACTAL AGENCIA DIGITAL<br>www.fractalagenciadigital.com<br>(CEL. 312-524-2544)</p><br>
                    </div> 
                </div>                    
            </div>  
        </div>
        <div>
            <div v-show="position==6"> <!-- tickets listado preparcion chef -->
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-3">
                                <button @click="position=5" class="btn btn-primary fa fa-undo"></button>
                            </div>
                            <div class="col-3">
                                <button @click="position=7" class="btn btn-primary fa fa-list"></button>
                            </div>
                            <div class="col-6 pr-1">  
                            </div> 
                        </div>                                      
                    </div>
                    <div class="ticket">
                        <img class="img-logo espacio-1" src="http://localhost/sasseri_app2/public/Empresas/1_empresa/ImgLogos/f4f72620874a541d0113ea86bcf699a8.jpg" alt="img-logo">
                        <p class="centrado espacio-1">FECHA 20/12/2020 - 04:44:42 P.M.</p>
                        -----------------------------------------
                        <div class="input-group mb-0">
                            <div class="col-6">
                                <p class="espacio-1">MESERO:</p>
                            </div> 
                            <div class="col-6">
                                <p class="espacio-1">ANDRES ALBERTO</p>
                            </div>
                        </div>
                        <div class="input-group mb-0">
                            <div class="col-6">
                                <p class="espacio-1">MESA:</p>
                            </div> 
                            <div class="col-6">
                                <p class="espacio-1 centrado">1/4</p>
                            </div>
                        </div>
                        -----------------------------------------
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">CANT</th>
                                    <th colspan="1"></th>
                                    <th scope="col">DESCRIPCION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="centrado">3</td>
                                    <td colspan="1"></td>
                                    <td>LECHE ALQUERIA</td>
                                </tr>
                                <tr>
                                    <td class="centrado">1</td>
                                    <td colspan="1"></td>
                                    <td>PAN DE QUESO</td>
                                </tr>
                                <tr>
                                    <td class="centrado">3</td>
                                    <td colspan="1"></td>
                                    <td>CAFE NEGRO</td>
                                </tr>
                            </tbody>
                        </table>
                        -----------------------------------------
                        <br>
                        <p class="centrado minimizar espacio-1">POWERE BY - FRACTAL AGENCIA DIGITAL<br>www.fractalagenciadigital.  com<br>(CEL. 312-524-2544)</p><br> 
                    </div>                    
                </div>  
   
            </div>
            <div v-show="position==7"> <!-- listado de faturas -->
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <!--
                            <div class="col-3">
                                <button @click="position=6" class="btn btn-primary fa fa-undo"></button>
                            </div>-->
                            <div class="col-3">
                                <div class="input">
                                    <div class="input-group-prepend">
                                        <h4  style="margin-left: -23px; margin-left: 13px; margin-top: 6px; font-size: 18px;" for="inputGroupSelect01">Estado</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">  
                                <select class="custom-select" id="inputGroupSelect01">
                                    <option selected  style="font-size: 14px;">Seleccionar</option>
                                    <option value="1" style="font-size: 14px;">Abierta</option>
                                    <option value="2" style="font-size: 14px;">Cerrada</option>
                                    <option value="3" style="font-size: 14px;">Cancelada</option>
                                </select>  
                            </div>  
                        </div>                          
                    </div>
                    <div class="card-header" style="font-size: 13px;">
                        <div class="row">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Factura</th>
                                    <th scope="col">Mesa</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="facturacion in arrayFacturacion" :key="facturacion.id" style="text-align: right;">
                                        <th scope="row">1</th>
                                        <td v-text="facturacion.num_factura? facturacion.num_factura: ''"></td>
                                        <td class="centrado" v-text="facturacion.nom_lugar? facturacion.nom_lugar : ''"></td>
                                        <td class="text-right" v-text="facturacion.total? '$ '+facturacion.total : ''"></td>
                                        <td v-if="facturacion.estado==1" class="text-warning">Abierta</td>
                                        <td v-if="facturacion.estado==2" class="text-success">Cerrada</td>
                                        <td v-if="facturacion.estado==0" class="text-danger">Cancelada</td>
                                        <td class="centrado">
                                            <button v-if="facturacion.estado==1"  @click="mostrarDetalle('facturacion','actualizar',facturacion);position=2;" class="btn-1 btn btn-success rounded-circle">
                                                <i class="fa fa-pencil btn-edit-factura"></i>
                                            </button>
                                             <button v-else class="btn-1 btn btn-secondary rounded-circle">
                                                <i class="fa fa-pencil btn-edit-factura"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>            
                        </div>
                    </div>                      
                </div>  
            </div>
            
            <div class="row mt-1 fixed-bottom mx-auto"> <!-- boton de facturar -->
                <div class="col-12" v-if="position==1||position==2">
                    <a @click="registrarFacturacion();" class="btn btn-block btn-lg active btn-success" href="#" role="button"><h3 class="text-white">Facturar $ {{valor_final=calcularTotal}}</h3></a>
                </div>
                <div class="col-12" v-if="position==7">

                    <a v-if="no_caja==0" @click="position=1;mostrarDetalle()" class="btn btn-block btn-lg active btn-success"  href="#" role="button"><h3 class="text-white">Iniciar Factura</h3></a>
                    <a v-else  class="btn btn-block btn-lg active btn-secondary"  href="#" role="button"><h3 class="text-white">No tienes una caja abierta</h3></a>
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
                position: 7,
                no_caja: 1,
                id_selected_row_acitve: '',
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
                buscarCategoriaA : [],
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
                id_selected_row: '',
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
               return this.ivaProces();
            },
            calcularSaldo: function(){
                var resultado=0.0;

                resultado=resultado+(this.calcularTotal-this.abono);
                
                return resultado;
            },
        },
        methods : {
            showUserOpts(id_resaltar){
                console.log(id_resaltar);
            },
            ivaProces(){
                 
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){                    
                    resultado += this.arrayDetalle[i].valor_iva;                    
                }
                // resultado = this.total-resultado;
                resultado = Math.round(resultado);
                this.valor_iva = resultado;
                return resultado;
            },
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
            listarCajas(){
                let me=this;
                var url= this.ruta +'/cierres_caja/validarCierreCaja';
                axios.get(url).then(function (response) {
                    //console.log(response.data);
                    var respuesta= response.data;
                    var ban = respuesta.ban;
                    me.arrayCierresXCajas = respuesta.cierres_cajas;

                    if(ban==0 || ban==1)
                    {
                        me.no_caja = 1;
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
                            me.no_caja = 0;
                            me.id_caja_facturacion = me.arrayCierresXCajas[0]['id'];
                            me.id_cierre_caja_facturacion = me.arrayCierresXCajas[0]['id'];
                            me.nom_caja_cierre_facturacion = me.arrayCierresXCajas[0]['nombre'];
                            me.cierre_caja_id = me.arrayCierresXCajas[0]['id'];
                            me.id_caja_cierre = me.arrayCierresXCajas[0]['id_caja'];
                            me.nom_caja_cierre = me.arrayCierresXCajas[0]['nombre'];
                            me.vr_inicial_cierre = me.arrayCierresXCajas[0]['vr_inicial'];
                            me.obs_inicial_cierre = me.arrayCierresXCajas[0]['obs_inicial'];
                            //console.log("entra al ban 3");
                            me.listarFacturacion(1,me.numFacturaFiltro,me.estadoFiltro,me.idTerceroFiltro,me.ordenFiltro,me.desdeFiltro,me.hastaFiltro,me.idVendedorFiltro);
                        }

                        if(ban==2)
                        {
                            me.no_caja = 1;
                            //console.log("entra al ban 2");
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
            agregaDetalleMesero(producto){
                //console.log(producto);
                let me=this;
                 var p = '';
                if(producto.padre='') {p = ' '+producto.nom_presentacion+' (Presentacion asociada)';}
                else {p = ' - '+producto.nom_presentacion;}
                var ivaVenta = 0;
                producto.productos_iva.forEach(function(iva){
                    if(iva.tipo_iva =='Venta'){ivaVenta=iva.porcentaje;}
                });
                if(ivaVenta>0) {

                    var ivaVenta_vr = Math.round(parseFloat(producto.precio_venta)-parseFloat((producto.precio_venta)/((ivaVenta/100)+1)));}
                
                console.log("ivaVenta_vr"+ivaVenta_vr);
                let auxPosition = me.arrayDetalle.indexOf(me.arrayDetalle.find(({codigo}) => codigo === producto.codigo));
                
                if(auxPosition >= 0) {
                    me.arrayDetalle[auxPosition].cantidad+=1;
                    me.arrayDetalle[auxPosition].valor_iva+=ivaVenta_vr;
                    me.arrayDetalle[auxPosition].valor_subtotal +=  me.arrayDetalle[auxPosition].precio_venta - ivaVenta_vr;
                }
                 
                else {
                    me.arrayDetalle.push({
                        codigo: producto.codigo,
                        idarticulo: producto.id_articulo,
                        id_asociado: producto.id_asociado,
                        articulo: producto.nombre,
                        cantidad: 1,
                        tipo: producto.tipo_articulo,
                        valor_descuento: 0,
                        precio: producto.precio_venta,
                        precio_venta: producto.precio_venta,
                        iva: ivaVenta,
                        valor_iva: ivaVenta_vr,
                        valor_subtotal: Math.round(parseFloat(producto.precio_venta-ivaVenta_vr)),
                        stock : producto.stock,
                        descuento : 0,
                        nom_presentacion : producto.nom_presentacion,
                        id_presentacion : producto.id_presentacion,
                        padre : producto.padre
                    });
                }
               
                Swal.fire({
                    type: 'success',
                    title: 'Producto agregado',
                    text: 'Progducto cargado',
                });

                 this.ivaProces();
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
                console.log(this.validarFacturacion());
                if (this.validarFacturacion()){

                    return;
                }
                else {
                
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
                        var toFind = "2";
                        var filtered = me.arrayDetalle.filter(function(el) {
                        return el.tipo === toFind;
                        });
                        me.arrayDetalle = [];
                        me.id_tercero = '';
                        me.tercero = '';
                        me.lugar = '';
                        me.ocultarDetalle();
                        me.listarFacturacion(1,'','','','','','','');
                        if(filtered)
                            me.position = 6;
                        else 
                            me.position = 7;
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
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
                if(this.position!=2) {
                    this.position = 2;
                }
               else {
                
                    this.errorMostrarMsjFacturacion =[];

                    // if (this.fecha==0) this.errorMostrarMsjFacturacion.push("Ingrese la fecha");
                    // if (this.num_factura==0) this.errorMostrarMsjFacturacion.push("Seleccione el comprobante");
                    if (!this.id_tercero) {
                     alert("Seleccione un tercero");
                     return true;
                    }
                    if (!this.lugar) { 
                        alert("Seleccione una mesa");
                        return true;
                    }
                    if (this.arrayDetalle.length<=0) {
                        alert("Debe agregar productos");
                        return true;
                    }
                    /*
                    if (this.errorMostrarMsjFacturacion.length) this.errorFacturacion = 1;

                    return this.errorFacturacion;*/
                }
               
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
                //me.id_tarifario = 0;
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
               /* if(this.tipoAccionModalTerceros==1)
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
                }*/
                console.log("llegando");
                this.tercero = tercero['nombre1']+" "+tercero['nombre2']+" "+tercero['apellido1']+" "+tercero['apellido2'];
                 this.id_tercero = tercero['id'];
                this.position=2;
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
                placeholder: "- Categorias -", //placeholder
                tags: true,
                allowClear: true,
                tokenSeparators: ['/',',',';'," "] 
            });
            //console.log( $(".mul-select"));
             
            let me= this;
            var d = new Date();
            $(".mul-select").on("change", function (e) { 
                me.listarArticulo(me.buscarA,me.criterioA,me.buscarCategoriaA) 
            });
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
            me.desdeFiltro = d;
            me.fecha = d;
            me.fechaHoraActual = d+' '+h+':'+min+':'+sec;
            this.ocultarDetalle();
            this.selectCategoria2();
            me.listarCajas();
            me.buscarTercero();
            me.selectZonas();
            this.listarArticulo(this.buscarA,this.criterioA,this.buscarCategoriaA);
             me.listarFacturacion(1,me.numFacturaFiltro,me.estadoFiltro,me.idTerceroFiltro,me.ordenFiltro,me.desdeFiltro,me.hastaFiltro,me.idVendedorFiltro);
        }
    }
</script>
<style> 
    /* {
            font-size: 12px;
            font-family: 'Times New Roman';
    }*/
    .ex1 {
        border: 1px solid rgb(49, 173, 45);
        outline-style: solid;
        outline-color: rgba(45, 189, 76, 0.87);
        outline-width: thin;
}
    .btn-edit-factura {
        font-size: 15px !important;
    }
    .minimizar {
        font-size: 9px;
    }
    .espacio-1 {
        margin-top: 0 !important; 
        margin-bottom: 0rem !important;
    }
    .centrado {
        text-align: center;
        align-content: center;
    }
    .ticket {
        width: 288px;
        max-width: 320px;
        margin: auto;
        line-height: 1;
    }
     .img-logo {
        max-width: 87px;
        margin-left: 100px;
    }
    .select2-search__field {
            width: 100% !important;
    }
    .select2-container {
            width: 100% !important
    }
    .nombre-tercero {
        font-size: 16px !important;
    }
    .txt-nom-prod {
        line-height: 1 !important;
        min-height: 35px;
        border-radius: 3px;
    }
    .separa-cards {
        padding-right: 0.15rem !important;
        padding-left: 0.15rem !important;       
    }
    .img-prods {
        width: 89px;
        height: 89px
    }
    .txt-price-prod {
        font-size: 12px;
        border-radius: 3px !important;
    }

    h3.ocultar{
        display: none !important;
    }
    
    div.resaltar:hover, div.active:hover, div h3.resaltar:hover, div>h3.active:hover  {
        background-color: #d1d3e2!important;
       
    }
    .mul-select  {
         width: 100%;
    }
    .precio-prod{
        position: absolute;
        float: right;
        top: 74px;
        right: 33px;
        font-size: 95%;
        z-index: 2;
        min-width: 85px;
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
