<?php
    require_once("../config/conexion.php");
    require_once("../models/Empleado.php");
    $empleado = new Empleado();

    switch($_GET["op"]){

        case "listar":
            $datos=$empleado->get_asistencia();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["idAsistencia"];
                $sub_array[] = $row["dniEmpleado"];
                $sub_array[] = $row["nombreEmpleado"];
                $sub_array[] = $row["localLocal"];
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

    }
?>