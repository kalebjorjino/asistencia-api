<?php
    require_once("../config/conexion.php");
    require_once("../models/Departamento.php");
    $departamento = new Departamento();

    switch($_GET["op"]){
        case "combo":
            $datos = $departamento->get_departamento();
            if(is_array($datos)==true and count($datos)>0){
                echo "<option value=''>Selecciona</option>"; // Opción inicial por defecto
                $html;
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['id_departamento']."'>".$row['nombre_departamento']."</option>";
                }
                echo $html;
            }
        break;

        case "guardaryeditar":
            if(empty($_POST["id_departamento"])){       
                $departamento->insert_departamento($_POST["nombre_departamento"],$_POST["descripcion_departamento"]);     
            }
            else {
                $departamento->update_departamento($_POST["id_departamento"],$_POST["nombre_departamento"],$_POST["descripcion_departamento"]);
            }
        break;

        case "listar":
            $datos=$departamento->get_departamentolist();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["id_departamento"];
                $sub_array[] = $row["nombre_departamento"];
                $sub_array[] = $row["descripcion_departamento"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["id_departamento"].');"  id="'.$row["id_departamento"].'" class="btn btn-inline btn-warning btn-sm ladda-button">Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["id_departamento"].');"  id="'.$row["id_departamento"].'" class="btn btn-inline btn-danger btn-sm ladda-button">Eliminar</button>';
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
            $departamento->delete_departamento($_POST["id_departamento"]);
        break;

        case "mostrar";
        $datos=$departamento->get_departamento_x_id($_POST["id_departamento"]);  
        if(is_array($datos)==true and count($datos)>0){
            foreach($datos as $row)
            {
                $output["id_departamento"] = $row["id_departamento"];
                $output["nombre_departamento"] = $row["nombre_departamento"];
                $output["descripcion_departamento"] = $row["descripcion_departamento"];
            }
            echo json_encode($output);
        }   
    break;
    }
?>