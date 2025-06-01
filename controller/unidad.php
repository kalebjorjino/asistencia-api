<?php
    require_once("../config/conexion.php");
    require_once("../models/Unidad.php");
    $unidad = new Unidad();

    switch($_GET["op"]){
        case "combo":
            $datos = $unidad->get_unidad();
            if(is_array($datos)==true and count($datos)>0){
                echo "<option value=''>Selecciona</option>"; // Opción inicial por defecto
                $html;
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['id_unidad']."'>".$row['nombre_unidad']."</option>";
                }
                echo $html;
            }
        break;
        
        case "comboCategoria":
            $datos = $unidad->get_unidad_categoria($_POST["id_departamento"]);
            if(is_array($datos)==true and count($datos)>0){
                echo "<option value=''>Selecciona</option>"; // Opción inicial por defecto
                $html;
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['id_unidad']."'>".$row['nombre_unidad']."</option>";
                }
                echo $html;
            }
        break;

        case "guardaryeditar":
            if(empty($_POST["id_unidad"])){       
                $unidad->insert_unidad($_POST["id_departamento"],$_POST["nombre_unidad"],$_POST["descripcion_unidad"]);     
            }
            else {
                $unidad->update_unidad($_POST["id_unidad"],$_POST["id_departamento"],$_POST["nombre_unidad"],$_POST["descripcion_unidad"]);
            }
        break;

        case "listar":
            $datos=$unidad->get_unidadlist();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["id_unidad"];
                $sub_array[] = $row["id_departamento"];
                $sub_array[] = $row["nombre_unidad"];
                $sub_array[] = $row["descripcion_unidad"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["id_unidad"].');"  id="'.$row["id_unidad"].'" class="btn btn-inline btn-warning btn-sm ladda-button">Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["id_unidad"].');"  id="'.$row["id_unidad"].'" class="btn btn-inline btn-danger btn-sm ladda-button">Eliminar</button>';
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
            $unidad->delete_unidad($_POST["id_unidad"]);
        break;

        case "mostrar";
        $datos=$unidad->get_unidad_x_id($_POST["id_unidad"]);  
        if(is_array($datos)==true and count($datos)>0){
            foreach($datos as $row)
            {
                $output["id_unidad"] = $row["id_unidad"];
                $output["id_departamento"] = $row["id_departamento"];
                $output["nombre_unidad"] = $row["nombre_unidad"];
                $output["descripcion_unidad"] = $row["descripcion_unidad"];
            }
            echo json_encode($output);
        }   
    break;
    }
?>