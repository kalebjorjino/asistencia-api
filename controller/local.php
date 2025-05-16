<?php

header("Access-Control-Allow-Origin: *"); // O reemplaza * con tu dominio si quieres mayor seguridad
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Si es una solicitud preflight (OPTIONS), respondemos y salimos
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


    header('Content-Type: application/json');




    require_once("../config/conexion.php");
    require_once("../models/Local.php");
    $local = new Local();

    switch($_GET["op"]){
        case "combo":
            $datos = $local->get_local();
            if(is_array($datos)==true and count($datos)>0){
                echo "<option value=''>Selecciona</option>"; // Opci贸n inicial por defecto
                $html;
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['local_id']."'>".$row['local_nom']."</option>";
                }
                echo $html;
            }
        break;

         case "guardaryeditar":
            if(empty($_POST["id"])){       
                $local->insert_local($_POST["local_nom"]);     
            }
            else {
                $local->update_local($_POST["local_id"],$_POST["local_nom"]);
            }
        break;

        case "listar":
            $datos=$local->get_local();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["local_id"];
                $sub_array[] = $row["local_nom"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["local_id"].');"  id="'.$row["local_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button">Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["local_id"].');"  id="'.$row["local_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button">Eliminar</button>';
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
            $local->delete_local($_POST["local_id"]);
        break;

        case "mostrar";
            $datos=$local->get_local_x_id($_POST["local_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["local_id"] = $row["local_id"];
                    $output["local_nom"] = $row["local_nom"];
                }
                echo json_encode($output);
            }   
        break;


    }
?>