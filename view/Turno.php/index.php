<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<title>Turnos</title>
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
							<h3>Turnos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Turnos</li>
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
							                    <th class="text-center" style="width: 5%;">ID</th>
                                                <th class="text-center" style="width: 5%;">Nombre</th>
                                                <th class="text-center" style="width: 5%;">Hora Inicio</th>
                                                <th class="text-center" style="width: 5%;">Hora Fin</th>
                                                <th class="text-center" style="width: 5%;">Tolerancia (Hora Inicio)</th>
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

    <?php require_once("ModalTurno.php");?>

	<?php require_once("../MainJs/index.php");?>
	
	<script type="text/javascript" src="turno.js"></script>


</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>