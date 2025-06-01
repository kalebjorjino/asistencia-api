<?php
    require_once("../config/conexion.php");
    require_once("../models/Servicio.php");
    $servicio = new Servicio();

    switch($_GET["op"]){
        case "combo":
            $datos = $servicio->get_servicio();
            if(is_array($datos)==true and count($datos)>0){
                echo "<option value=''>Selecciona</option>"; // Opción inicial por defecto
                $html;
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['id_servicio']."'>".$row['nombre_servicio']."</option>";
                }
                echo $html;
            }
        break;

        case "guardaryeditar":
            if(empty($_POST["id_servicio"])){       
                $servicio->insert_servicio($_POST["nombre_servicio"],$_POST["descripcion_servicio"]);     
            }
            else {
                $servicio->update_servicio($_POST["id_servicio"],$_POST["nombre_servicio"],$_POST["descripcion_servicio"]);
            }
        break;

        case "listar":
            $datos=$servicio->get_serviciolist();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["id_servicio"];
                $sub_array[] = $row["nombre_servicio"];
                $sub_array[] = $row["descripcion_servicio"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["id_servicio"].');"  id="'.$row["id_servicio"].'" class="btn btn-inline btn-warning btn-sm ladda-button">Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["id_servicio"].');"  id="'.$row["id_servicio"].'" class="btn btn-inline btn-danger btn-sm ladda-button">Eliminar</button>';
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
            $servicio->delete_servicio($_POST["id_servicio"]);
        break;

        case "mostrar";
        $datos=$servicio->get_servicio_x_id($_POST["id_servicio"]);  
        if(is_array($datos)==true and count($datos)>0){
            foreach($datos as $row)
            {
                $output["id_servicio"] = $row["id_servicio"];
                $output["nombre_servicio"] = $row["nombre_servicio"];
                $output["descripcion_servicio"] = $row["descripcion_servicio"];
            }
            echo json_encode($output);
        }   
    break;
    }
?>