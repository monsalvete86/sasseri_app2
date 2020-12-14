<!DOCTYPE html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de venta</title>
    <!--
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
    -->
    <body>
        <table>
            <thead>
                <tr>
                    @if($facturacion->num_factura)
                        <th colspan="8">INFORME DE FACTURA N° {{ $facturacion->num_factura}}</th>
                    @else
                        <th colspan="8">INFORME DE FACTURA</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>N° Factura:</td>
                    @if($facturacion->num_factura && $facturacion->num_factura!=0 && $facturacion->num_factura!='')
                    <td>{{ $facturacion->num_factura}}</td>
                    @else
                    <td>N/A</td>
                    @endif

                    <td>Caja:</td>
                    <td>{{ $caja->nombre }}</td>

                    <td>Cajero:</td>
                    <td>{{$user->usuario}}</td>

                    <td>Cliente:</td>
                    <td>{{$tercero->nombre1}} {{$tercero->nombre2}} {{$tercero->apellido1}} {{$tercero->apellido2}}</td>
                </tr>
                <tr>
                    <td>Fecha:</td>
                    <td>{{ $facturacion->fecha }}</td>

                    <td>Lugar:</td>
                    <td>{{ $lugar->zona }}</td>

                    <td>Detalle:</td>
                    <td>{{ $facturacion->detalle }}</td>

                    <td>Estado:</td>
                    @if($facturacion->estado==1)
                    <td>Activa</td>
                    @elseif($facturacion->estado==2)
                    <td>Registrada</td>
                    @elseif($facturacion->estado==3)
                    <td>Enviada</td>
                    @elseif($facturacion->estado==4)
                    <td>Anulada</td>
                    @endif
                </tr>
            </tbody>
        </table>
        <br>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Presentacion</th>
                    <th>Talla</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Descuento</th>
                    <th>Iva</th>
                    <th>Vr sin iva</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detalles as $det)
                    <tr>
                        <td>{{ $det->id }}</td>
                        <td>{{ $det->nombre }}</td>
                        <td>{{ $det->nom_presentacion }}</td>
                        <td>{{ $det->talla }}</td>
                        <td>{{ $det->valor_final }}</td>
                        <td>{{ $det->cantidad }}</td>
                        <td>{{ $det->valor_descuento }}</td>
                        <td>{{ $det->valor_iva }}</td>
                        <td>{{ $det->valor_subtotal }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="8">Valor total iva</td>
                    <td>{{ $facturacion->valor_iva }}</td>
                </tr>
                <tr>
                    <td colspan="8">Valor total sin iva</td>
                    <td>{{ $facturacion->subtotal }}</td>
                </tr>
                <tr>
                    <td colspan="8">Valor total neto</td>
                    <td>{{ $facturacion->total }}</td>
                </tr>
                <tr>
                    <td colspan="8">Valor abono</td>
                    <td>{{ $facturacion->abono }}</td>
                </tr>
                <tr>
                    <td colspan="8">Valor saldo</td>
                    <td>{{ $facturacion->saldo }}</td>
                </tr>
            </tbody>
            <?php
            // echo '<pre>';
            // print_r($detalles);
            // echo '</pre>';
            ?>
        </table>
    </body>
</html>