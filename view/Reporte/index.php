<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
    <title>Asistencia - Filtros y Reportes</title>
    <!-- Include datepicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <style>
        /* Ajustes menores para espaciado de filtros */
        #formFiltros .form-group {
            margin-bottom: 15px; /* Aumentar un poco el margen inferior */
        }
        .datepicker-input {
            cursor: pointer;
        }
    </style>
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
                            <h3>Reporte de Asistencia</h3>
                            <ol class="breadcrumb breadcrumb-simple">
                                <li><a href="#">Home</a></li>
                                <li class="active">Asistencia</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </header>

            <div class="box-typical box-typical-padding">

                <!-- Sección de Filtros -->
                <form id="formFiltros">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filtro_id_empleado">ID Empleado:</label>
                                <input type="text" class="form-control" id="filtro_id_empleado" name="filtro_id_empleado" placeholder="Ingrese ID">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filtro_tardanza">Tardanza:</label>
                                <select class="form-control" id="filtro_tardanza" name="filtro_tardanza">
                                    <option value="">Todos</option>
                                    <option value="con">Con Tardanza</option>
                                    <option value="sin">Sin Tardanza (Puntual)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filtro_horas_extras">Horas Extras:</label>
                                <select class="form-control" id="filtro_horas_extras" name="filtro_horas_extras">
                                    <option value="">Todos</option>
                                    <option value="con">Con Horas Extras</option>
                                    <option value="sin">Sin Horas Extras</option>
                                </select>
                            </div>
                        </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label for="filtro_horas_trabajadas">Horas Trabajadas (min):</label>
                                 <input type="number" class="form-control" id="filtro_horas_trabajadas" name="filtro_horas_trabajadas" placeholder="Mínimo de horas" min="0">
                             </div>
                         </div>
                    </div>
                    <!-- Nueva fila para filtros de fecha y periodicidad -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filtro_fecha_inicio">Fecha Inicio:</label>
                                <input type="text" class="form-control datepicker-input" id="filtro_fecha_inicio" name="filtro_fecha_inicio" placeholder="YYYY-MM-DD" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filtro_fecha_fin">Fecha Fin:</label>
                                <input type="text" class="form-control datepicker-input" id="filtro_fecha_fin" name="filtro_fecha_fin" placeholder="YYYY-MM-DD" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filtro_periodicidad">Periodicidad:</label>
                                <select class="form-control" id="filtro_periodicidad" name="filtro_periodicidad">
                                    <option value="">Seleccionar (Opcional)</option>
                                    <option value="dia">Por Día</option>
                                    <option value="mes">Por Mes</option>
                                    <option value="anio">Por Año</option>
                                </select>
                                <small class="text-muted">Agrupa resultados por periodo</small>
                            </div>
                        </div>
                        <div class="col-md-3 align-self-end"> <!-- Alinea el botón al final -->
                             <div class="form-group text-right"> <!-- Mueve botones a la derecha -->
                                 <button type="button" id="btnFiltrar" class="btn btn-primary"><i class="fa fa-filter"></i> Filtrar</button>
                                 <button type="button" id="btnLimpiar" class="btn btn-default"><i class="fa fa-eraser"></i> Limpiar</button>
                             </div>
                         </div>
                    </div>
                </form>
                <!-- Fin Sección de Filtros -->

                <hr>

                <table id="datatable-asistencia" class="table table-bordered table-striped table-vcenter js-dataTable-full" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">ID</th>
                            <th class="text-center" style="width: 15%;">Empleado</th>
                            <th class="text-center" style="width: 10%;">Entrada</th>
                            <th class="text-center" style="width: 10%;">Salida</th>
                            <th class="text-center" style="width: 15%;">Ubicación</th>
                            <th class="text-center" style="width: 10%;">Foto</th>
                            <th class="text-center" style="width: 10%;">Tardanza</th>
                            <th class="text-center" style="width: 10%;">H. Trab.</th>
                            <th class="text-center" style="width: 10%;">H. Extras</th>
                            <th class="text-center" style="width: 5%;">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Datos cargados por DataTables -->
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <!-- Contenido -->

    <!-- Footer -->
    <?php require_once("../MainFooter/footer.php");?>

    <?php require_once("../MainJs/index.php");?>

    <!-- Include datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.es.min.js"></script>

    <script type="text/javascript" src="index.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>

