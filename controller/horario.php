<?php
    require_once("../config/conexion.php");
    require_once("../models/Horario.php");
    $horario = new Horario();

    switch($_GET["op"]){

        case "combo":
            $datos = $horario->get_horario();
            if(is_array($datos)==true and count($datos)>0){
                echo "<option value=''>Selecciona</option>"; // Opción inicial por defecto
                $html;
                foreach($datos as $row)
                {
                     $html.= "<option value='".$row['id_horario']."'>".$row['id_horario']." ".$row['empleado']."</option>";
                }
                echo $html;
            }
        break;
         
         case "guardaryeditar":
    // Sanitizar y validar inputs
    $id_horario = isset($_POST["id_horario"]) ? $_POST["id_horario"] : null;
    $id_empleado = isset($_POST["id_empleado"]) ? $_POST["id_empleado"] : null;
    $id_turno = isset($_POST["id_turno"]) ? $_POST["id_turno"] : null;
    $fecha_inicio = isset($_POST["fecha_inicio"]) ? $_POST["fecha_inicio"] : null;
    $fecha_fin = isset($_POST["fecha_fin"]) ? $_POST["fecha_fin"] : null;

    if (empty($id_horario)) {
        // Insertar nuevo
        $respuesta = $horario->insert_horario($id_empleado, $id_turno, $fecha_inicio, $fecha_fin);
    } else {
        // Actualizar existente
        $respuesta = $horario->update_horario($id_horario, $id_empleado, $id_turno, $fecha_inicio, $fecha_fin);
    }

    echo json_encode($respuesta);
    break;


        case "listar":
            $datos=$horario->get_horario();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["id_horario"];
                $sub_array[] = $row["empleado"];
                $sub_array[] = $row["turno"];
                $sub_array[] = $row["fecha_inicio"];
                $sub_array[] = $row["fecha_fin"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["id_horario"].');"  id="'.$row["id_horario"].'" class="btn btn-inline btn-warning btn-sm ladda-button">Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["id_horario"].');"  id="'.$row["id_horario"].'" class="btn btn-inline btn-danger btn-sm ladda-button">Eliminar</button>';
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
    $id_horario = isset($_POST["id_horario"]) ? $_POST["id_horario"] : null;
    $respuesta = $horario->delete_horario($id_horario);
    echo json_encode($respuesta);
    break;

        case "mostrar";
            $datos=$horario->get_horario_x_id($_POST["id_horario"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["id_horario"] = $row["id_horario"];
                    $output["id_empleado"] = $row["id_empleado"];
                    $output["id_turno"] = $row["id_turno"];
                    $output["fecha_inicio"] = $row["fecha_inicio"];
                    $output["fecha_fin"] = $row["fecha_fin"];
                }
                echo json_encode($output);
            }   
        break;


    }
?>