@extends('principal')
    @section('contenido')
<?php
    $menu_usuario2 = Session::get('menu_usu');
?>
    @if(Auth::check())
            <template v-if="menu==0">
                <h1>Escritorio</h1>
            </template>
            
			@foreach ($menu_usuario2 as $menu_usu)
				@if(count($menu_usu['hijos'])>0)
					@foreach ($menu_usu['hijos'] as $menu_hijo)
						<template v-if="menu=={{$menu_hijo['menu']}}">
							<{{$menu_hijo['template_menu']}} :ruta="ruta" :permisos-user="permisosUser['{{$menu_hijo['template_menu']}}']"></{{$menu_hijo['template_menu']}}>
						</template>
					@endforeach
				@endif
			@endforeach
			
            <template v-if="menu==999991">
                <user :ruta="ruta"></user>
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

            <template v-if="menu==999994">
                <h1>Acerca de</h1>
            </template>   


    @endif
       
        
    @endsection