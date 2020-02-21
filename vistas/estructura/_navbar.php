    <div class="inner-wrapper">
        <!-- start: sidebar -->
        <aside id="sidebar-left" class="sidebar-left">
        
            <div class="sidebar-header">
                <div class="sidebar-title">
                    Navegación
                </div>
                <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                    <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
                </div>
            </div>
        
            <div class="nano">
                <div class="nano-content">
                    <nav id="menu" class="nav-main" role="navigation">
                    
                        <ul class="nav nav-main">
                            <li>
                                <a class="nav-link" href="?inicio">
                                    <i class="fas fa-home" aria-hidden="true"></i>
                                    <span>Home</span>
                                </a>                        
                            </li>
                            <li class="nav-parent">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-columns" aria-hidden="true"></i>
                                    <span>Clientes</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li>
                                        <a class="nav-link" href="?nuevo_cliente">
                                            Nuevo Cliente
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="?pedidos">
                                            Pedidos
                                        </a>
                                    </li>
                                    <!-- <li class="nav-parent">
                                        <a>
                                            Boxed
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a class="nav-link" href="layouts-boxed.html">
                                                    Static Header
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="layouts-boxed-fixed-header.html">
                                                    Fixed Header
                                                </a>
                                            </li>
                                        </ul>
                                    </li> -->
                                </ul>
                            </li>
                            <li class="nav-parent">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-industry" aria-hidden="true"></i>
                                    <span>Producción</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li>
                                        <a class="nav-link" href="?produccion">
                                            Producción y Lotes
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="?materias_primas">
                                            Ingreso Materias Primas
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="nav-link" href="?inventario">
                                    <i class="fas fa-warehouse" aria-hidden="true"></i>
                                    <span>Bodega</span>
                                </a>                        
                            </li>
                            <li>
                                <a class="nav-link" href="?despacho">
                                    <i class="fas fa-truck-loading" aria-hidden="true"></i>
                                    <span>Despacho</span>
                                </a>                        
                            </li>
                        </ul>
                    </nav>
        
                </div>
        
                <script>
                    // Maintain Scroll Position
                    if (typeof localStorage !== 'undefined') {
                        if (localStorage.getItem('sidebar-left-position') !== null) {
                            var initialPosition = localStorage.getItem('sidebar-left-position'),
                                sidebarLeft = document.querySelector('#sidebar-left .nano-content');
                            
                            sidebarLeft.scrollTop = initialPosition;
                        }
                    }
                </script>
                
        
            </div>
        
        </aside>
        <!-- end: sidebar -->

        <section role="main" class="content-body">
            <header class="page-header">
                <h2><?=isset($this->titulo_modulo) ? $this->titulo_modulo : ''?></h2>
            
                <div class="right-wrapper text-right">
                    <ol class="breadcrumbs">
                        <li>
                            <a href="?inicio">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li><span><?=$this->titulo_anterior?></span></li>
                        <li><span><?=isset($this->titulo_modulo) ? $this->titulo_modulo : ''?></span></li>
                    </ol>
            
                    <span class="sidebar-right-toggle"></span>
                </div>
            </header>

            <!-- start: page -->
            <?php $this->Vista()?>
            <!-- end: page -->
        </section>
    </div>

