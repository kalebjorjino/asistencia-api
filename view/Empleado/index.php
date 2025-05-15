<?php
require_once("../../config/conexion.php");
if(isset($_SESSION["usu_id"])){
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Listado de Asistencia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <?php require_once("../MainHead/head.php");?>
</head>
<div id="wrapper">
    <?php require_once("../MainHeader/header.php");?>
    <?php require_once("../MainSidebar/sidebar.php");?>
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 py-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable-buttons"
                                           class="table table-striped table-bordered dt-responsive nowrap">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">DNI</th>
                                                <th scope="col">Empleado</th>
                                                <th scope="col">Locales</th>
                                                <th scope="col">Entrada</th>
                                                <th scope="col">Salida</th>
                                                <th scope="col">Ubicación</th>
                                                <th scope="col">Foto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div> </div> </div>
    <?php require_once("../MainFooter/footer.php");?>
    </div>
</div>
<?php require_once("../MainJs/index.php");?>
<script type="text/javascript" src="empleado.js"></script>
<?php
} else {
    header("Location:".Conectar::ruta()."index.php");
}
?>