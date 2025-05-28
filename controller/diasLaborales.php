<?php
require_once("../config/conexion.php");
require_once("../models/DiasLaborales.php");
$diasLaborales = new DiasLaborales();

switch($_GET["op"]) {

    case "guardaryeditar":
        if(empty($_POST["id"])) {       
            // Insertar nuevo día laboral
            $diasLaborales->insert_dia_laboral($_POST["id_horario"], $_POST["dia"], $_POST["activo"]);     
        } else {
            // Actualizar día laboral existente
            $diasLaborales->update_dia_laboral($_POST["id"], $_POST["dia"], $_POST["activo"]);
        }
        break;

    case "listar":
        $datos = $diasLaborales->get_dias_laborales();
        $data = array();
        foreach($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["id"];
            $sub_array[] = $row["id_horario"];
            $sub_array[] = $row["dia"];
            $sub_array[] = $row["activo"] ? 'Activo' : 'Inactivo';
            $sub_array[] = '<button type="button" onClick="editar('.$row["id"].');" id="'.$row["id"].'" class="btn btn-warning btn-sm">Editar</button>';
            $sub_array[] = '<button type="button" onClick="eliminar('.$row["id"].');" id="'.$row["id"].'" class="btn btn-danger btn-sm">Eliminar</button>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;


    case "eliminar":
        $diasLaborales->delete_dia_laboral($_POST["id"]);
        break;

    case "mostrar":
        $datos = $diasLaborales->get_dias_laborales_x_id($_POST["id"]);  
        if(is_array($datos) == true && count($datos) > 0) {
            foreach($datos as $row) {
                $output["id"] = $row["id"];
                $output["id_horario"] = $row["id_horario"];
                $output["dia"] = $row["dia"];
                $output["activo"] = $row["activo"];
            }
            echo json_encode($output);
        }
        break;

}
?>
