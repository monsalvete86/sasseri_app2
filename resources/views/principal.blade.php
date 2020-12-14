

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
        <div class="page-wrapper">
            <!-- HEADER MOBILE-->
            <header class="header-mobile d-block d-lg-none">
                <div class="header-mobile__bar">
                    <div class="container-fluid">
                        <div class="header-mobile-inner">
                            <a class="logo" href="index.html">
                                <img src="images/icon/logo.png" alt="Sasseri" />
                            </a>
                            <button class="hamburger hamburger--slider" type="button">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <nav class="navbar-mobile">
                    <div class="container-fluid">
                        <ul class="navbar-mobile__list list-unstyled">
                            <li class="has-sub">
                                <a class="js-arrow" href="#">
                                    <i class="fa fa-tachometer-alt"></i>Dashboard</a>
                                <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                    <li>
                                        <a href="index.html">Dashboard 1</a>
                                    </li>
                                    <li>
                                        <a href="index2.html">Dashboard 2</a>
                                    </li>
                                    <li>
                                        <a href="index3.html">Dashboard 3</a>
                                    </li>
                                    <li>
                                        <a href="index4.html">Dashboard 4</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="chart.html">
                                    <i class="fa fa-chart-bar"></i>Charts</a>
                            </li>
                            <li>
                                <a href="table.html">
                                    <i class="fa fa-table"></i>Tables</a>
                            </li>
                            <li>
                                <a href="form.html">
                                    <i class="far fa-check-square"></i>Forms</a>
                            </li>
                            <li>
                                <a href="calendar.html">
                                    <i class="fa fa-calendar-alt"></i>Calendar</a>
                            </li>
                            <li>
                                <a href="map.html">
                                    <i class="fa fa-map-marker-alt"></i>Maps</a>
                            </li>
                            <li class="has-sub">
                                <a class="js-arrow" href="#">
                                    <i class="fa fa-copy"></i>Pages</a>
                                <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                    <li>
                                        <a href="login.html">Login</a>
                                    </li>
                                    <li>
                                        <a href="register.html">Register</a>
                                    </li>
                                    <li>
                                        <a href="forget-pass.html">Forget Password</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub">
                                <a class="js-arrow" href="#">
                                    <i class="fa fa-desktop"></i>UI Elements</a>
                                <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                    <li>
                                        <a href="button.html">Button</a>
                                    </li>
                                    <li>
                                        <a href="badge.html">Badges</a>
                                    </li>
                                    <li>
                                        <a href="tab.html">Tabs</a>
                                    </li>
                                    <li>
                                        <a href="card.html">Cards</a>
                                    </li>
                                    <li>
                                        <a href="alert.html">Alerts</a>
                                    </li>
                                    <li>
                                        <a href="progress-bar.html">Progress Bars</a>
                                    </li>
                                    <li>
                                        <a href="modal.html">Modals</a>
                                    </li>
                                    <li>
                                        <a href="switch.html">Switchs</a>
                                    </li>
                                    <li>
                                        <a href="grid.html">Grids</a>
                                    </li>
                                    <li>
                                        <a href="fontawesome.html">Fontawesome Icon</a>
                                    </li>
                                    <li>
                                        <a href="typo.html">Typography</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- END HEADER MOBILE-->

            <!-- MENU SIDEBAR-->
            <aside class="menu-sidebar d-none d-lg-block">
                <div class="logo">
                    <a href="#">
                        <img src="img/logo.png" alt="Sasseri" />
                    </a>
                </div>
                <div class="menu-sidebar__content js-scrollbar1">
                    <nav class="navbar-sidebar">
                       <ul class="list-unstyled navbar__list">
                            <li @click="menu=999991" class="nav-item">
                                <a href="#"><i class="icon-user"></i> Usuarios</a>
                            </li>
                            <li @click="menu=10" class="nav-item">
                                <a href="#"><i class="icon-user"></i> Terceros</a>
                            </li>
                            <li @click="menu=40" class="nav-item">
                                <a href="#"><i class="icon-user"></i> Punto de venta</a>
                            </li>
                            <li @click="menu=14" class="nav-item">
                                <a href="#"><i class="icon-user"></i> Facturación</a>
                            </li>
                            <li class="has-sub">
                                <a class="js-arrow" href="#">
                                    <i class="fas fa-tachometer-alt"></i>Configuración</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li @click="menu=6" class="nav-item">
                                        <a href="#"><i class="icon-user"></i> Empresa</a>
                                    </li>
                                    <li @click="menu=12" class="nav-item">
                                        <a href="#"><i class="icon-user"></i> Mesas</a>
                                    </li>
                                    <li @click="menu=27" class="nav-item">
                                        <a href="#"><i class="icon-user"></i> IVAs</a>
                                    </li>
                                    <li @click="menu=29" class="nav-item">
                                        <a href="#"><i class="icon-user"></i> Cajas</a>
                                    </li>

                                </ul>
                            </li>
                            <li class="has-sub">
                                <a class="js-arrow" href="#">
                                    <i class="fas fa-tachometer-alt"></i>Almacén
                                </a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li @click="menu=15" class="nav-item">
                                        <a href="#"><i class="icon-user"></i> Articulo</a>
                                    </li>
                                    <li @click="menu=17" class="nav-item">
                                        <a href="#"><i class="icon-user"></i> Entradas</a>
                                    </li>
                                    <li @click="menu=18" class="nav-item">
                                        <a href="#"><i class="icon-user"></i> Salidas</a>
                                    </li>
                                    <li @click="menu=19" class="nav-item">
                                        <a href="#"><i class="icon-user"></i> Stock</a>
                                    </li>
                                    <li @click="menu=22" class="nav-item">
                                        <a href="#"><i class="icon-user"></i> Presentación</a>
                                    </li>
                                    <li @click="menu=23" class="nav-item">
                                        <a href="#"><i class="icon-user"></i> Unidad de medida</a>
                                    </li>
                                    <li @click="menu=24" class="nav-item">
                                        <a href="#"><i class="icon-user"></i> Concentración</a>
                                    </li>
                                    <li @click="menu=25" class="nav-item">
                                        <a href="#"><i class="icon-user"></i> Categoría</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub">
                                <a class="js-arrow" href="#">
                                    <i class="fas fa-tachometer-alt"></i>Cajas
                                </a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li @click="menu=35" class="nav-item">
                                        <a href="#"><i class="icon-user"></i> Gestión de cajas</a>
                                    </li>
                                    <li @click="menu=30" class="nav-item">
                                        <a href="#"><i class="icon-user"></i> Cierre de caja</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub">
                                <a class="js-arrow" href="#">
                                    <i class="fas fa-tachometer-alt"></i>Cartera
                                </a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li @click="menu=33" class="nav-item">
                                        <a href="#"><i class="icon-user"></i> Cuentas por cobrar</a>
                                    </li>
                                    <li @click="menu=34" class="nav-item">
                                        <a href="#"><i class="icon-user"></i> Cuentas por pagar</a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </nav>
                </div>
            </aside>
            <!-- END MENU SIDEBAR-->

            <!-- PAGE CONTAINER-->
            <div class="page-container">
                <!-- HEADER DESKTOP-->
                <header class="header-desktop">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="header-wrap">                                
                                <div class="header-button">
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
                    <div class="section__content section__content--p30">
                        <div>
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
                <footer class="app-footer">
                    <span><a href="http://www.fractalagencia.com/">Fractal Agencia Digital</a> &copy; 2020</span>
                    <span class="ml-auto">Desarrollado por <a href="http://www.fractalagencia.com/">Fractal Agencia Digital</a></span>
                </footer>
            </div>

        </div>
    </div>
    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>  
    <script src="vendor/animsition/animsition.min.js"></script>  
    <!-- Main JS-->
    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>
    <script src="js/main.js"></script>
    
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js">
    </script>
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css"/>
    
    
     <!-- <script src="js/app.js"></script> -->

</body>

</html>
<!-- end document-->
