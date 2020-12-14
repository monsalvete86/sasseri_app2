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
    <body style="    max-width: 250px;">
        <div id="logo">
            <!-- <img src="img/logo2.png" alt="incanatoIT" id="imagen">  -->                   
            <!--<img src="img/logo2.png" alt="incanatoIT" id="imagen2">-->
            
        </div>
        <div     style="text-align: center;">
            <b>EMCOFUNERAL LA PAZ</b><br>
            "Tu mano amiga en momentos dificiles"<br>
            NIT 901.022.959.-0 Régimen Común<br>
            Crr 29 # 12 - 14 B/ Allende<br>
            Puerto Asís - Putumayo<br>
            Tel: 4229808 Cel: 3202479589<br>
        </div>
        <br>             
        <b>Recibo No.</b> {{$facturacion->id}}<br>
        <b>Fecha:    </b> {{$facturacion->fecha}}<br><br>
        <b>Cliente:</b>        
        {{$tercero->nombre1}} {{$tercero->nombre2}} {{$tercero->apellido1}} {{$tercero->apellido2}}<br>
        <b>Tipo Documento:</b> {{$tercero->tipo_documento}}<br>
        <b>Documento:</b>{{$tercero->num_documento}}<br><br>
        <b>Detalle:</b>
        <br>
        {{$facturacion->detalle}}
        <br><br>
        <b>Subtotal:</b> {{$facturacion->subtotal}}<br>
        <b>Impuestos:</b> $0<br>
        <b>Total:</b> {{$facturacion->total}}<br><br>
        <div     style="text-align: center;">
            <b>Email: </b>emcofuneraleslapaz@hotmail.com
        </div>
        <br><br><br><br><br>
        <!--
        <footer>
            <div id="gracias">
                <p><b>Gracias por su compra!</b></p>
            </div>
        </footer>-->
    </body>
</html>