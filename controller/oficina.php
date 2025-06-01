<?php
    require_once("../config/conexion.php");
    require_once("../models/Oficina.php");
    $oficina = new Oficina();

    switch($_GET["op"]){
        case "combo":
            $datos = $oficina->get_oficina();
            if(is_array($datos)==true and count($datos)>0){
                echo "<option value=''>Selecciona</option>"; // Opción inicial por defecto
                $html;
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['id_oficina']."'>".$row['nombre_oficina']."</option>";
                }
                echo $html;
            }
        break;

        case "guardaryeditar":
            if(empty($_POST["id_oficina"])){       
                $oficina->insert_oficina($_POST["nombre_oficina"],$_POST["direccion_oficina"]);     
            }
            else {
                $oficina->update_oficina($_POST["id_oficina"],$_POST["nombre_oficina"],$_POST["direccion_oficina"]);
            }
        break;

        case "listar":
            $datos=$oficina->get_oficinalist();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["id_oficina"];
                $sub_array[] = $row["nombre_oficina"];
                $sub_array[] = $row["direccion_oficina"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["id_oficina"].');"  id="'.$row["id_oficina"].'" class="btn btn-inline btn-warning btn-sm ladda-button">Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["id_oficina"].');"  id="'.$row["id_oficina"].'" class="btn btn-inline btn-danger btn-sm ladda-button">Eliminar</button>';
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
            $oficina->delete_oficina($_POST["id_oficina"]);
        break;

        case "mostrar";
        $datos=$oficina->get_oficina_x_id($_POST["id_oficina"]);  
        if(is_array($datos)==true and count($datos)>0){
            foreach($datos as $row)
            {
                $output["id_oficina"] = $row["id_oficina"];
                $output["nombre_oficina"] = $row["nombre_oficina"];
                $output["direccion_oficina"] = $row["direccion_oficina"];
            }
            echo json_encode($output);
        }   
    break;
    }
?>