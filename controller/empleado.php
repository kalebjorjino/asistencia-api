<?php
    require_once("../config/conexion.php");
    require_once("../models/Empleado.php");
    $empleado = new Empleado();

    switch($_GET["op"]){

         case "guardaryeditar":
            if(empty($_POST["id"])){       
                $empleado->insert_empleado($_POST["dni"],$_POST["nombre"],$_POST["profesion"]);     
            }
            else {
                $empleado->update_empleado($_POST["id"],$_POST["dni"],$_POST["nombre"],$_POST["profesion"]);
            }
        break;

         case "listar":
            $datos=$empleado->get_asistencia();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["idAsistencia"];
                $sub_array[] = $row["nombreEmpleado"];
                $sub_array[] = '<button class="btn btn-success btn-sm rounded">' .$row["horaEntrada"] . '</button>';
                $sub_array[] = '<button class="btn btn-danger btn-sm rounded">' .$row["horaSalida"] . '</button>';
                if ($row["ubicacionAsistencia"] == "Ubicación no disponible") {
                    $sub_array[] = '<span class="text-danger font-weight-bold">' . $row["ubicacionAsistencia"] . '</span>';
                 } else {
                    $sub_array[] = '<button class="btn btn-info btn-sm rounded">' .$row["ubicacionAsistencia"] . '</button>';

                 }
                $sub_array[] = '<img src="../../public/' . $row["fotoAsistencia"] . '" class="img-thumbnail" width="80" height="80" alt="Foto de Asistencia">';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        

        case "listar_empleados":
            $datos=$empleado->get_empleado();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["id"];
                $sub_array[] = $row["dni"];
                $sub_array[] = $row["nombre"];
                $sub_array[] = $row["profesion"];
                $sub_array[] = $row["fecha_registro"];
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
            $empleado->delete_empleado($_POST["id"]);
        break;

        case "mostrar";
            $datos=$empleado->get_empleado_x_id($_POST["id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["id"] = $row["id"];
                    $output["dni"] = $row["dni"];
                    $output["nombre"] = $row["nombre"];
                    $output["profesion"] = $row["profesion"];
                }
                echo json_encode($output);
            }   
        break;

    }
?>