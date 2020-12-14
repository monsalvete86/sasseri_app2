<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte cilindros</title>
    <style>
            body {
                /*position: relative;*/
                /*width: 16cm;  */
                /*height: 29.7cm; */
                /*margin: 0 auto; */
                /*color: #555555;*/
                /*background: #FFFFFF; */
                font-family: Arial, sans-serif; 
                font-size: 11px !important;
                /*font-family: SourceSansPro;*/
            }
    /*
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
                text-align: justify;
            }
    
            #encabezado{
                text-align: center;
                margin-left: 0%;
                margin-right: 3%;
                
            }
    
            #fact{
                position: relative;
                float: right;
                margin-top: 13px;
                margin-left: 15px;
                margin-right: 30px;
                font-size: 11px;
            }
    
            section{
                clear: left;
            }
            #cliente{
                text-align: left;
            }
            #facliente{
                width: 40%;
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
                background: #2183E3;
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
                background: #2183E3;
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
            .table {
                display: table;
                width: 100%;
                max-width: 100%;
                margin-bottom: 1rem;
                background-color: transparent;
                border-collapse: collapse;
            }
            .table-bordered {
                border: 1px solid #c2cfd6;
                font-size: 12px !important;
            }
            thead {
                display: table-header-group;
                vertical-align: middle;
                border-color: inherit;
            }
            tr {
                display: table-row;
                vertical-align: inherit;
                border-color: inherit;
            }
            .table th, .table td {
                padding: 0.35rem !important; 
                vertical-align: top;
                border-top: 1px solid #c2cfd6;
            }
            .table thead th {
                vertical-align: bottom;
                border-bottom: 2px solid #c2cfd6;
            }
            .table-bordered thead th, .table-bordered thead td {
                border-bottom-width: 2px;
            }
            .table-bordered th, .table-bordered td {
                border: 1px solid #c2cfd6;
            }
            th, td {
                display: table-cell;
                vertical-align: inherit;
            }
            th {
                font-weight: bold;
                text-align: -internal-center;
                text-align: left;
            }
            tbody {
                display: table-row-group;
                vertical-align: middle;
                border-color: inherit;
            }
            tr {
                display: table-row;
                vertical-align: inherit;
                border-color: inherit;
            }
            .table-striped tbody tr:nth-of-type(odd) {
                background-color: rgba(0, 0, 0, 0.05);
            }
        </style>*/
</head>
<body>
    <header>
        <table class="table table-bordered  table-sm">
                <tr style="    background-color: white;">
                    <td width="8%" rowspan="3">
                        <img src="img/logo2.png" alt="incanatoIT" id="imagen2">
                        
                    </td>
                    <td rowspan="3" width="60%">
                        <center>
                            <b><h3>{{ $emp->nom_compania }}</h3> </b>
                            <span><b>{{ $emp->tipo_id }} : {{ $emp->identificacion }}</b><br>
                            <b>{{ $emp->direccion }}</b><br>
                            <b>{{ $emp->ciudad }} - {{ $emp->departamento }}</b><br>
                            <b>{{ $emp->telefono }}</b>                            
                        </center>
                    </td>       
                    <td><b>ID:</b></td><td>{{ $datos['global_id_proyecto'] }}</td>             
                </tr>
                <tr>
                    <th><b>Fecha:</b></th>
                    <td>{{  date('j/m/Y') }}</td>
                </tr>
                
                <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                
            </table><br>
            <table class="table table-bordered  table-sm">
                <tr><td colspan="6"><b><center>CONTROL DE CALIDAD DEL CONCRETO ESTRUCTURAL</center></b></td></tr>
                <tr>
                    <th style="width: 3em;">PROYECTO:</th><td>{{ $datos['global_nom_proyecto'] }}</td>
                    
                </tr>
                <tr>
                    <th style="width: 3em;">RESPONSALBE:</th><td >{{ $datos['global_nom_cliente'] }}</td>
                </tr>
            </table>
    </header>
    <br>
    <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th rowspan="2">Cod. Cilindro</th>
                    <th rowspan="2">Fecha Fundición</th>
                    <th rowspan="2">Fecha Rotura</th>
                    <th rowspan="2">Edad</th>
                    <th rowspan="2">Localización</th>
                    <th rowspan="2">No. Muestra</th>
                    <th rowspan="2">Diametro</th>
                    <th rowspan="2">Carga Máxima</th>
                    <th colspan="2">Resistencia conseguida</th>
                    <th rowspan="2">Res. de Diseño [PSI]</th>
                    <th rowspan="2">%</th>
                    
                </tr>
                <tr><th>[KG/CM<sup>2</sup>]</th><th>[PSI]</th></tr>
            </thead>
            <tbody>
                @foreach ($datos['cilindros'] as $c)
                    <tr>
                        
                        <td >{{ 'C'.$c['cliente'].'-'.$c['id_proyecto'].'-E'.$c['id'] }}</td>
                        <td >{{$c['fecha_cilindro']}}</td>
                        <td >{{$c['fecha']}}</td>
                        <td >{{$c['edad']}}</td>
                        <td >{{$c['descripcion']}}</td>
                        <td >{{$c['nom_cilindro']}}</td>
                        <td >{{$c['diametro']}}</td>
                        <td>{{$c['res_cilindro']}}</td><td>{{$c['val_res_kg']}}</td><td>{{$c['val_resis']}}</td>
                        <td >{{$c['resist_dise']}}</td><td>{{$c['porcent_resist']}}%</td>
                    </tr>
                @endforeach                                
                
            </tbody>
        </table>
</body>
</html>