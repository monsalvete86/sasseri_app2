<?php  
//Session::put('hola', 'value');
$menu_usuario = Session::get('menu_usu');
//echo "holllllaaaaaa ";
//echo "<pre>"; print_r($menu_usuario); echo "</pre><br><br>";?>

<div class="sidebar">
            <nav class="sidebar-nav">
			

                <ul class="nav">
                    <li @click="menu=0" class="nav-item">
                        <a class="nav-link active" href="#"><i class="icon-speedometer"></i> Escritorio</a>
                    </li>
                    <li class="nav-title">
                        Menu Principal 
                    </li>
                    
					@foreach ($menu_usuario as $menu_usu)
						<li class="nav-item nav-dropdown">
							<a class="nav-link nav-dropdown-toggle" href="#"><i class="{{$menu_usu['icono']}}"></i> {{$menu_usu['modulo']}}</a>
							@if(count($menu_usu['hijos'])>0)
								<ul class="nav-dropdown-items">
									@foreach ($menu_usu['hijos'] as $menu_hijo)
                  
										<li @click="menu={{$menu_hijo['menu']}}" class="nav-item">
											<a class="nav-link" href="#"><i class="{{$menu_hijo['icono']}}"></i> {{$menu_hijo['modulo']}}</a>
										</li>
                  
									@endforeach
								</ul>
							@endif
                        </li>
					@endforeach
			
					
                    <!--<li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> Contabilidad</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=16" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Registro</a>
                            </li>
                            <li @click="menu=17" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Terceros</a>
                            </li>
                            <li @click="menu=13" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Plan de Cuentas</a>
                            </li>
                            <li @click="menu=15" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Formatos</a>
                            </li>
                            
                        </ul>
                    </li>-->
                    
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i> Acceso</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=999991" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user"></i> Usuarios</a>
                            </li>
                            <li @click="menu=999992" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user-following"></i> Roles</a>
                            </li>
                            <li @click="menu=999993" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user-following"></i> Modulos</a>
                            </li>
                        </ul>
                    </li>
                    <li @click="menu=999994" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-info"></i> Acerca de...<span class="badge badge-info">IT</span></a>
                    </li>
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>