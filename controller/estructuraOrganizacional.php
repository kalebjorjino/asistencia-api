<?php
require_once("../config/conexion.php");
require_once("../models/EstructuraOrganizacional.php");

$estructura = new EstructuraOrganizacional();

switch ($_GET["op"]) {

    case "guardaryeditar":
        if (empty($_POST["id"])) {
            $estructura->insert_estructura($_POST["nombre"], $_POST["tipo"], $_POST["estructura_padre_id"]);
        } else {
            $estructura->update_estructura($_POST["id"], $_POST["nombre"], $_POST["tipo"], $_POST["estructura_padre_id"]);
        }
        break;

    case "listar":
        $datos = $estructura->get_estructuras();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["id"];
            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["tipo"];
            $sub_array[] = $row["estructura_padre_id"];
            $sub_array[] = '<button type="button" onClick="editar(' . $row["id"] . ');" class="btn btn-warning btn-sm">Editar</button>';
            $sub_array[] = '<button type="button" onClick="eliminar(' . $row["id"] . ');" class="btn btn-danger btn-sm">Eliminar</button>';
            $data[] = $sub_array;
        }

        echo json_encode(array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        ));
        break;

    case "eliminar":
        $estructura->delete_estructura($_POST["id"]);
        break;

    case "mostrar":
        $datos = $estructura->get_estructura_x_id($_POST["id"]);
        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $output["id"] = $row["id"];
                $output["nombre"] = $row["nombre"];
                $output["tipo"] = $row["tipo"];
                $output["estructura_padre_id"] = $row["estructura_padre_id"];
            }
            echo json_encode($output);
        }
        break;
}
?>
