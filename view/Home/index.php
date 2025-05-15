<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Registro de Asistencia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <?php require_once("../MainHead/head.php");?>

</head>

<body>

    <!-- Begin page -->
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

                  
           

                </div> <!-- end container-fluid-->
            </div> <!-- end contant-->
        </div>
        <!-- End Page Content-->


        <!-- Footer -->
        <?php require_once("../MainFooter/footer.php");?>

        <!-- End Footer -->
    </div>
    <!-- End #wrapper -->

    <?php require_once("../MainJs/index.php");?>
    <script type="text/javascript" src="home.js"></script>

</body>

</html>

<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>