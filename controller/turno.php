<?php
    require_once("../config/conexion.php");
    require_once("../models/Turno.php");
    $turno = new Turno();

    switch($_GET["op"]){
        case "combo":
            $datos = $turno->get_turno();
            if(is_array($datos)==true and count($datos)>0){
                echo "<option value=''>Selecciona</option>"; // Opci贸n inicial por defecto
                $html;
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['turno_id']."'>".$row['turno_nom']."</option>";
                }
                echo $html;
            }
        break;

         case "guardaryeditar":
            if(empty($_POST["turno_id"])){       
                $turno->insert_turno($_POST["turno_nom"],$_POST["hora_inicio"],$_POST["hora_fin"]);     
            }
            else {
                $turno->update_turno($_POST["turno_id"],$_POST["turno_nom"],$_POST["hora_inicio"],$_POST["hora_fin"]);
            }
        break;

        case "listar":
            $datos=$turno->get_turno();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["turno_id"];
                $sub_array[] = $row["turno_nom"];
                $sub_array[] = $row["hora_inicio"];
                $sub_array[] = $row["hora_fin"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["turno_id"].');"  id="'.$row["turno_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button">Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["turno_id"].');"  id="'.$row["turno_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button">Eliminar</button>';
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
            $turno->delete_turno($_POST["turno_id"]);
        break;

        case "mostrar";
            $datos=$turno->get_turno_x_id($_POST["turno_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["turno_id"] = $row["turno_id"];
                    $output["turno_nom"] = $row["turno_nom"];
                    $output["hora_inicio"] = $row["hora_inicio"];
                    $output["hora_fin"] = $row["hora_fin"];
                }
                echo json_encode($output);
            }   
        break;


    }
?>