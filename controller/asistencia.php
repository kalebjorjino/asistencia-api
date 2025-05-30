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
    $dni = $_POST['dni'] ?? null;
    $ubicacion = $_POST['ubicacion'] ?? null;
    $foto = null;

    if ($dni === null || $ubicacion === null) {
        echo json_encode(array("error" => "El DNI y la ubicación son requeridos."));
        return;
    }

    $empleado = $asistencia->obtenerEmpleadoPorDNI($dni);

    if (!$empleado) {
        http_response_code(404);
        echo json_encode(array("error" => "Empleado con DNI {$dni} no encontrado."));
        return;
    }

    // Manejo de foto
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
        echo json_encode(array("error" => "Error en la carga de la foto. Código: " . $_FILES['foto']['error']));
        return;
    }

    $empleadoId = $empleado["idEmpleado"];
    $tieneEntradaActivaHoy = $asistencia->tieneEntradaHoy($empleadoId);
    $tieneSalidaPendiente = $asistencia->tieneEntradaActiva($empleadoId);

    // Envolver la lógica de registro en un try-catch para manejar excepciones (ej. sin horario)
    try {
        if ($tieneSalidaPendiente && !$tieneEntradaActivaHoy) {
            $asistenciaId = $asistencia->crearAsistencia($empleadoId, $ubicacion, $foto);
            $asistenciaRegistrada = $asistencia->obtenerAsistenciaPorId($asistenciaId);
            $horaEntrada = $asistenciaRegistrada['hora_entrada'] ?? null;
            echo json_encode(array("message" => "Entrada registrada correctamente", "tipo" => "entrada", "hora_entrada" => $horaEntrada));
        } elseif ($tieneEntradaActivaHoy) {
            $affectedRows = $asistencia->registrarSalida($empleadoId);
            if ($affectedRows > 0) {
                $asistenciaActualizada = $asistencia->obtenerAsistenciaActivaPorEmpleado($empleadoId);
                $horaSalida = $asistenciaActualizada['hora_salida'] ?? null;
                echo json_encode(array("message" => "Salida registrada correctamente", "tipo" => "salida", "hora_salida" => $horaSalida));
            } else {
                // Este caso podría necesitar revisión, quizás devolver un error si no se actualiza
                http_response_code(500);
                echo json_encode(array("error" => "No se pudo registrar la salida."));
            }
        } else {
            // Primera entrada del día
            $asistenciaId = $asistencia->crearAsistencia($empleadoId, $ubicacion, $foto);
            $asistenciaRegistrada = $asistencia->obtenerAsistenciaPorId($asistenciaId);
            $horaEntrada = $asistenciaRegistrada['hora_entrada'] ?? null;
            echo json_encode(array("message" => "Entrada registrada correctamente", "tipo" => "entrada", "hora_entrada" => $horaEntrada));
        }
    } catch (Exception $e) {
        // Capturar excepciones específicas o genéricas
        if ($e->getCode() == 400) { // Código 400 para "Sin Horario"
            http_response_code(400);
            echo json_encode(array("error" => $e->getMessage())); // Usar el mensaje de la excepción
        } else {
            // Otro tipo de error durante el registro
            http_response_code(500);
            error_log("Error en registrarAsistencia: " . $e->getMessage()); // Loguear el error real
            echo json_encode(array("error" => "Error interno al procesar la asistencia."));
        }
    }
break;
}
?>