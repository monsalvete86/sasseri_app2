

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Required meta tags-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sasseri">
    <meta name="author" content="Incanatoit.com">
    <meta name="keyword" content="Software financiero y contable online">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Sasseri</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fontfaces CSS-->
    <link href="css/plantilla.css" rel="stylesheet">
    
</head>

<body class="animsition">
    <div id="app">
        <main>
          
            <!-- HEADER MOBILE-->
            <header class="header-mobile d-block d-lg-none">
                <div class="header-mobile__bar">
                    <div class="container-fluid">
                        <div class="header-mobile-inner">
                            <a class="logo col-sm-12" href="index.html">
                                <img src="img/logo.png" alt="Sasseri" />
                            </a>
                            
                        </div>
                    </div>
                </div>
                <nav class="navbar-mobile">
                    <div class="container-fluid">
                        <ul class="navbar-mobile__list list-unstyled">                        
                            <li @click="menu=999991" class="">
                                <a href="#"><i class="icon-user"></i> Usuarios</a>
                            </li>
                            <li @click="menu=10" class="">
                                <a href="#"><i class="icon-user"></i> Terceros</a>
                            </li>
                            <li @click="menu=40" class="">
                                <a href="#"><i class="icon-screen-desktop"></i> Punto de venta</a>
                            </li>
                            <li @click="menu=14" class="">
                                <a href="#"><i class="icon-calculator"></i> Facturación</a>
                            </li>
                            <li>
                                <a class="js-arrow" href="#"><i class="icon-wrench"></i>Configuración</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list" style="display:none;">
                                    <li @click="menu=6" class="">
                                        <a href="#"><i class="fa fa-building-o"></i> Empresa</a>
                                    </li>
                                    <li @click="menu=12" class="">
                                        <a href="#"><i class="fa fa-cutlery"></i> Mesas</a>
                                    </li>
                                    <li @click="menu=27" class="">
                                        <a href="#"><i class="fa fa-usd"></i></i> IVAs</a>
                                    </li>
                                    <li @click="menu=29" class="">
                                        <a href="#"><i class="fa fa-square-o"></i></i> Cajas</a>
                                    </li>

                                </ul>
                            </li>
                            <li>
                                <a class="js-arrow" href="#">
                                    <i class="icon-bag"></i>Almacén
                                </a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list" style="display:none;">
                                    <li @click="menu=15" class="">
                                        <a href="#"><i class="fa fa-table"></i></i> Articulo</a>
                                    </li>
                                    <li @click="menu=17" class="">
                                        <a href="#"><i class="fa fa-share"></i></i> Entradas</a>
                                    </li>
                                    <li @click="menu=18" class="">
                                        <a href="#"><i class="fa fa-reply"></i> Salidas</a>
                                    </li>
                                    <li @click="menu=19" class="">
                                        <a href="#"><i class="fa fa-archive"></i> Stock</a>
                                    </li>
                                    <li @click="menu=22" class="">
                                        <a href="#"><i class="fa fa-circle"></i> Presentación</a>
                                    </li>
                                    <li @click="menu=23" class="">
                                        <a href="#"><i class="fa fa-flask"></i> Unidad de medida</a>
                                    </li>
                                    <li @click="menu=24" class="">
                                        <a href="#"><i class="fa fa-tint"></i> Concentración</a>
                                    </li>
                                    <li @click="menu=25" class="">
                                        <a href="#"><i class="fa fa-level-down"></i> Categoría</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="js-arrow" href="#">
                                    <i class="icon-basket"></i>Cajas
                                </a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list" style="display:none;">
                                    <li @click="menu=35" class="">
                                        <a href="#"><i class="fa fa-list-ol"></i> Gestión de cajas</a>
                                    </li>
                                    <li @click="menu=30" class="">
                                        <a href="#"><i class="fa fa-times-circle"></i> Cierre de caja</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="js-arrow" href="#">
                                    <i class="icon-wallet"></i>Cartera
                                </a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list" style="display:none;">
                                    <li @click="menu=33" class="">
                                        <a href="#"><i class="fa fa-money"></i> Cuentas por cobrar</a>
                                    </li>
                                    <li @click="menu=34" class="">
                                        <a href="#"><i class="fa fa-money"></i> Cuentas por pagar</a>
                                    </li>
                                </ul>
                            </li>
                        
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- END HEADER MOBILE-->

            <section id="wrapper">
                <div class="container-fluid row" style="margin:auto;">
                    <!-- MENU SIDEBAR-->
                    <aside class="menu-sidebar d-none d-lg-block col-lg-3">
                        <div class="logo">
                            <a href="#">
                                <img src="img/logo.png" alt="Sasseri" />
                            </a>
                        </div>
                        <div class="menu-sidebar__content js-scrollbar1">
                            <nav class="navbar-sidebar">
                                <ul class="list-unstyled navbar__list">
                                    <li @click="menu=999991" class="">
                                        <a href="#"><i class="icon-user"></i> Usuarios</a>
                                    </li>
                                    <li @click="menu=10" class="">
                                        <a href="#"><i class="icon-user"></i> Terceros</a>
                                    </li>
                                    <li @click="menu=40" class="">
                                        <a href="#"><i class="icon-screen-desktop"></i> Punto de venta</a>
                                    </li>
                                    <li @click="menu=14" class="">
                                        <a href="#"><i class="icon-calculator"></i> Facturación</a>
                                    </li>
                                    <li class="has-sub">
                                        <a class="js-arrow" href="#">
                                            <i class="icon-wrench"></i>Configuración</a>
                                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                                            <li @click="menu=6" class="">
                                                <a href="#"><i class="fa fa-building-o"></i> Empresa</a>
                                            </li>
                                            <li @click="menu=12" class="">
                                                <a href="#"><i class="fa fa-cutlery"></i> Mesas</a>
                                            </li>
                                            <li @click="menu=27" class="">
                                                <a href="#"><i class="fa fa-usd"></i></i> IVAs</a>
                                            </li>
                                            <li @click="menu=29" class="">
                                                <a href="#"><i class="fa fa-square-o"></i></i> Cajas</a>
                                            </li>

                                        </ul>
                                    </li>
                                    <li class="has-sub">
                                        <a class="js-arrow" href="#">
                                            <i class="icon-bag"></i>Almacén
                                        </a>
                                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                                            <li @click="menu=15" class="">
                                                <a href="#"><i class="fa fa-table"></i></i> Articulo</a>
                                            </li>
                                            <li @click="menu=17" class="">
                                                <a href="#"><i class="fa fa-share"></i></i> Entradas</a>
                                            </li>
                                            <li @click="menu=18" class="">
                                                <a href="#"><i class="fa fa-reply"></i> Salidas</a>
                                            </li>
                                            <li @click="menu=19" class="">
                                                <a href="#"><i class="fa fa-archive"></i> Stock</a>
                                            </li>
                                            <li @click="menu=22" class="">
                                                <a href="#"><i class="fa fa-circle"></i> Presentación</a>
                                            </li>
                                            <li @click="menu=23" class="">
                                                <a href="#"><i class="fa fa-flask"></i> Unidad de medida</a>
                                            </li>
                                            <li @click="menu=24" class="">
                                                <a href="#"><i class="fa fa-tint"></i> Concentración</a>
                                            </li>
                                            <li @click="menu=25" class="">
                                                <a href="#"><i class="fa fa-level-down"></i> Categoría</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="has-sub">
                                        <a class="js-arrow" href="#">
                                            <i class="icon-basket"></i>Cajas
                                        </a>
                                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                                            <li @click="menu=35" class="">
                                                <a href="#"><i class="fa fa-list-ol"></i> Gestión de cajas</a>
                                            </li>
                                            <li @click="menu=30" class="">
                                                <a href="#"><i class="fa fa-times-circle"></i> Cierre de caja</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="has-sub">
                                        <a class="js-arrow" href="#">
                                            <i class="icon-wallet"></i>Cartera
                                        </a>
                                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                                            <li @click="menu=33" class="">
                                                <a href="#"><i class="fa fa-money"></i> Cuentas por cobrar</a>
                                            </li>
                                            <li @click="menu=34" class="">
                                                <a href="#"><i class="fa fa-money"></i> Cuentas por pagar</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </aside>
                    <!-- END MENU SIDEBAR-->

                    <!-- PAGE CONTAINER-->
                    <div class="page-container col-lg-9">
                        <section id="main">
                            <!-- HEADER DESKTOP-->
                            <header class="col-lg-12 bg-gray-light">
                                <div class="section__content section__content--p30x">
                                    <div class="container-fluid">
                                        <div class="header-wrap2">                                
                                            <div class="header-button">
                                                <button class="hamburger hamburger--slider d-lg-none" type="button">
                                                    <span class="hamburger-box">
                                                        <i class="fa fa-align-justify"></i>
                                                        <!-- <span class="hamburger-inner"></span> -->
                                                    </span>
                                                </button>
                                                <div class="noti-wrap">                                      
                                                    <div class="noti__item js-item-menu">
                                                        <i class="zmdi zmdi-notifications"></i>
                                                        <span class="quantity">3</span>
                                                        <div class="notifi-dropdown js-dropdown">
                                                            <div class="notifi__title">
                                                                <p>You have 3 Notifications</p>
                                                            </div>
                                                            <div class="notifi__item">
                                                                <div class="bg-c1 img-cir img-40">
                                                                    <i class="zmdi zmdi-email-open"></i>
                                                                </div>
                                                                <div class="content">
                                                                    <p>You got a email notification</p>
                                                                    <span class="date">April 12, 2018 06:50</span>
                                                                </div>
                                                            </div>
                                                            <div class="notifi__item">
                                                                <div class="bg-c2 img-cir img-40">
                                                                    <i class="zmdi zmdi-account-box"></i>
                                                                </div>
                                                                <div class="content">
                                                                    <p>Your account has been blocked</p>
                                                                    <span class="date">April 12, 2018 06:50</span>
                                                                </div>
                                                            </div>
                                                            <div class="notifi__item">
                                                                <div class="bg-c3 img-cir img-40">
                                                                    <i class="zmdi zmdi-file-text"></i>
                                                                </div>
                                                                <div class="content">
                                                                    <p>You got a new file</p>
                                                                    <span class="date">April 12, 2018 06:50</span>
                                                                </div>
                                                            </div>
                                                            <div class="notifi__footer">
                                                                <a href="#">All notifications</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="account-wrap">
                                                    <div class="account-item clearfix js-item-menu">
                                                    
                                                        <div class="content">
                                                            <a class="js-acc-btn" href="#">{{Auth::user()->usuario}}</a>
                                                        </div>
                                                        <div class="account-dropdown js-dropdown">                                               
                                                            <div class="account-dropdown__footer">
                                                                
                                                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                                    <i class="zmdi zmdi-power"></i> Cerrar sesión
                                                                </a>
                                                            </div>
                                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                                {{ csrf_field() }}
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </header>
                            <!-- HEADER DESKTOP-->

                            <!-- MAIN CONTENT-->
                            <div class="main-content">
                                <div class="section__contentx section__content--p10">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-12">
                                            @yield('contenido')
                                                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END MAIN CONTENT-->
                            <!-- END PAGE CONTAINER-->                
                        </section>
                    </div>
                </div>

            </section>

            <footer class="app-footer">
                <span><a href="http://www.fractalagencia.com/">Fractal Agencia Digital</a> &copy; 2020</span>                
            </footer>


    </main>
    </div>
    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>  
    <script src="vendor/animsition/animsition.min.js"></script>  
    <!-- Main JS-->
    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>
    <script src="js/main.js"></script>
    
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"> </script>
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css"/>
    
    
     <!-- <script src="js/app.js"></script> -->

</body>

</html>
<!-- end document-->
