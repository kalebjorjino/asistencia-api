<?php
    require_once("../config/conexion.php");
    require_once("../models/Usuario.php");
    $usuario = new Usuario();

    switch($_GET["op"]){
       case "guardaryeditar":
    if (empty($_POST["usu_id"])) {
        $resultado = $usuario->insert_usuario($_POST["id_empleado"], $_POST["usu_correo"], $_POST["usu_pass"], $_POST["rol_id"]);
    } else {
        $resultado = $usuario->update_usuario($_POST["usu_id"], $_POST["id_empleado"], $_POST["usu_correo"], $_POST["usu_pass"], $_POST["rol_id"]);
    }

    if (isset($resultado["error"])) {
        echo json_encode(["status" => "error", "message" => $resultado["error"]]);
    } else {
        echo json_encode(["status" => "success"]);
    }
    break;


        case "listar":
            $datos=$usuario->get_usuario();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["empleado"];
                $sub_array[] = $row["usu_correo"];
                $sub_array[] = $row["usu_pass"];

                if ($row["rol_id"]=="1"){
                    $sub_array[] = '<span class="btn btn-inline btn-success btn-sm">Supervisor</span>';
                }else{
                    $sub_array[] = '<span class="btn btn-inline btn-info btn-sm">Administrador</span>';
                }

                $sub_array[] = '<button type="button" onClick="editar('.$row["usu_id"].');"  id="'.$row["usu_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button">Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["usu_id"].');"  id="'.$row["usu_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button">Eliminar</button>';
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
            $usuario->delete_usuario($_POST["usu_id"]);
        break;

        case "mostrar";
            $datos=$usuario->get_usuario_x_id($_POST["usu_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["usu_id"] = $row["usu_id"];
                    $output["id_empleado"] = $row["id_empleado"];
                    $output["usu_correo"] = $row["usu_correo"];
                    $output["usu_pass"] = $row["usu_pass"];
                    $output["rol_id"] = $row["rol_id"];
                }
                echo json_encode($output);
            }   
        break;

      
 
    }
?>