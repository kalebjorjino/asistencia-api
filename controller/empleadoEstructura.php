<?php
require_once("../config/conexion.php");
require_once("../models/EmpleadoEstructura.php");

$empleadoEstructura = new EmpleadoEstructura();

switch ($_GET["op"]) {

    case "guardaryeditar":
        if (empty($_POST["id"])) {
            $empleadoEstructura->insert_empleado_estructura(
                $_POST["id_empleado"],
                $_POST["id_estructura"],
                $_POST["fecha_inicio"],
                $_POST["fecha_fin"]
            );
        } else {
            $empleadoEstructura->update_empleado_estructura(
                $_POST["id"],
                $_POST["id_empleado"],
                $_POST["id_estructura"],
                $_POST["fecha_inicio"],
                $_POST["fecha_fin"]
            );
        }
        break;

    case "listar":
        $datos = $empleadoEstructura->get_empleado_estructuras();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["id"];
            $sub_array[] = $row["empleado"];
            $sub_array[] = $row["estructura"];
            $sub_array[] = $row["fecha_inicio"];
            $sub_array[] = $row["fecha_fin"];
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
        $empleadoEstructura->delete_empleado_estructura($_POST["id"]);
        break;

    case "mostrar":
        $datos = $empleadoEstructura->get_empleado_estructura_x_id($_POST["id"]);
        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $output["id"] = $row["id"];
                $output["id_empleado"] = $row["id_empleado"];
                $output["id_estructura"] = $row["id_estructura"];
                $output["fecha_inicio"] = $row["fecha_inicio"];
                $output["fecha_fin"] = $row["fecha_fin"];
            }
            echo json_encode($output);
        }
        break;
}
?>
