<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<title>AnderCode</>::Mantenimiento Usuario</title>
</head>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>

    <div class="mobile-menu-left-overlay"></div>
    
    <?php require_once("../MainSidebar/sidebar.php");?>

	<!-- Contenido -->
	<div class="page-content">
		<div class="container-fluid">
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Mantenimiento Usuario</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Mantenimiento Usuario</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				<button type="button" id="btnnuevo" class="btn btn-inline btn-primary">Nuevo Registro</button>
				<table id="datatable-buttons" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
							
                                        <th class="text-center" style="width: 5%;">Nombre Completos</th>
                                        <th class="text-center" style="width: 5%;">Usuario</th>
                                        <th class="text-center" style="width: 5%;">Contraseña</th>
                                        <th class="text-center" style="width: 5%;">Estado</th>
                                        <th class="text-center" style="width: 5%;"></th>
                                        <th class="text-center" style="width: 5%;"></th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>

		</div>
	</div>
	<!-- Contenido -->

    <!-- Footer -->
    <?php require_once("../MainFooter/footer.php");?>

    <!-- End Footer -->
</div>
</div>
<!-- End #wrapper -->
<?php require_once("modalUsuario.php");?>


<?php require_once("../MainJs/index.php");?>
<script type="text/javascript" src="usuario.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>