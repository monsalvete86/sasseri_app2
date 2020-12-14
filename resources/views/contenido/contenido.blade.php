@extends('principal')
    @section('contenido')
<?php
    $menu_usuario2 = Session::get('menu_usu');
    $rol_usu = Auth::user()->idrol;
    
?>
    @if(Auth::check())
        <template v-if="menu==0">
            <br>
            <div class="card text-center">
                <img src="img/targeta.PNG" class="card-img-top" alt="">
            </div>   
        </template>
        @if($rol_usu==2)             
            <template v-if="menu==40">
                <punto_venta :ruta="ruta"></punto_venta>
            </template>
        @endif

                   
            
			<!-- @foreach ($menu_usuario2 as $menu_usu)
				@if(count($menu_usu['hijos'])>0)
					@foreach ($menu_usu['hijos'] as $menu_hijo)
						<template v-if="menu=={{$menu_hijo['menu']}}">
							<{{$menu_hijo['template_menu']}} :ruta="ruta" :permisos-user="permisosUser['{{$menu_hijo['template_menu']}}']"></{{$menu_hijo['template_menu']}}>
						</template>
					@endforeach
				@endif
			@endforeach -->
			
        @if($rol_usu == 1)   
            <template v-if="menu==999991">
                <user :ruta="ruta"></user>
            </template>
            <template v-if="menu==10">
                <terceros :ruta="ruta"></terceros>
            </template>
            <!-- Comfiguraciones -->
                <template v-if="menu==6">
                    <configgenerales :ruta="ruta"></configgenerales>
                </template>
                <template v-if="menu==12">
                    <zona :ruta="ruta"></zona>
                </template>
                <template v-if="menu==27">
                    <iva :ruta="ruta"></iva>
                </template>
                <template v-if="menu==29">
                    <cajas :ruta="ruta"></cajas>
                </template>
                
           
            <template v-if="menu==14">
                <facturacion :ruta="ruta"></facturacion>
            </template>
            <!-- almacen -->
                <template v-if="menu==15">
                    <articulo :ruta="ruta"></articulo>
                </template>
                <template v-if="menu==17">
                    <ingreso :ruta="ruta"></ingreso>
                </template>
                <template v-if="menu==18">
                    <egreso :ruta="ruta"></egreso>
                </template>
                <template v-if="menu==19">
                    <stock :ruta="ruta"></stock>
                </template>
                <template v-if="menu==22">
                    <presentacion :ruta="ruta"></presentacion>
                </template>
                <template v-if="menu==23">
                    <und_medida :ruta="ruta"></und_medida>
                </template>
                <template v-if="menu==24">
                    <concentracion :ruta="ruta"></concentracion>
                </template>
                <template v-if="menu==25">
                    <categoria :ruta="ruta"></categoria>
                </template>
            <!-- Cajas -->
                <template v-if="menu==35">
                    <cajas_admin :ruta="ruta"></cajas_admin>
                </template>
                <template v-if="menu==30">
                    <cierrescaja :ruta="ruta"></cierrescaja>
                </template>
            <!-- Cartera -->
                <template v-if="menu==33">
                    <cuentasxcobrar :ruta="ruta"></cuentasxcobrar>
                </template>
                <template v-if="menu==34">
                    <cuentasxpagar :ruta="ruta"></cuentasxpagar>
                </template>




            <template v-if="menu==999992">
                <rol :ruta="ruta"></rol>
            </template>

            <template v-if="menu==999993">
                <modulo :ruta="ruta"></modulo>
            </template>
            
            <!-- <template v-if="menu==11">
                <h1>Ayuda</h1>
            </template> -->
        @endif
            <template v-if="menu==999994">
                <h1>Acerca de</h1>
            </template>   


    @endif
       
        
    @endsection