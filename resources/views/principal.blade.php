<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Software financiero y contable online">
        <meta name="author" content="fractalagenciadigital.com">
        <meta name="keyword" content="Software financiero y contable online">
        <link rel="shortcut icon" href="img/favicon.png">
        <title>Sasseri</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="css/plantilla.css" rel="stylesheet">
        <style>
        .btn-crea-factura {
            height: 34px;
        }
        </style>
    </head>
    <?php $rol_usu = Auth::user()->idrol; ?>
    <body id="page-top">
        <div id="app">
            <!-- Page Wrapper -->
            <div id="wrapper">
                <!-- Sidebar -->                
                @if($rol_usu==1)  
                    <ul class="navbar-nav bg-gradient-primaryx sidebar sidebar-darkx accordion" id="accordionSidebar">
                        <!-- Sidebar - Brand -->
                        <a class="sidebar-brand  d-sm-none d-md-block align-items-center justify-content-center" href="index.html" style="display:none;">
                            <img style="width:100%;" src="img/logo.png" alt="Sasseri" />
                        </a>                    
                        <div class="text-center d-none d-md-inline">
                            <button class="rounded-circle border-0" id="sidebarToggle"></button>
                        </div>
                        
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStock"
                            aria-expanded="true" aria-controls="collapseStock">
                                <i class="icon-bag"></i><span>Almacén</span>
                            </a>
                            <ul id="collapseStock" class="collapse" aria-labelledby="headingStock"
                            data-parent="#accordionSidebar">
                                <div class="collapse-inner">
                                    <li @click="menu=25" class="collapse-item">
                                        <a href="#" ><i class="fa fa-level-down"></i> Categoría</a>
                                    </li>
                                    <li @click="menu=15" class="collapse-item">
                                        <a href="#" ><i class="fa fa-table"></i></i> Articulo</a>
                                    </li>
                                    <li @click="menu=17" class="collapse-item">
                                        <a href="#" ><i class="fa fa-share"></i></i> Entradas</a>
                                    </li>
                                    <li @click="menu=18" class="collapse-item">
                                        <a href="#" ><i class="fa fa-reply"></i> Salidas</a>
                                    </li>
                                    <li @click="menu=19" class="collapse-item">
                                        <a href="#" ><i class="fa fa-archive"></i> Stock</a>
                                    </li>
                                    <li @click="menu=22" class="collapse-item">
                                        <a href="#" ><i class="fa fa-circle"></i> Presentación</a>
                                    </li>
                                    <li @click="menu=23" class="collapse-item">
                                        <a href="#" ><i class="fa fa-flask"></i> Unidad de medida</a>
                                    </li>
                                    <li @click="menu=24" class="collapse-item">
                                        <a href="#" ><i class="fa fa-tint"></i> Concentración</a>
                                    </li>
                                    
                                </div>
                            </ul>
                        </li>
                        <li @click="menu=40" class="nav-item">
                            <a href="#" class="nav-link"><i class="icon-screen-desktop"></i> <span>Punto de venta</span></a>
                        </li>
                        <li @click="menu=14" class="nav-item">
                            <a href="#" class="nav-link"><i class="icon-calculator"></i><span>Facturación</span> </a>
                        </li>
                        <li @click="menu=999991" class="nav-item">
                            <a href="#" class="nav-link"><i class="icon-user"></i> <span>Usuarios</span></a>
                        </li>
                        <li @click="menu=10" class="nav-item">
                            <a href="#" class="nav-link"><i class="icon-user"></i> <span>Terceros</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseConfig"
                            aria-expanded="true" aria-controls="collapseConfig" >
                                <i class="icon-wrench"></i>
                                <span>Configuración</span>
                            </a>
                            <ul  id="collapseConfig" class="collapse" aria-labelledby="headingConfig"
                            data-parent="#accordionSidebar">
                                <div class="collapse-inner">
                                    <li @click="menu=6" class="collapse-item">
                                        <a href="#"><i class="fa fa-building-o"></i> Empresa</a>
                                    </li>
                                    <li @click="menu=12" class="collapse-item">
                                        <a href="#"><i class="fa fa-cutlery"></i> Mesas</a>
                                    </li>
                                    <li @click="menu=27" class="collapse-item">
                                        <a href="#"><i class="fa fa-percent"></i> IVAs</a>
                                    </li>
                                    <li @click="menu=29" class="collapse-item">
                                        <a href="#">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-calculator" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M12 1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                                            <path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-4z"/>
                                        </svg>
                                        Cajas</a>
                                    </li>
                                </div>

                            </ul>
                        </li>
                        
                        <li class="nav-item">
                            <a 
                                class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCajas"
                                aria-expanded="true" aria-controls="collapseCajas"
                            >
                                <i class="icon-basket"></i>
                                <span> Cajas</span>                       
                            </a>
                            <ul 
                                id="collapseCajas" class="collapse" aria-labelledby="headingCajas" data-parent="#accordionSidebar"                   
                            >
                                <div class="collapse-inner">
                                    <li @click="menu=35" class="collapse-item">
                                        <a href="#"><i class="fa fa-list-ol"></i> Gestión de cajas</a>
                                    </li>
                                    <li @click="menu=30" class="collapse-item">
                                        <a href="#"><i class="fa fa-times-circle"></i> <span>Cierre de caja</span></a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCartera"
                            aria-expanded="true" aria-controls="collapseCartera">
                                <i class="icon-wallet"></i><span>Cartera</span>
                            </a>
                            <ul id="collapseCartera" class="collapse" aria-labelledby="headingCartera"
                            data-parent="#accordionSidebar">
                                <div class="collapse-inner">
                                    <li @click="menu=33" class="collapse-item">
                                        <a href="#"><i class="fa fa-money"></i> Cuentas por cobrar</a>
                                    </li>
                                    <li @click="menu=34" class="collapse-item">
                                        <a href="#"><i class="fa fa-money"></i> Cuentas por pagar</a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                @endif
                <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top">

                        <!-- Sidebar Toggle (Topbar) -->
                        @if($rol_usu==2)  
                            <input type="button" v-if="menu==0" class="btn btn-primary btn-crea-factura" value="Ir a Facturas" @click="menu=40">
                            <input type="button" v-if="menu==40" class="btn btn-primary btn-crea-factura" value="Inicio" @click="menu=0">
                        @endif
                        @if($rol_usu==1)  
                            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                                <i class="fa fa-bars"></i>
                            </button>
                        @endif
                        <!-- Topbar Navbar -->
                        <div class="p-1 text-center">
                            <a class="sidebar-brand  d-sm-none align-items-center justify-content-center" href="index.html">
                                <img style="width:70%;" src="img/logo.png" alt="Sasseri" />
                            </a>
                        </div>
                        <ul class="navbar-nav ml-auto">

                            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                            <li class="nav-item dropdown no-arrow d-sm-none">
                                
                                <!-- Dropdown - Messages -->
                                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                    aria-labelledby="searchDropdown">
                                    <!-- <form class="form-inline mr-auto w-100 navbar-search">
                                        <div class="input-group">
                                            <input type="text" class="form-control bg-light border-0 small"
                                                placeholder="Search for..." aria-label="Search"
                                                aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button">
                                                    <i class="fa fa-search fa-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form> -->
                                </div>
                            </li>

                            <!-- Nav Item - Alerts -->
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bell fa-fw"></i>
                                    <!-- Counter - Alerts -->
                                    <span class="badge badge-danger badge-counter">3+</span>
                                </a>
                                <!-- Dropdown - Alerts -->
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="alertsDropdown">
                                    <h6 class="dropdown-header">
                                        Alerts Center
                                    </h6>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-primary">
                                                <i class="fa fa-file-alt text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">December 12, 2019</div>
                                            <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-success">
                                                <i class="fa fa-donate text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">December 7, 2019</div>
                                            $290.29 has been deposited into your account!
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-warning">
                                                <i class="fa fa-exclamation-triangle text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">December 2, 2019</div>
                                            Spending Alert: We've noticed unusually high spending for your account.
                                        </div>
                                    </a>
                                    <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                                </div>
                            </li>

                            <!-- Nav Item - Messages -->    
                            <li class="nav-item dropdown no-arrow mx-1">
                                
                            </li>

                            <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline">{{Auth::user()->usuario}}</span>
                                    
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown">
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>

                        </ul>

                    </nav>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        @yield('contenido')
                        
                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Your Website 2020</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
            <!-- End of Page Wrapper -->

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fa fa-angle-up"></i>
            </a>
        </div>
    </div>
    
        <!-- Main JS-->
        <script src="js/app.js"></script>
        <script src="js/plantilla.js"></script>
        <!-- <script src="js/main.js"></script>     -->
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"> </script>

        <!-- <script src="js/demo/chart-area-demo.js"></script>
        <script src="js/demo/chart-pie-demo.js"></script> -->

    </body>

</html>