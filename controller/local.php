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

    }
?>