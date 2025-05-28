<?php
    require_once("../config/conexion.php");
    require_once("../models/Horario.php");
    $horario = new Horario();

    switch($_GET["op"]){
        

         case "guardaryeditar":
            if(empty($_POST["id"])){       
                $horario->insert_horario($_POST["id_empleado"],$_POST["id_turno"],$_POST["fecha_inicio"],$_POST["fecha_fin"]);     
            }
            else {
                $horario->update_horario($_POST["id"],$_POST["id_empleado"],$_POST["id_turno"],$_POST["fecha_inicio"],$_POST["fecha_fin"]);
            }
        break;

        case "listar":
            $datos=$horario->get_horario();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["id"];
                $sub_array[] = $row["empleado"];
                $sub_array[] = $row["nombre"];
                $sub_array[] = $row["fecha_inicio"];
                $sub_array[] = $row["fecha_fin"];
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
            $horario->delete_horario($_POST["id"]);
        break;

        case "mostrar";
            $datos=$horario->get_horario_x_id($_POST["id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["id"] = $row["id"];
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