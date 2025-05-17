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
require_once("../models/Asistencia.php");
$asistencia = new Asistencia();

switch($_GET["op"]){
    case "GetAll":
        $datos=$asistencia->get_asistencia();
        echo json_encode($datos);
    break;

    case "GetId":
        if(isset($_POST["id_as"])){
            $datos=$asistencia->get_asistencia_x_id($_POST["id_as"]);
            echo json_encode($datos);
        } else {
            echo json_encode(array("error" => "El ID de asistencia es requerido."));
        }
    break;

    case "registrarAsistencia":
        $dni = isset($_POST['dni']) ? $_POST['dni'] : null;
        $ubicacion = isset($_POST['ubicacion']) ? $_POST['ubicacion'] : null;
        $foto = null;

        if ($dni === null || $ubicacion === null ) {
            echo json_encode(array("error" => "El DNI, la ubicación y el local son requeridos."));
            return;
        }

        $empleado = $asistencia->obtenerEmpleadoPorDNI($dni);

        if (!$empleado) {
            http_response_code(404);
            echo json_encode(array("error" => "Empleado con DNI {$dni} no encontrado."));
            return;
        }

        $tieneEntradaActivaHoy = $asistencia->tieneEntradaHoy($empleado["idEmpleado"]);
        $tieneSalidaPendienteAyer = $asistencia->tieneEntradaActiva($empleado["idEmpleado"]); // Verifica si hay alguna entrada activa (de ayer o hoy)

        // **Photo upload logic moved after successful employee validation**
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = date("YmdHis") . "_" . basename($_FILES['foto']['name']);
            $rutaDestino = '../public/uploads/' . $nombreArchivo;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
                $foto = 'uploads/' . $nombreArchivo;
            } else {
                echo json_encode(array("error" => "Error al guardar la foto."));
                return;
            }
        } elseif (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
            // Handle other upload errors if needed
            echo json_encode(array("error" => "Error en la carga de la foto. Código: " . $_FILES['foto']['error']));
            return;
        }

        if ($tieneSalidaPendienteAyer && !$tieneEntradaActivaHoy) {
            // Tiene una entrada pendiente (posiblemente de ayer) y no ha marcado entrada hoy, registrar entrada
            $asistenciaId = $asistencia->crearAsistencia($empleado["idEmpleado"], $local_id, $ubicacion, $foto);
            $asistenciaRegistrada = $asistencia->obtenerAsistenciaPorId($asistenciaId);
            echo json_encode(array("message" => "Entrada registrada correctamente", "tipo" => "entrada", "hora_entrada" => $asistenciaRegistrada['horaEntrada']));
        } elseif ($tieneEntradaActivaHoy) {
            // Ya marcó entrada hoy, intentar registrar salida
            $affectedRows = $asistencia->registrarSalida($empleado["idEmpleado"]);
            if ($affectedRows > 0) {
                $asistenciaActualizada = $asistencia->obtenerAsistenciaActivaPorEmpleado($empleado["idEmpleado"]);
                echo json_encode(array("message" => "Salida registrada correctamente", "tipo" => "salida", "hora_salida" => $asistenciaActualizada['horaSalida']));
            } else {
                echo json_encode(array("message" => "No se encontró un registro de entrada activo para registrar la salida."));
            }
        } else {
            // No tiene entrada activa hoy, registrar entrada
            $asistenciaId = $asistencia->crearAsistencia($empleado["idEmpleado"], $ubicacion, $foto);
            $asistenciaRegistrada = $asistencia->obtenerAsistenciaPorId($asistenciaId);
            echo json_encode(array("message" => "Entrada registrada correctamente", "tipo" => "entrada", "hora_entrada" => $asistenciaRegistrada['horaEntrada']));
        }
    break;
}
?>