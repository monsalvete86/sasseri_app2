<template>
            <main class="main">
            <!-- Breadcrumb -->
            
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Terceros
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
                                      <option value="telefono1">Teléfono</option>
                                    </select>
                                    <select v-else disabled class="form-control col-md-3" v-model="criterio">
                                    </select>

                                    <input v-if="permisosUser.leer" type="text" v-model="buscar" @keyup="listarPersona(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <input v-else disabled type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar">

                                    <!--<button v-if="permisosUser.leer" type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    <button v-else type="button" class="btn btn-secondary"><i class="fa fa-search"></i> Buscar</button>-->
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm table-responsive table-earning">
                            <thead>
                                <tr>  
                                    <th>IMG</th>                                  
                                    <th>Nombre</th>
                                    <th>Tipo Documento</th>
                                    <th>Número</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="persona in arrayPersona" :key="persona.id">
                                    <td>
                                        <img v-if="`${persona.img}`!='default.png'" :src="`${ruta}/Empresas/${persona.id_empresa}_empresa/ImgPerfil/${persona.img}`" height="40" width="40">

                                        <img v-else :src="`${ruta}/Empresas/${persona.img}`" height="40" width="40">
                                    </td>
                                    <td v-if="persona.nombre&& !persona.nombre1">{{persona.nombre}}</td>
                                    <td v-else> 
                                        {{persona.nombre1+" "+persona.nombre2+" "+persona.apellido1+" "+persona.apellido2 }}
                                    </td>
                                    <td v-text="persona.tipo_documento"></td>
                                    <td v-text="persona.num_documento"></td>
                                    <td v-text="persona.direccion"></td>
                                    <td v-text="persona.telefono1"></td>
                                    <td v-text="persona.email"></td>
                                    <td>
                                        <button v-if="permisosUser.actualizar" type="button" @click="abrirModal('persona','actualizar',persona)" class="btn btn-success btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button>
                                        <button v-else type="button" class="btn btn-secondary btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button>

                                        <button v-if="permisosUser.leer" type="button" @click="abrirModal('persona','novedades',persona)" class="btn btn-info btn-sm">
                                          <i class="fa fa-align-justify"></i>
                                        </button>
                                    </td>
                                </tr>                                
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
                <div class="modal-dialog modal-primary modal-dialog-scrollable modal-lg" role="document">
                    <div class="modal-content" >
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="text-input">Tipo Persona (*)</label>                                                                             
                                        <select v-model="tipo_persona" class="form-control" v-bind:class="{ 'is-invalid': hasError.tipo_persona==1 }">
                                            <option value="Natural">Natural</option>
                                            <option value="Juridica">Jurídica</option>
                                        </select>                                        
                                    </div>
                                    <div class="form-group form-check col-md-4">
                                        <label class="form-check-label">Dig. Verificación</label>
                                        <input type="checkbox" v-model="digito_verif" class="form-check-inputx" v-bind:class="{ 'is-invalid': hasError.digito_verif==1 }">
                                       
                                         <label v-if="digito_verif==1" for="digito_verif">-</label>                                    
                                        <div v-if="digito_verif==1" >
                                            <input type="number" id="digito_verif" class="form-control" v-model="num_verif" max="1" v-bind:class="{ 'is-invalid': hasError.num_verif==1 }">
                                        </div>
                                    </div>
                                    <div class="form-group custom-file col-md-4">
                                        <label class="custom-file-label" for="img">Foto</label>
                                        <input type="file" id="img" name="img" ref="inputFileImg"  @change="cargarImg" class="custom-file-input" v-bind:class="{ 'is-invalid': hasError.img==1 }">
                                    </div>
                                </div>
                                <div class="form-group col-lg-4" v-if="tipo_persona !='Natural'">
                                    <label for="text-input">Razon Social (*)</label>                                    
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de la entidad" v-bind:class="{ 'is-invalid': hasError.nombre==1 }">                                    
                                </div>
                                <div class="form-row" v-if="tipo_persona =='Natural'">
                                    <div  class="form-group col-lg-4">
                                        <label for="text-input">1° Nombre (*)</label>                                        
                                        <input type="text" v-model="nombre1" class="form-control" placeholder="1° Nombre" v-bind:class="{ 'is-invalid': hasError.nombre1==1 }">
                                    </div>
                                    <div  class="form-group col-lg-4">
                                        <label for="text-input">2° Nombre</label>                                        
                                        <input type="text" v-model="nombre2" class="form-control" placeholder="2° Nombre" v-bind:class="{ 'is-invalid': hasError.nombre2==1 }">                                        
                                    </div>
                                    
                                <!-- </div>
                                
                                <div class="form-row" v-if="tipo_persona =='Natural'"> -->
                                     <div  class="form-group col-lg-4">
                                        <label for="text-input">1° Apellido (*)</label>                                      
                                        <input type="text" v-model="apellido1" class="form-control" placeholder="1° Apellido" v-bind:class="{ 'is-invalid': hasError.apellido1==1 }">
                                        
                                     </div>
                                    <div  class="form-group col-lg-4">
                                        <label for="text-input">2° Apellido</label>                                      
                                        <input type="text" v-model="apellido2" class="form-control" placeholder="2° Apellido" v-bind:class="{ 'is-invalid': hasError.apellido2==1 }">
                                        
                                    </div>
                                    <div  class="form-group col-lg-4">
                                        <label for="text-input">Departamento</label>                                        
                                        <select v-model="departamento" @change="listarMunicipios(departamento)" class="form-control" v-bind:class="{ 'is-invalid': hasError.departamento==1 }">
                                            <option v-for="departamento in arrayDepartamentos" :key="departamento.id" :value="departamento.id" v-text="departamento.nombre"></option>
                                        </select>
                                    </div>
                                    <div  class="form-group col-lg-4">
                                        <label for="text-input">Municipio</label>                                      
                                        <select v-model="municipio" class="form-control" v-bind:class="{ 'is-invalid': hasError.municipio==1 }">
                                            <option v-for="municipio in arrayMunicipios" :key="municipio.id" :value="municipio.id" v-text="municipio.nombre"></option>
                                        </select>                                        
                                        
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div  class="form-group col-lg-4">
                                        <label for="text-input">Tipo Documento</label>                                      
                                        <select v-model="tipo_documento" class="form-control" v-bind:class="{ 'is-invalid': hasError.tipo_documento==1 }">
                                            <option value="CC">Cedula de Ciudadania</option>
                                            <option value="NIT">NIT</option>
                                            <option value="CE">Cedula de Extranjeria</option>
                                            <option value="NA">Otro</option>
                                        </select>
                                    </div>
                                    <div  class="form-group col-lg-4">
                                        <label for="text-input">Documento</label>                                        
                                        <input type="text" v-model="num_documento" class="form-control" placeholder="Número de documento" v-bind:class="{ 'is-invalid': hasError.num_documento==1 }">
                                    </div>   
                                    <div class="form-group col-lg-4">
                                        <label for="text-input">Regimen</label>                                        
                                        <select v-model="regimen" class="form-control" v-bind:class="{ 'is-invalid': hasError.regimen==1 }">
                                            <option value="Comun">Común</option>
                                            <option value="Simplificado">Simplificado</option>
                                            <option value="CE">Gran Contribuyente</option>
                                        </select>     
                                    </div>                                
                                </div>
                               
                                <div class="form-row">
                                    <div  class="form-group col-lg-4">
                                        <label for="text-input">Dirección</label>
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Dirección" v-bind:class="{ 'is-invalid': hasError.direccion==1 }">
                                     </div>
                                     <div  class="form-group col-lg-4">
                                        <label for="email-input">Email</label>                                       
                                        <input type="email" v-model="email" class="form-control" placeholder="Email" v-bind:class="{ 'is-invalid': hasError.email==1 }">
                                    </div>
                                    <div  class="form-group col-lg-4">
                                        <label for="number-input">Teléfono 1</label>                                    
                                        <input type="number" id="telefono1" v-model="telefono1" onkeydown="javascript: return event.keyCode == 69 ? false : true" class="form-control" placeholder="Teléfono 1" v-bind:class="{ 'is-invalid': hasError.telefono1==1 }">
                                    </div>                                     
                                </div>
                                <div class="form-row">
                                    <div  class="form-group col-lg-4">
                                        <label for="text-input">Genero</label>                                   
                                        <select v-model="sexo" class="form-control" v-bind:class="{ 'is-invalid': hasError.sexo==1 }">
                                            <option value="Femenino">Femenino</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Otro">Otro</option>
                                        </select>                                    
                                    </div>
                                    <div  class="form-group col-lg-4">
                                        <label for="date-input">Fec. Nacimiento</label>
                                        <input type="date" v-model="fec_nac" class="form-control" placeholder="Fecha Nacimento" v-bind:class="{ 'is-invalid': hasError.fec_nac==1 }">
                                    </div>
                                    
                                

                                <!--<div class="form-group row">
                                    <label class="col-md-1 form-control-label" for="number-input">Teléfono 2</label>
                                    <div class="col-md-2">
                                        <input type="number" id="telefono2" v-model="telefono2" onkeydown="javascript: return event.keyCode == 69 ? false : true" class="form-control" placeholder="Teléfono 2">
                                    </div>
                                    <label class="col-md-1 form-control-label" for="number-input">Celular</label>
                                    <div class="col-md-2">
                                        <input type="number" id="celular" v-model="celular" onkeydown="javascript: return event.keyCode == 69 ? false : true" class="form-control" placeholder="Celular">
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                </div>-->

                                
                                    <div class="form-group col-lg-4">
                                        <label for="text-input">Ubicación</label>
                                        <input type="text" v-model="reside" class="form-control" placeholder="Ubicacion" v-bind:class="{ 'is-invalid': hasError.reside==1 }">
                                    </div>
                                    <div  class="form-group col-lg-4" v-if="tipo_persona !='Natural'">
                                        <label for="text-input">Rep. Legal</label>                                        
                                        <input type="text" v-model="representante" class="form-control" placeholder="Representante" v-bind:class="{ 'is-invalid': hasError.representante==1 }">
                                    </div>
                                    <div v-if="tipo_persona =='Natural'" class="form-group col-lg-4">
                                        <label for="text-input">Empresa</label>                                      
                                        <input type="text" v-model="entidad" class="form-control" placeholder="Empresa" v-bind:class="{ 'is-invalid': hasError.entidad==1 }">                                      
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-4">
                                        <label for="text-input">Autoretenedor</label>
                                        <select class="form-control" v-model="autoretenedor" v-bind:class="{ 'is-invalid': hasError.autoretenedor==1 }">
                                            <option value="">Seleccione</option>
                                            <option value="1">Autoretenedor</option>
                                            <option value="2">No autoretenedor</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="text-input">Declarante</label>                                        
                                        <select class="form-control" v-model="declarante" v-bind:class="{ 'is-invalid': hasError.declarante==1 }">
                                            <option value="">Seleccione</option>
                                            <option value="1">Declarante</option>
                                            <option value="2">No declarante</option>
                                        </select>
                                    </div>
                                    <fieldset class="form-group col-md-4">
                                        <br>
                                        <div class="form-check">              
                                            <input type="checkbox" class="form-check-input" id="cliente1" :value="1" v-model="cliente">
                                            <label class="form-check-label" for="cliente1">Cliente</label>    
                                        </div>
                                        <div class="form-check">                  
                                            <input type="checkbox" class="form-check-input" id="proveedor1" v-model="proveedor">
                                            <label class="form-check-label" for="proveedor1">Proveedor</label>
                                        </div>
                                    </fieldset>
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
                            <button v-if="cliente" type="button" class="btn btn-info" @click="abrirModal('persona','cliente')">Cliente</button>
                            <button v-else type="button" class="btn btn-secondary">Cliente</button>

                            <button v-if="proveedor" type="button" class="btn btn-info" @click="abrirModal('persona','proveedor')">Proveedor</button>
                            <button v-else type="button" class="btn btn-secondary">Proveedor</button>

                            <button type="button" class="btn btn-primary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-success" @click="actualizarPersona()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal2}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-primary modal-sm" role="document">
                    <div class="modal-content" >
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="modal2=0; tipoAccion2=0" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">                                
                                <div class="form-row" v-if="tipoAccion2==1">
                                    <div class="form-group col-md-12">
                                        <label>Vendedor</label>                                       
                                        <select class="form-control" v-model="id_vendedor" v-bind:class="{ 'is-invalid': hasError.id_vendedor==1 }">
                                            <option>Seleccione</option>
                                            <option v-for="vendedor in arrayVendedores" :key="vendedor.id" :value="vendedor.id" v-text="vendedor.colaborador"></option>
                                        </select>
                                        
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Zona</label>                                       
                                        <select class="form-control" v-model="id_zona" v-bind:class="{ 'is-invalid': hasError.id_zona==1 }">
                                            <option>Seleccione</option>
                                            <option v-for="zona in arrayZonas" :key="zona.id" :value="zona.id" v-text="zona.zona"></option>
                                        </select>
                                       
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Plazo pago</label>
                                        <input type="number" class="form-control" v-model="plazo_pago" v-bind:class="{ 'is-invalid': hasError.plazo_pago==1 }">                                        
                                    </div>
                                    <fieldset class="form-group col-md-12" v-if="tipoAccion2==1">
                                        <div class="form-check">                                        
                                            <input type="checkbox" class="form-check-input" v-model="retenedor_fuente" v-bind:class="{ 'is-invalid': hasError.retenedor_fuente==1 }">
                                            <label class="form-check-label">Retenedor fuente</label>
                                        </div>
                                        <div class="form-check">                                                                           
                                            <input type="checkbox" class="form-check-input" v-model="retenedor_iva" v-bind:class="{ 'is-invalid': hasError.retenedor_iva==1 }">
                                            <label class="form-check-label">Retenedor iva</label>    
                                        </div>
                                        <div class="form-check">                                                                          
                                            <input type="checkbox" class="form-check-input" v-model="excluido_iva" v-bind:class="{ 'is-invalid': hasError.excluido_iva==1 }">      
                                            <label class="form-check-label">Excluido iva</label>                                     
                                        </div>
                                        <div class="form-check">
                                                                                
                                            <input type="checkbox" class="form-check-input" v-model="cupo_credito" @click="function(){if(!cupo_credito) vr_cupo_credito=0;}">   
                                            <label class="form-check-label">Cupo credito</label>                                    
                                        </div>
                                        <div class="form-group" v-if="cupo_credito">
                                            <label class="">Vr cupo</label>                                      
                                            <input type="number" class="form-control" v-model="vr_cupo_credito" v-bind:class="{ 'is-invalid': hasError.vr_cupo_credito==1 }">                                        
                                        </div>
                                    </fieldset>
                                </div>                                

                                <div class="form-row" v-if="tipoAccion2==2">                                    
                                    <div class="form-group col-md-12">
                                        <label>Bancos</label>                                      
                                        <select class="form-control" v-model="id_banco" v-bind:class="{ 'is-invalid': hasError.id_banco==1 }">
                                          <option v-for="banco in arrayBancos" :key="banco.id" :value="banco.id" v-text="banco.nombre"></option>
                                        </select>                                        
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>N° cuenta</label>                                      
                                        <input type="text" class="form-control" v-model="num_cuenta_banco" v-bind:class="{ 'is-invalid': hasError.num_cuenta_banco==1 }">                                        
                                    </div>
                                </div>
                                <div class="form-group row" v-if="tipoAccion2==2">
                                    <div class="form-group col-md-12">
                                        <label>Tipo cuenta</label>                                      
                                        <select class="form-control" v-model="tipo_cuenta" v-bind:class="{ 'is-invalid': hasError.tipo_cuenta==1 }">
                                            <option value="Corriente">Corriente</option>
                                            <option value="Ahorros">Ahorros</option>
                                        </select>                                        
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Representante cuenta</label>                                      
                                        <input type="text" class="form-control" v-model="representante_cuenta" v-bind:class="{ 'is-invalid': hasError.representante_cuenta==1 }">                                        
                                    </div>                                
                                    <fieldset class="form-group col-md-12">
                                        <div class="form-check">              
                                            <input type="radio" class="form-check-input" id="nacional" value="Nacional" v-model="tipo_nacionalidad" v-bind:class="{ 'is-invalid': hasError.tipo_nacionalidad==1 }">  
                                            <label for="nacional">Nacional</label>    
                                        </div>
                                        <div class="form-check">                  
                                            <input type="radio" class="form-check-input" id="extranjero" value="Extranjero" v-model="tipo_nacionalidad" v-bind:class="{ 'is-invalid': hasError.tipo_nacionalidad==1 }">
                                            <label for="extranjero">Extranjero</label>
                                        </div>
                                    </fieldset>                                    
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
                            <button type="button" class="btn btn-secondary" @click="modal2=0; tipoAccion2=0">Cerrar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

            <!-- Modal de novedades -->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal3}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-primary modal-lg" role="document" style="max-width: 800px !important">
                    <div class="modal-content" >
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal3"></h4>
                            <button v-if="permisosUser.crear && tipoAccion3==0" type="button" @click="tipoAccion3=1" class="btn btn-default float-left">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>

                            <button type="button" class="close" @click="cerrarModal3()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" v-if="tipoAccion3==1">
                                <div class="form-row">
                                    <div class="form-group col-md-3">                                    
                                        <label>Nombre</label>                                   
                                        <input type="text" class="form-control float-right" v-model="novedad">                                   
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Observacion</label>
                                        <textarea class="form-control" style="height:36px" v-model="observacionNovedad"></textarea>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Link</label>
                                        <input type="text" class="form-control" v-model="link">
                                    </div>
                                </div>
                                <div class="form-group row bordered">
                                    <div class="form-group col-md-6">
                                        <button v-if="tipoAccion3==1" type="button" class="btn btn-secondary float-right" @click="tipoAccion3=0">Cerrar</button>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <button v-if="tipoAccion3==1" type="button" class="btn btn-primary float-left" @click="registrarNovedad()">Guardar</button>
                                    </div>
                                </div>
                            </form>
                            <!--<ul>
                                <li v-for="novedades in arrayNovedades" :key="novedades.id" v-text="novedades.nombre"></li>
                            </ul>-->
                            <table class="table table-bordered table-striped table-sm  table-respnonsive table-earning">
                                <thead>
                                    <th>Nombre</th>
                                    <th>Observacion</th>
                                    <th>Link</th>
                                    <th>Opciones</th>
                                </thead>
                                <tbody v-if="arrayNovedades.length">
                                    <tr v-for="novedades in arrayNovedades" :key="novedades.id">
                                        <td v-text="novedades.nombre"></td>
                                        <td><p v-text="novedades.observacion" style="max-height: 6em !important;overflow-y: auto;"></p></td>
                                        <td><a :href="novedades.link" target="_blank" class="icon-link"></a></td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" @click="eliminarNovedad(novedades.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr><td colspan="4">No hay novedades regitradas</td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal3()">Cerrar</button>
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
                permisosUser : {
                    'leer' : 1,
                    'escribir' : 1,
                    'crear' : 1,
                    'actualizar' : 1,
                    'anular' : 1,
                },
                persona_id: 0,
                nombre : '',
                tipo_documento : 'DNI',
                num_documento : '',
                direccion : '',
                telefono1 : '',
                telefono2 : '',
                celular : '',
                email : '',
                email2 : '',
                sexo: '',
                regimen: '',
                fec_nac: '',
                reside: '',
                tipo_persona: 'Natural',
                representante: '',
                nombre1: '',
                nombre2: '',
                apellido1: '',
                apellido2: '',
                autoretenedor: '',
                declarante : '',
                cliente : false,
                proveedor : false,
                id_vendedor : '',
                id_zona : '',
                plazo_pago : '',
                bloquear : '',
                cupo_credito : '',
                vr_cupo_credito : 0,
                retenedor_fuente : '',
                retenedor_iva : '',
                excluido_iva : '',
                autoretefuente : '',
                autoreteiva : '',
                autoreteica : '',
                id_banco : 0,
                num_cuenta_banco : '',
                tipo_cuenta : '',
                representante_cuenta : '',
                tipo_nacionalidad : '',
                img: '',
                arrayImg: '',

                arrayPersona : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                entidad: '',
                digito_verif: '',
                num_verif: '',
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

                modal2 : 0,
                tipoAccion2 : 0,

                arrayVendedores : [],
                arrayZonas : [],
                arrayBancos : [],

                modal3 : 0,
                tipoAccion3 : 0,
                tituloModal3 : '',
                novedad : '',
                observacionNovedad : '',
                link : '',
                arrayNovedades : [],

                departamento : '',
                municipio : '',
                arrayDepartamentos : [],
                arrayMunicipios : [],

                hasError : {
                    tipo_persona : 0,
                    digito_verif : 0,
                    img : 0,
                    nombre : 0,
                    nombre1 : 0,
                    nombre2 : 0,
                    departamento : 0,
                    apellido1 : 0,
                    apellido2 : 0,
                    municipio : 0,
                    tipo_documento : 0,
                    num_documento : 0,
                    num_verif : 0,
                    direccion : 0,
                    email : 0,
                    regimen : 0,
                    sexo : 0,
                    fec_nac : 0,
                    telefono1 : 0,
                    reside : 0,
                    representante : 0,
                    entidad : 0,
                    autoretenedor : 0,
                    declarante : 0,
                    cliente : 0,
                    proveedor : 0,
                    id_vendedor : 0,
                    id_zona : 0,
                    plazo_pago : 0,
                    retiendor_fuente : 0,
                    retenedor_iva : 0,
                    excluido_iva : 0,
                    cupo_credito : 0,
                    vr_cupo_credito : 0,
                    id_banco : 0,
                    num_cuenta_banco : 0,
                    tipo_cuenta : 0,
                    representante_cuenta : 0,
                    tipo_nacionalidad : 0,
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
                var url=  this.ruta +'/cliente?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPersona = respuesta.personas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarVendedores(page,buscar,criterio){
                let me=this;
                var url=  this.ruta +'/colaboradores/selectColaboradorVendedor';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayVendedores = respuesta.colaboradores;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarZonas(page,buscar,criterio){
                let me=this;
                var url=  this.ruta +'/zona/selectZona';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayZonas = respuesta.zona;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarNovedades(id){
                let me=this;
                var url=  this.ruta +'/novedades/listarNovedades?id='+id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayNovedades = respuesta.novedades;
                    // me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarBancos(){
                let me=this;
                var url=  this.ruta +'/bancos/selectBancos';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayBancos = respuesta.bancos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarDepartamentos(){
                let me=this;
                var url=  this.ruta +'/departamentos';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayDepartamentos = respuesta.departamentos;
                    // me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarMunicipios(id){
                let me=this;
                var url=  this.ruta +'/municipios/listarMunicipios?id='+id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayMunicipios = respuesta.municipios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cargarImg(event){
                let me=this;
                me.arrayImg = event.target.files[0];
                console.log(me.arrayImg);
            },
            validar_e()
            {
                let me = this; 
                var aux;
                aux= $("#telefono1").val();
                
               // me.telefono1 = '123';
                //console.log(aux);
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
                var data = new FormData();
                data.append('nombre', this.nombre);
                data.append('tipo_documento', this.tipo_documento);
                data.append('num_documento' , this.num_documento);
                data.append('direccion' , this.direccion);
                data.append('telefono1' , this.telefono1);
                data.append('telefono2' , this.telefono2);
                data.append('celular' , this.celular);
                data.append('email' , this.email);
                data.append('sexo', this.sexo);
                data.append('regimen', this.regimen);
                data.append('fec_nac', this.fec_nac);
                data.append('reside', this.reside);
                data.append('representante', this.representante);
                data.append('tipo_persona' , this.tipo_persona);
                data.append('nombre1' , this.nombre1);
                data.append('nombre2' , this.nombre2);
                data.append('apellido1' , this.apellido1);
                data.append('apellido2' , this.apellido2);
                data.append('digito_verif' , JSON.stringify(this.digito_verif));
                data.append('entidad' , this.entidad);
                data.append('num_verif' , this.num_verif);
                data.append('autoretenedor' , this.autoretenedor);
                data.append('declarante' , this.declarante);
                data.append('cliente' , JSON.stringify(this.cliente));
                data.append('proveedor' , JSON.stringify(this.proveedor));
                data.append('id_vendedor' , this.id_vendedor);
                data.append('id_zona' , this.id_zona);
                data.append('plazo_pago' , this.plazo_pago);
                data.append('bloquear' , this.bloquear);
                data.append('cupo_credito' , this.cupo_credito);
                data.append('vr_cupo_credito' , this.vr_cupo_credito);
                data.append('retenedor_fuente' , this.retenedor_fuente);
                data.append('retenedor_iva' , this.retenedor_iva);
                data.append('excluido_iva' , this.excluido_iva);
                data.append('autoretefuente' , this.autoretefuente);
                data.append('autoreteiva' , this.autoreteiva);
                data.append('autoreteica' , this.autoreteica);
                data.append('id_banco' , this.id_banco);
                data.append('num_cuenta_banco' , this.num_cuenta_banco);
                data.append('tipo_cuenta' , this.tipo_cuenta);
                data.append('representante_cuenta' , this.representante_cuenta);
                data.append('tipo_nacionalidad' , this.tipo_nacionalidad);
                data.append('departamento' , this.departamento);
                data.append('municipio' , this.municipio);
                data.append('img', this.arrayImg);

                axios.post( this.ruta +'/cliente/registrar',data,{
                    headers:{'Content-Type':'multipart/form-data'}
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
                var data = new FormData();
                data.append('nombre' , this.nombre);
                data.append('tipo_documento' , this.tipo_documento);
                data.append('num_documento' , this.num_documento);
                data.append('direccion' , this.direccion);
                data.append('telefono1' , this.telefono1);
                data.append('telefono2' , this.telefono2);
                data.append('celular' , this.celular);
                data.append('email' , this.email);
                data.append('email2' , this.email2);
                data.append('sexo' , this.sexo);
                data.append('regimen' , this.regimen);
                data.append('fec_nac' , this.fec_nac);
                data.append('reside' , this.reside);
                data.append('representante' , this.representante);
                data.append('tipo_persona' , this.tipo_persona);
                data.append('nombre1' , this.nombre1);
                data.append('nombre2' , this.nombre2);
                data.append('apellido1' , this.apellido1);
                data.append('apellido2' , this.apellido2);
                data.append('digito_verif' , JSON.stringify(this.digito_verif));
                data.append('entidad' , this.entidad);
                data.append('num_verif' , this.num_verif);
                data.append('autoretenedor' , this.autoretenedor);
                data.append('declarante' , this.declarante);
                data.append('cliente' , JSON.stringify(this.cliente));
                data.append('proveedor' , JSON.stringify(this.proveedor));
                data.append('id_vendedor' , this.id_vendedor);
                data.append('id_zona' , this.id_zona);
                data.append('plazo_pago' , this.plazo_pago);
                data.append('bloquear' , this.bloquear);
                data.append('cupo_credito' , this.cupo_credito);
                data.append('vr_cupo_credito' , this.vr_cupo_credito);
                data.append('retenedor_fuente' , this.retenedor_fuente);
                data.append('retenedor_iva' , this.retenedor_iva);
                data.append('excluido_iva' , this.excluido_iva);
                data.append('autoretefuente' , this.autoretefuente);
                data.append('autoreteiva' , this.autoreteiva);
                data.append('autoreteica' , this.autoreteica);
                data.append('id_banco' , this.id_banco);
                data.append('num_cuenta_banco' , this.num_cuenta_banco);
                data.append('tipo_cuenta' , this.tipo_cuenta);
                data.append('representante_cuenta' , this.representante_cuenta);
                data.append('tipo_nacionalidad' , this.tipo_nacionalidad);
                data.append('departamento' , this.departamento);
                data.append('municipio' , this.municipio);
                data.append('img', this.arrayImg);
                data.append('id', this.persona_id);

                axios.post( this.ruta +'/cliente/actualizar',data,{
                    headers:{'Content-Type':'multipart/form-data'}
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                    me.num_verif="";
                }).catch(function (error) {
                    console.log(error);
                }); 
            },            
            validarPersona(){
                let me = this;
                me.hasError['tipo_persona'] = 0;
                me.hasError['digito_verif'] = 0;
                me.hasError['img'] = 0;
                me.hasError['nombre'] = 0;
                me.hasError['nombre1'] = 0;
                me.hasError['nombre2'] = 0;
                me.hasError['departamento'] = 0;
                me.hasError['apellido1'] = 0;
                me.hasError['apellido2'] = 0;
                me.hasError['municipio'] = 0;
                me.hasError['tipo_documento'] = 0;
                me.hasError['num_documento'] = 0;
                me.hasError['num_verif'] = 0;
                me.hasError['direccion'] = 0;
                me.hasError['email'] = 0;
                me.hasError['regimen'] = 0;
                me.hasError['sexo'] = 0;
                me.hasError['fec_nac'] = 0;
                me.hasError['telefono1'] = 0;
                me.hasError['reside'] = 0;
                me.hasError['representante'] = 0;
                me.hasError['entidad'] = 0;
                me.hasError['autoretenedor'] = 0;
                me.hasError['declarante'] = 0;
                me.hasError['cliente'] = 0;
                me.hasError['proveedor'] = 0;
                me.hasError['id_vendedor'] = 0;
                me.hasError['id_zona'] = 0;
                me.hasError['plazo_pago'] = 0;
                me.hasError['retiendor_fuente'] = 0;
                me.hasError['retenedor_iva'] = 0;
                me.hasError['excluido_iva'] = 0;
                me.hasError['cupo_credito'] = 0;
                me.hasError['vr_cupo_credito'] = 0;
                me.hasError['id_banco'] = 0;
                me.hasError['num_cuenta_banco'] = 0;
                me.hasError['tipo_cuenta'] = 0;
                me.hasError['representante_cuenta'] = 0;
                me.hasError['tipo_nacionalidad'] = 0;

                me.errorPersona=0;
                me.errorMostrarMsjPersona =[];

                if(!me.tipo_persona || me.tipo_persona==0 || me.tipo_persona==null) {me.errorPersona=1; me.hasError['tipo_persona']=1;}
                if(me.tipoAccion==1 && me.$refs.inputFileImg.value=='') {me.errorPersona=1; me.hasError['img']=1;}
                if(!me.tipo_documento || me.tipo_documento==0) {me.errorPersona=1; me.hasError['tipo_documento']=1;}
                if(!me.num_documento || me.num_documento==0) {me.errorPersona=1; me.hasError['num_documento']=1;}
                if(me.digito_verif && (!me.num_verif || me.num_verif<=0)) {me.errorPersona=1; me.hasError['num_verif']=1;}
                if(!me.direccion || me.direccion=='' || me.direccion==null) {me.errorPersona=1; me.hasError['direccion']=1;}
                if(!me.email || me.email=='' || me.email==null) {me.errorPersona=1; me.hasError['email']=1;}
                if(!me.regimen || me.regimen==0 || me.regimen==null) {me.errorPersona=1; me.hasError['regimen']=1;}
                if(!me.sexo || me.sexo==0 || me.sexo==null) {me.errorPersona=1; me.hasError['sexo']=1;}
                if(!me.fec_nac || me.fec_nac=='' || me.fec_nac==null) {me.errorPersona=1; me.hasError['fec_nac']=1;}
                if(!me.telefono1 || me.telefono1==null || me.telefono1=='') {me.errorPersona=1; me.hasError['telefono1']=1;}
                if(!me.reside || me.reside=='' || me.reside==null) {me.errorPersona=1; me.hasError['reside']=1;}
                if(!me.autoretenedor || me.autoretenedor==0 || me.autoretenedor==null) {me.errorPersona=1; me.hasError['autoretenedor']=1;}
                if(!me.declarante || me.declarante==0 || me.declarante==null) {me.errorPersona=1; me.hasError['declarante']=1;}

                /*if(me.cliente)
                {
                    var errorCliente = 0;
                    if(!me.id_vendedor || me.id_vendedor==0 || me.id_vendedor==null) {me.errorPersona=1; me.hasError['id_vendedor']=1; errorCliente = 1;}
                    if(!me.id_zona || me.id_zona==0 || me.id_zona==null) {me.errorPersona=1; me.hasError['id_zona']=1; errorCliente = 1;}
                    if(!me.plazo_pago || me.plazo_pago<=0 || me.plazo_pago==null) {me.errorPersona=1; me.hasError['plazo_pago']=1; errorCliente = 1;}
                    if(me.cupo_credito && (!me.vr_cupo_credito || me.vr_cupo_credito<=0 || me.cupo_credito==null)) {me.errorPersona=1; me.hasError['vr_cupo_credito']=1; errorCliente = 1;}

                    if(errorCliente==1) me.errorMostrarMsjPersona.push('Debe diligenciar todos los campos requeridos del cliente');
                }

                if(me.proveedor)
                {
                    var errroProveedor = 0;
                    if(!me.id_banco || me.id_banco==0 || me.id_banco==null) {me.errorPersona=1; me.hasError['id_banco']=1; errroProveedor=1;}
                    if(!me.num_cuenta_banco || me.num_cuenta_banco<=0 || me.num_cuenta_banco==null) {me.errorPersona=1; me.hasError['num_cuenta_banco']=1; errroProveedor=1;}
                    if(!me.tipo_cuenta || (me.tipo_cuenta!='Ahorros' && me.tipo_cuenta!='Corriente')) {me.errorPersona=1; me.hasError['tipo_cuenta']=1; errroProveedor=1;}
                    if(!me.representante_cuenta || me.representante_cuenta=='' || me.representante_cuenta==null) {me.errorPersona=1; me.hasError['representante_cuenta']=1; errroProveedor=1;}
                    if(!me.tipo_nacionalidad || me.tipo_nacionalidad==0 || me.tipo_nacionalidad==null) {me.errorPersona=1; me.hasError['tipo_nacionalidad']=1; errroProveedor=1;}

                    if(errroProveedor==1) me.errorMostrarMsjPersona.push('Debe diligenciar todos los campos requeridos del proveedor');
                }

                if(me.tipo_persona=='Natural')
                {
                    if(!me.nombre1 || me.nombre1=='' || me.nombre1==null) {me.errorPersona=1; me.hasError['nombre1']=1;}
                    if(!me.nombre2 || me.nombre2=='' || me.nombre2==null) {me.errorPersona=1; me.hasError['nombre2']=1;}
                    if(!me.apellido1 || me.apellido1=='' || me.apellido1==null) {me.errorPersona=1; me.hasError['apellido1']=1;}
                    if(!me.apellido2 || me.apellido2=='' || me.apellido2==null) {me.errorPersona=1; me.hasError['apellido2']=1;}
                    if(!me.departamento || me.departamento==0 || me.departamento==null) {me.errorPersona=1; me.hasError['departamento']=1;}
                    if(!me.municipio || me.municipio==0 || me.municipio==null) {me.errorPersona=1; me.hasError['municipio']=1;}
                }
                else
                {
                    if(!me.nombre || me.nombre=='' || me.nombre==null) {me.errorPersona=1; me.hasError['nombre']=1;}
                    if(!me.representante || me.representante==0 || me.representante==null) {me.errorPersona=1; me.hasError['representante']=1;}
                }*/

                if(me.errorMostrarMsjPersona.length) me.errorPersona=1;

                return me.errorPersona;
            },
            registrarNovedad(){
                // if (this.validarPersona()){
                //     return;
                // }
                
                let me = this;

                axios.post( this.ruta +'/novedades/registrar',{
                    'id_tercero' : this.persona_id,
                    'nombre': this.novedad,
                    'observacion' : this.observacionNovedad,
                    'link' : this.link,
                }).then(function (response) {
                    me.tipoAccion3=0;
                    me.listarNovedades(me.persona_id);
                }).catch(function (error) {
                    console.log(error); 
                });
            },
            eliminarNovedad(id){
                let me = this;

                axios.put( this.ruta +'/novedades/eliminarNovedad',{
                    'id': id,
                }).then(function (response) {
                    me.listarNovedades(me.persona_id);
                }).catch(function (error) {
                    console.log(error); 
                });
            },
            cerrarModal3(){
                this.modal3=0;
                this.tituloModal3='';
                this.tipoAccion3=0;
                this.novedad='';
                this.observacionNovedad='';
                this.link='';
                this.tipoAccion3=0;
            }, 
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.tipo_documento='CC';
                this.num_documento='';
                this.direccion='';
                this.telefono1='';
                this.email='';
                this.errorPersona=0;
                this.sexo ='';
                this.regimen ='';
                this.fec_nac ='';
                this.reside ='';
                this.representante ='';
                this.tipo_persona = 'Natural';
                this.nombre1= '',
                this.nombre2= '',
                this.apellido1= '',
                this.apellido2= '',
                this.autoretenedor= '',
                this.declarante='',
                this.img = '';
                this.arrayImg = [];
                this.$refs.inputFileImg.value = '';

                this.tipoAccion2 = 0;
                this.departamento = '';
                this.municipio = '';
            },  
            abrirModal(modelo, accion, data = []){
                this.listarVendedores();
                this.listarZonas();
                this.listarBancos();
                this.listarDepartamentos();
                switch(modelo){
                    case "persona":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Tercero';
                                this.nombre= '';
                                this.tipo_documento='CC';
                                this.num_documento='';
                                this.direccion='';
                                this.telefono1='';
                                this.email='';
                                this.autoretenedor='';
                                this.declarante='';
                                this.cliente = false;
                                this.proveedor = false;
                                this.id_vendedor = '';
                                this.id_zona = '';
                                this.plazo_pago = '';
                                this.bloquear = '';
                                this.cupo_credito = '';
                                this.vr_cupo_credito = 0;
                                this.retenedor_fuente = '';
                                this.retenedor_iva = '';
                                this.excluido_iva = '';
                                this.autoretefuente = '';
                                this.autoreteiva = '';
                                this.autoreteica = '';
                                this.id_banco = 0;
                                this.num_cuenta_banco = '';
                                this.tipo_cuenta = '';
                                this.representante_cuenta = '';
                                this.tipo_nacionalidad = '';
                                this.departamento = '';
                                this.municipio = '';

                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                // console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Cliente';
                                this.tipoAccion=2;
                                this.persona_id=data['id'];
                                this.nombre = data['nombre'];
                                this.nombre1 = data['nombre1'];
                                this.nombre2 = data['nombre2'];
                                this.apellido1 = data['apellido1'];
                                this.apellido2 = data['apellido2'];
                                this.tipo_persona = data['tipo_persona'];
                                this.tipo_documento = data['tipo_documento'];
                                this.num_documento = data['num_documento'];
                                this.direccion = data['direccion'];
                                this.telefono1 = data['telefono1'];
                                this.email = data['email'];
                                this.sexo =data['sexo'];
                                this.regimen =data['regimen'];
                                this.fec_nac =data['fec_nac'];
                                this.reside =data['reside'];
                                this.representante =data['email'];
                                this.entidad =data['entidad'];
                                this.digito_verif =data['digito_verif'];
                                this.num_verif =data['num_verif'];
                                this.autoretenedor = data['autoretenedor'];
                                this.declarante = data['declarante'];
                                this.cliente = data['cliente'];
                                this.proveedor = data['proveedor'];
                                this.id_vendedor = data['id_vendedor'];
                                this.id_zona = data['id_zona'];
                                this.plazo_pago = data['plazo_pago'];
                                this.bloquear = data['bloquear'];
                                this.cupo_credito = data['cupo_credito'];
                                this.vr_cupo_credito = data['vr_cupo_credito'];
                                this.retenedor_fuente = data['retenedor_fuente'];
                                this.retenedor_iva = data['retenedor_iva'];
                                this.excluido_iva = data['excluido_iva'];
                                this.autoretefuente = data['autoretefuente'];
                                this.autoreteiva = data['autoreteiva'];
                                this.autoreteica = data['autoreteica'];
                                this.id_banco = data['id_banco'];
                                this.num_cuenta_banco = data['num_cuenta_banco'];
                                this.tipo_cuenta = data['tipo_cuenta'];
                                this.representante_cuenta = data['representante_cuenta'];
                                this.tipo_nacionalidad = data['tipo_nacionalidad'];
                                this.departamento = data['departamento'];
                                this.municipio = data['municipio'];

                                this.listarMunicipios(this.departamento);
                                
                                break;
                            }
                            case 'cliente':{
                                this.modal2=1;
                                this.tituloModal2='Información adicional Cliente';
                                this.tipoAccion2 = 1;
                                break;
                            }
                            case 'proveedor': {
                                this.modal2=1;
                                this.tituloModal2='Información adicional Cliente';
                                this.tipoAccion2 = 2;
                                break;
                            }
                            case 'novedades':{
                                this.modal3 = 1;
                                this.tituloModal3 = 'Novedades';
                                this.persona_id=data['id'];
                                this.listarNovedades(data['id']);
                            }
                        }
                        break;
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
