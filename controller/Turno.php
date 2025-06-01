<?php
    require_once("../config/conexion.php");
    require_once("../models/Turno.php");
    $turno = new Turno();

    switch($_GET["op"]){

         case "combo":
            $datos = $turno->get_turno();
            if(is_array($datos)==true and count($datos)>0){
                // Asegurarse de que la salida sea válida incluso si no hay datos
                $html = "<option value=''>Selecciona</option>"; 
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['id_turno']."'>".$row['nombre']."</option>";
                }
                echo $html;
            } else {
                 echo "<option value=''>No hay turnos</option>"; // Mensaje si no hay turnos
            }
        break;
        

         case "guardaryeditar":
    $nombre = isset($_POST["nombre"]) ? html_entity_decode($_POST["nombre"]) : null;
    $hora_inicio = $_POST["hora_inicio"] ?? null;
    $hora_fin = $_POST["hora_fin"] ?? null;
    $tolerancia_minutos = $_POST["tolerancia_minutos"] ?? null;
    $id_turno = empty($_POST["id_turno"]) ? null : $_POST["id_turno"];

    if ($nombre === null || $hora_inicio === null || $hora_fin === null || $tolerancia_minutos === null) {
         echo json_encode(array("error" => "Todos los campos son requeridos."));
         exit();
    }
    
     // Validar que la tolerancia no sea negativa
    if ($tolerancia_minutos < 0) {
        http_response_code(400);
        echo json_encode(array("error" => "La tolerancia no debe ser negativa."));
        exit();
    }

    // Validar nombre duplicado
    if ($turno->nombre_existe($nombre, $id_turno)) {
        echo json_encode(array("error" => "Ya existe un turno con ese nombre."));
        exit();
    }

    try {
        if($id_turno === null){       
            $resultado = $turno->insert_turno($nombre, $hora_inicio, $hora_fin, $tolerancia_minutos);     
            echo json_encode(array("success" => "Turno creado correctamente.", "id" => $resultado));
        }
        else {
            $resultado = $turno->update_turno($id_turno, $nombre, $hora_inicio, $hora_fin, $tolerancia_minutos);
            if ($resultado > 0) {
                echo json_encode(array("success" => "Turno actualizado correctamente."));
            } else {
                echo json_encode(array("info" => "No se realizaron cambios en el turno.")); 
            }
        }
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(array("error" => $e->getMessage()));
    }
break;


        case "listar":
            $datos=$turno->get_turno();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                // Asegurarse de escapar la salida para prevenir XSS si se muestra directamente en HTML
                $sub_array[] = htmlspecialchars($row["id_turno"], ENT_QUOTES, 'UTF-8');
                $sub_array[] = htmlspecialchars($row["nombre"], ENT_QUOTES, 'UTF-8');
                $sub_array[] = htmlspecialchars($row["hora_inicio"], ENT_QUOTES, 'UTF-8');
                $sub_array[] = htmlspecialchars($row["hora_fin"], ENT_QUOTES, 'UTF-8');
                $sub_array[] = htmlspecialchars($row["tolerancia_minutos"], ENT_QUOTES, 'UTF-8');
                // Usar comillas simples para los atributos onClick para evitar conflictos
                $sub_array[] = '<button type="button" onClick="editar('.htmlspecialchars($row["id_turno"], ENT_QUOTES, 'UTF-8').');"  id_turno="'.htmlspecialchars($row["id_turno"], ENT_QUOTES, 'UTF-8').'" class="btn btn-inline btn-warning btn-sm ladda-button">Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.htmlspecialchars($row["id_turno"], ENT_QUOTES, 'UTF-8').');"  id_turno="'.htmlspecialchars($row["id_turno"], ENT_QUOTES, 'UTF-8').'" class="btn btn-inline btn-danger btn-sm ladda-button">Eliminar</button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "eliminar":
             try {
                $resultado = $turno->delete_turno($_POST["id_turno"]);
                 if ($resultado > 0) {
                    echo json_encode(array("success" => "Turno eliminado correctamente."));
                 } else {
                    // Podría ser que el ID no exista o ya estuviera eliminado (est=0)
                    echo json_encode(array("info" => "No se pudo eliminar el turno o ya estaba eliminado."));
                 }
            } catch (Exception $e) {
                 http_response_code(500); // Internal Server Error para errores inesperados en delete
                 error_log("Error al eliminar turno: " . $e->getMessage()); // Loguear el error
                 echo json_encode(array("error" => "Ocurrió un error al eliminar el turno."));
            }
        break;

        case "mostrar";
            $datos=$turno->get_turno_x_id_turno($_POST["id_turno"]);  
            if(is_array($datos)==true and count($datos)>0){
                // Debería devolver solo un registro, así que usamos fetch() en el modelo o tomamos el primer elemento aquí
                $row = $datos[0]; 
                $output["id_turno"] = $row["id_turno"];
                $output["nombre"] = $row["nombre"];
                $output["hora_inicio"] = $row["hora_inicio"];
                $output["hora_fin"] = $row["hora_fin"];
                $output["tolerancia_minutos"] = $row["tolerancia_minutos"];
                echo json_encode($output);
            } else {
                 http_response_code(404); // Not Found si no se encuentra el turno
                 echo json_encode(array("error" => "Turno no encontrado."));
            }   
        break;

        default: 
             http_response_code(404); // Not Found para operaciones no válidas
             echo json_encode(array("error" => "Operación no válida."));
        break;

    }
?>
