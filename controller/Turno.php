<?php
    require_once("../config/conexion.php");
    require_once("../models/Turno.php");
    $turno = new Turno();

    switch($_GET["op"]){

         case "combo":
            $datos = $turno->get_turno();
            if(is_array($datos)==true and count($datos)>0){
                echo "<option value=''>Selecciona</option>"; 
                $html;
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['id_turno']."'>".$row['nombre']."</option>";
                }
                echo $html;
            }
        break;
        

         case "guardaryeditar":
            if(empty($_POST["id_turno"])){       
                $turno->insert_turno($_POST["nombre"],$_POST["hora_inicio"],$_POST["hora_fin"],$_POST["tolerancia_minutos"]);     
            }
            else {
                $turno->update_turno($_POST["id_turno"],$_POST["nombre"],$_POST["hora_inicio"],$_POST["hora_fin"],$_POST["tolerancia_minutos"]);
            }
        break;

        case "listar":
            $datos=$turno->get_turno();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["id_turno"];
                $sub_array[] = $row["nombre"];
                $sub_array[] = $row["hora_inicio"];
                $sub_array[] = $row["hora_fin"];
                $sub_array[] = $row["tolerancia_minutos"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["id_turno"].');"  id_turno="'.$row["id_turno"].'" class="btn btn-inline btn-warning btn-sm ladda-button">Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["id_turno"].');"  id_turno="'.$row["id_turno"].'" class="btn btn-inline btn-danger btn-sm ladda-button">Eliminar</button>';
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
            $turno->delete_turno($_POST["id_turno"]);
        break;

        case "mostrar";
            $datos=$turno->get_turno_x_id_turno($_POST["id_turno"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["id_turno"] = $row["id_turno"];
                    $output["nombre"] = $row["nombre"];
                    $output["hora_inicio"] = $row["hora_inicio"];
                    $output["hora_fin"] = $row["hora_fin"];
                    $output["tolerancia_minutos"] = $row["tolerancia_minutos"];
                }
                echo json_encode($output);
            }   
        break;


    }
?>