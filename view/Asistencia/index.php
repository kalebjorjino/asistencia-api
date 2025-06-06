<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<title>Asistencia</title>
</head>
<body class="with-side-menu">

<!-- Campos ocultos para pasar variables de sesi��n a JS -->
    <input type="hidden" id="user_idx" value="<?php echo $_SESSION['usu_id']; ?>">
    <input type="hidden" id="rol_idx" value="<?php echo $_SESSION['rol_id']; ?>">

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
							<h3>Asistencia</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Asistencia</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				<table id="datatable-buttons" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
							
                                                <th class="text-center" style="width: 5%;">ID</th>
                                                <th class="text-center" style="width: 5%;">Empleado</th>
                                                <th class="text-center" style="width: 5%;">Entrada</th>
                                                <th class="text-center" style="width: 5%;">Salida</th>
                                                <th class="text-center" style="width: 5%;">Ubicaci��n</th>
                                                <th class="text-center" style="width: 5%;">Foto</th>
												<th class="text-center" style="width: 5%;">Tardanzas</th>
												<th class="text-center" style="width: 5%;">Horas Trabajadas</th>
												<th class="text-center" style="width: 5%;">Horas_Extras</th>
												
												<th class="text-center" style="width: 5%;">Estado</th>
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

	<?php require_once("../MainJs/index.php");?>
	
	<script type="text/javascript" src="asistencia.js"></script>


</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>