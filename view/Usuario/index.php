<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Registro de Usuario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php require_once("../MainHead/head.php");?>

</head>

<div id="wrapper">
    <!-- Navigation Bar-->
    <?php require_once("../MainHeader/header.php");?>

    <!-- End Navigation Bar-->

    <!-- ========== Left Sidebar Start ========== -->
    <?php require_once("../MainSidebar/sidebar.php");?>
    <!-- Left Sidebar End -->

    <!-- Page Content Start -->
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">

                <!-- Page title box -->
                <div class="page-title-box">
                    <h4 class="page-title text-uppercase">Registro de usuarios</h4>
                </div>
                <!-- End page title box -->

                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <div class="text-muted font-13 m-b-30">
                                <button type="button" id="btnnuevo" class="btn btn-inline text-white" style="background-color: #125687;">Nuevo
                                    Usuario</button>
                            </div>

                            <table id="datatable-buttons"
                                class="table table-striped table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>Nombre Completos</th>
                                        <th>Usuario</th>
                                        <th>Contraseña</th>
                                        <th>Estado</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div> <!-- end container-fluid-->
        </div> <!-- end contant-->
    </div>
    <!-- End Page Content-->

    <!-- Footer -->
    <?php require_once("../MainFooter/footer.php");?>

    <!-- End Footer -->
</div>
</div>
<!-- End #wrapper -->
<?php require_once("modalUsuario.php");?>


<?php require_once("../MainJs/index.php");?>
<script src="../public/assets/libs/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="usuario.js"></script>





<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>