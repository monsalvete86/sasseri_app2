<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de venta</title>
    <style>
        body {
            /*position: relative;*/
            /*width: 16cm;  */
            /*height: 29.7cm; */
            /*margin: 0 auto; */
            /*color: #555555;*/
            /*background: #FFFFFF; */
            font-family: Arial, sans-serif; 
            font-size: 11px;
            /*font-family: SourceSansPro;*/
        }

        #logo{
            float: left;
            margin-top: 0%;
            margin-left: -2%;
            margin-right: -4%;
        }
        #logo2{
            float: left;
            margin-top: 0%;
            margin-left: 0%;
            margin-right: 0%;
        }

        #imagen2{
            width: 200px;
        }
        #imagen{
            width: 60px;
            margin-left: -10px !important;
            margin-top: 13px;
        }

        #datos{
            float: left;
            margin-top: 0%;
            margin-left: 3%;
            margin-right: 2%;
            /*text-align: justify;*/
        }

        #encabezado{
            text-align: center;
            margin-left: 0%;
            margin-right: 3%;
            
        }

        #fact{
            /*position: relative;*/
            float: right;
            margin-top: 13px;
            margin-left: 15px;
            margin-right: 30px;
            font-size: 14px;
        }

        section{
            clear: left;
        }
        #cliente{
            text-align: left;
        }
        #facliente{
            width: 90%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 15px;
        }
        #fac, #fv, #fa{
            color: #FFFFFF;
            font-size: 15px;
        }
        #facliente thead{
            padding: 20px;
           
            text-align: left;
            border-bottom: 1px solid #FFFFFF;  
        }
        #facvendedor{
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 15px;
        }

        #facvendedor thead{
            padding: 20px;
            /*background: #2183E3;*/
            text-align: center;
            border-bottom: 1px solid #FFFFFF;  
        }
        #facarticulo{
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 15px;
        }
        #facarticulo thead{
            padding: 20px;
            background: #2183E3;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;  
        }
        #gracias{
            text-align: center; 
        }
    </style>
    <body>
    
        @foreach ($formato as $f)
            <header>
                <div id="logo">
                   <!-- <img src="img/logo2.png" alt="incanatoIT" id="imagen">  -->                   
                   <img src="../../img/logo2.png" alt="incanatoIT" id="imagen2">
                </div>
               
                <div id="datos">
                    <p id="encabezado">
                        <b><span style="font-weight: bolder;">EMPRESA DE COFRES FUNERARIOS</span></b><br>
                        <b><!--<span>EMCOFUNERAL LA PAZ S.A.S</span>--><span>{{ $f->nom_empresa }}</span></b><br> 
                        NIT 901022959-0 - Régimen Común
                        <br>Cel: 3202479589 - 3115946736<br>
                        <span style="font-size: 10px;margin-bottom: 3px;" >E-MAIL:emcofuneraleslapaz@hotmail.com</span><br>
                        <hr style="margin-top: -10px; margin-bottom: 3px; border-color: #0d520d;" size="2" noshade="noshade" >
                        <span style="font-size: 8px;"><b>Crr 29 No 12 -14 B/ Allende - Tel: 4229808 - Puerto Asís - Putumayo</b></span>
                        
                    </p>
                </div>
                <div id="logo2">                   
                        <!-- <img src="img/logo2.png" alt="incanatoIT" id="imagen">  -->                    
                        <img src="../..//img/logo-remanso.png" alt="incanatoIT" id="imagen">
                     </div>
                <div id="fact">
                    <p style="margin-bottom: -10px;background-color: #b4f1b0;"><b>{{$f->nombre_formato}}</b><br><center></p>
                   <span>N°. {{  $f->numero}}</p></center>
                </div>
            </header>
            <br>
            <section>
                <div>
                    <table id="facliente" align="center" BORDER='0' width="90%" style="font-size: 14px;">
                        <thead>                      
                            <tr>                            
                                <th>Fecha</th>
                                <td colspan="3">{{ $f->fecha }}  </td></tr>
                            <tr>
                                <th >Tercero</th>
                                <td>                                    
                                    @if ($f->nombre!=''&&strlen($f->nombre)>2)
                                    
                                        {{ $f->nombre}} 
                                    @else                                                                       
                                        {{ $f->nombre1." ".$f->nombre1." ".$f->apellido1." ".$f->apellido2  }}
                                    @endif                                                                  
                                </td>
                                <th>Identificación</th>
                                <td>{{ $f->num_documento}}</td>
                            </tr>
                            <tr>
                                <th >Dirección</th><td>{{ $f->direccion}}</td>
                                <th >Teléfono</th><td>{{ $f->telefono}}</td>
                            </tr>
                            </tr>
                                <th >Detalle</th><td colspan="3">{{ $f->detalle}}</td>
                            </tr>
                        </thead>                        
                    </table>
                </div>
                <div>
                    <table align="center" style="font-size: 14px;">
                        <thead>
                            <tr align="center">
                                <td colspan="6" style="background-color: #b4f1b0;"><b>AFECTACION CONTABLE</b></td>
                            </tr>
                            <tr style="background-color: #b4f1b0;">
                                <td><b>Codigo</b></td><td><b>Nombre</b></td><td><b>Tercero</b></td><td><b>Documento</b></td>
                                <td><b>Debito</b></td><td><b>Credito</b></td>
                            </tr>
                        </thead>
                        <tdbody>
                <?php   $sum_debito=0; $sum_credito=0;
                        foreach($detalles as $d){
                            $sum_debito+=$d->debe;  $sum_credito+=$d->haber; ?>
                            <tr>
                               <td>{{ $d->codigo}}</td><td>{{ $d->nombre}}</td><td>{{ $d->num_documento}}</td>
                               <td>{{ $d->doc_afecta_long}}</td>
                               <td style="text-align: right;">{{ number_format($d->debe,2)}}</td>
                               <td style="text-align: right;">{{ number_format($d->haber,2)}}</td>
                            </tr>
                <?php   }   ?>                      
                            <tr style="background-color: #b4f1b0;">
                                <td colspan="4"><b>SUMAS</b></td>
                                <td style="text-align: right;"><b><?= number_format($sum_debito,2)?></b></td>
                                <td style="text-align: right;"><b><?= number_format($sum_credito,2)?></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br><br><br><br><br>
                <div>
                    <div style="    position: relative; float: left; margin-left: 9em;"><hr width="250px" />
                        Elabora
                    </div>
                    <div style="    position: relative; float: right; margin-right: 9em;"><hr width="250px" />
                        Recibe
                    </div>
                </div>
            </section>

        @endforeach
        <br>
        
        <br>
        <!--
        <footer>
            <div id="gracias">
                <p><b>Gracias por su compra!</b></p>
            </div>
        </footer>-->
    </body>
</html>