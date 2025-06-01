<?php
    require_once("config/conexion.php");
    if(isset($_POST["enviar"]) and $_POST["enviar"]=="si"){
        require_once("models/Usuario.php");
        $usuario = new Usuario();
        $usuario->login();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Registro de Visitas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="./public/assets/images/favicon.ico">

    <!-- Icons css -->
    <link href="./public/assets/libs/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
    <link href="./public/assets/libs/dripicons/webfont/webfont.css" rel="stylesheet" type="text/css" />
    <link href="./public/assets/libs/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <!-- build:css -->
    <link href="./public/assets/css/app.css" rel="stylesheet" type="text/css" />
    <!-- endbuild -->

</head>

<body class="bg-account-pages">

    <!-- Login -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <div class="wrapper-page">
                        <div class="account-pages">
                            <div class="account-box">

                                <!-- Logo box-->
                                <div class="account-logo-box">
                                    <h2 class="text-uppercase text-center">
                                        <a href="index.html" class="text-success">
                                            <span><img src="./public/assets/images/logo2.png" alt="" height="200"
                                                    width="200"></span>
                                        </a>
                                    </h2>
                                </div>

                                <div class="account-content">
                                    <form action="" method="post" id="login_form">
                                    <input type="hidden" id="rol_id" name="rol_id" value="2">
                                    <div class="form-group mb-3 text-center text-uppercase">
                                            <label for="" class="font-weight-medium" id="lbltitulo">Ingreso de Administrador</label>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="emailaddress" class="font-weight-medium">Usuario</label>
                                            <input class="form-control" type="text" id="usu_correo" name="usu_correo"
                                                required="" placeholder="Ingrese su usuario">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="password" class="font-weight-medium">Contraseña</label>
                                            <input class="form-control" type="password" id="usu_pass" name="usu_pass" required="" 
                                                placeholder="Ingrese Contraseña">
                                        </div>
                                        
                                        <div class="form-group mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <!-- Checkbox -->
                                                <div class="form-check mb-0">
                                                    <a href="#" id="btnadmin">
                                                        Supervisor
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row text-center">
                                            <div class="col-12">
                                                <input type="hidden" name="enviar" class="form-control" value="si">
                                                <button class="btn btn-block btn-primary waves-effect waves-light"
                                                    type="submit">Ingresar</button>
                                            </div>
                                        </div>
                                    </form> <!-- end form -->

                                </div> <!-- end account-content -->

                            </div> <!-- end account-box -->
                        </div>
                        <!-- end account-page-->
                    </div>
                    <!-- end wrapper-page -->

                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- END HOME -->

    <!-- jQuery  -->
    <script src="./public/assets/libs/jquery/jquery.min.js"></script>
    <script src="./public/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./public/assets/libs/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="./public/assets/libs/metismenu/metisMenu.min.js"></script>
    <script type="text/javascript" src="./public/assets/libs/match-height/jquery.matchHeight.min.js"></script>
   

    <!-- App js -->
    <script src="./public/assets/js/jquery.core.js"></script>
    <script src="./public/assets/js/jquery.app.js"></script>
    <script>
    $(function() {
        $('.page-center').matchHeight({
            target: $('html')
        });

        $(window).resize(function() {
            setTimeout(function() {
                $('.page-center').matchHeight({
                    remove: true
                });
                $('.page-center').matchHeight({
                    target: $('html')
                });
            }, 100);
        });
    });
    </script>
    <script type="text/javascript" src="index.js"></script>
    

</body>

</html>