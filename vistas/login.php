<!doctype html>
<html class="fixed">
    <head>

        <!-- Basic -->
        <meta charset="UTF-8">

        <meta name="keywords" content="Alimentos Colombeia S.A.S" />
        <meta name="description" content="Ambrosia - Alimentos Colombeia S.A.S">
        <meta name="author" content="SomosClick S.A.S">

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <!-- Web Fonts  -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

        <!-- Vendor CSS -->
        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="assets/vendor/animate/animate.css">

        <link rel="stylesheet" href="assets/vendor/font-awesome/css/all.min.css" />
        <link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
        <link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

        <!-- Theme CSS -->
        <link rel="stylesheet" href="assets/css/theme.css" />

        <!-- Skin CSS -->
        <link rel="stylesheet" href="assets/css/skins/default.css" />

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="assets/css/custom.css">

        <!-- Head Libs -->
        <script src="assets/vendor/modernizr/modernizr.js"></script>

    </head>
    <body>
        <!-- start: page -->
        <section class="body-sign">
            <div class="center-sign">
                <a href="/" class="logo float-left">
                    <img src="assets/img/logo-colombeia.png" height="40" alt="ambrosia" />
                </a>

                <div class="panel card-sign">
                    <div class="card-title-sign mt-3 text-right">
                        <h2 class="title text-uppercase font-weight-bold m-0"><i class="fas fa-user mr-1"></i>Ambrosia 1.0</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <span><div id="mensaje"></div></span>
                            </div>
                        </div>
                        <form id="login-form">
                            <div class="form-group mb-3">
                                <label>Usuario</label>
                                <div class="input-group">
                                    <input name="username" type="text" name="username" class="form-control form-control-lg" autocomplete="username" />
                                    <span class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="clearfix">
                                    <label class="float-left">Clave</label>
                                </div>
                                <div class="input-group">
                                    <input name="pw" type="password" class="form-control form-control-lg" autocomplete="current-password" />
                                    <span class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button id="loginbutton" type="submit" onclick="loginform();" class="btn btn-primary hidden-xs"><i class="fas fa-sign-in-alt"></i> Entrar</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                <p class="text-center text-muted mt-3 mb-3">&copy; Copyright <?php echo date('Y') ?>. All Rights Reserved.</p>
            </div>
        </section>
        <!-- end: page -->

        <!-- Vendor -->
        <script src="assets/vendor/jquery/jquery.js"></script>
        <script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
        <script src="assets/vendor/popper/umd/popper.min.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
        <script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="assets/vendor/common/common.js"></script>
        <script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
        <script src="assets/vendor/magnific-popup/jquery.magnific-popup.js"></script>
        <script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
        
        <!-- Theme Base, Components and Settings -->
        <script src="assets/js/theme.js<?php time() ?>"></script>
        
        <!-- Theme Custom -->
        <script src="assets/js/custom.js?<?php time() ?>"></script>
        
        <!-- Theme Initialization Files -->
        <script src="assets/js/theme.init.js<?php time() ?>"></script>

    </body>
</html>