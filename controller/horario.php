<?php
    require_once("../config/conexion.php");
    require_once("../models/Horario.php");
    $horario = new Horario();

    switch($_GET["op"]){
        

         case "guardaryeditar":
            if(empty($_POST["id"])){       
                $horario->insert_horario($_POST["id_empleado"],$_POST["hora_inicio"],$_POST["hora_fin"],$_POST["tolerancia_minutos"]);     
            }
            else {
                $horario->update_horario($_POST["id"],$_POST["id_empleado"],$_POST["hora_inicio"],$_POST["hora_fin"],$_POST["tolerancia_minutos"]);
            }
        break;

        case "listar":
            $datos=$horario->get_horario();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["id"];
                $sub_array[] = $row["empleado"];
                $sub_array[] = $row["hora_inicio"];
                $sub_array[] = $row["hora_fin"];
                $sub_array[] = $row["tolerancia_minutos"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["id"].');"  id="'.$row["id"].'" class="btn btn-inline btn-warning btn-sm ladda-button">Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["id"].');"  id="'.$row["id"].'" class="btn btn-inline btn-danger btn-sm ladda-button">Eliminar</button>';
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
            $horario->delete_horario($_POST["horario_id"]);
        break;

        case "mostrar";
            $datos=$horario->get_horario_x_id($_POST["horario_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["horario_id"] = $row["horario_id"];
                    $output["horario_nom"] = $row["horario_nom"];
                    $output["hora_inicio"] = $row["hora_inicio"];
                    $output["hora_fin"] = $row["hora_fin"];
                }
                echo json_encode($output);
            }   
        break;


    }
?>