<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header('Content-Type: application/json');

require_once("../config/conexion.php");
require_once("../models/Reporte.php"); // Asegúrate que la ruta sea correcta
$reporte = new Reporte();

// Obtener la operación solicitada
$op = $_GET["op"] ?? null;

switch($op){

    case "listar_filtrado":
        // Recoger parámetros de DataTables y filtros personalizados
        $draw = isset($_POST["draw"]) ? intval($_POST["draw"]) : 0;
        $start = isset($_POST["start"]) ? intval($_POST["start"]) : 0;
        $length = isset($_POST["length"]) ? intval($_POST["length"]) : 10; // Default a 10 registros
        $orderColumnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 2; // Default a columna 'Entrada'
        $orderDir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'desc'; // Default a 'desc'
        
        // Mapeo de índices de columna DataTables a nombres de columna SQL
        // Asegúrate que coincidan con el orden en `asistencia.js` y la consulta SQL
        $columns = [
            0 => 'a.id_as',
            1 => 'e.nombre',
            2 => 'a.hora_entrada',
            3 => 'a.hora_salida',
            4 => 'a.ubicacion',
            5 => null, // Foto no ordenable
            6 => 'a.tardanza',
            7 => 'a.horas_trabajadas',
            8 => 'a.horas_extras',
            9 => 'a.est'
        ];
        $orderColumn = $columns[$orderColumnIndex] ?? 'a.hora_entrada'; // Columna por defecto si el índice no es válido
        if ($orderColumn === null) { // Si la columna no es ordenable
             $orderColumn = 'a.hora_entrada'; // Usar columna por defecto
             $orderDir = 'desc';
        }

        // Recoger filtros personalizados
        $filtros = [
            'id_empleado' => $_POST['id_empleado'] ?? null,
            'tardanza' => $_POST['tardanza'] ?? null,
            'horas_extras' => $_POST['horas_extras'] ?? null,
            'horas_trabajadas' => $_POST['horas_trabajadas'] ?? null,
            'fecha_inicio' => $_POST['fecha_inicio'] ?? null,
            'fecha_fin' => $_POST['fecha_fin'] ?? null,
            'periodicidad' => $_POST['periodicidad'] ?? null // Recibido pero no usado para agrupar inicialmente
        ];

        // Limpiar filtros vacíos
        foreach ($filtros as $key => $value) {
            if ($value === '' || $value === null) {
                unset($filtros[$key]);
            }
        }

        // Obtener datos filtrados y paginados
        $datos = $reporte->get_asistencia_filtrada($start, $length, $orderColumn, $orderDir, $filtros);
        $totalRegistros = $reporte->get_total_asistencia(); // Total sin filtrar
        $totalRegistrosFiltrados = $reporte->get_total_asistencia_filtrada($filtros); // Total con filtros aplicados

        // Preparar respuesta para DataTables
        $output = [
            "draw" => $draw,
            "recordsTotal" => $totalRegistros,
            "recordsFiltered" => $totalRegistrosFiltrados,
            "data" => $datos
        ];

        echo json_encode($output);
        break;

   

    case "GetId":
        if(isset($_POST["id_as"])){
            $datos=$reporte->get_asistencia_x_id($_POST["id_as"]);
            echo json_encode($datos);
        } else {
            echo json_encode(array("error" => "El ID de asistencia es requerido."));
        }
    break;


    default:
        echo json_encode(array("error" => "Operación no válida."));
    break;
}
?>
