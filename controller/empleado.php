<?php
    require_once("../config/conexion.php");
    require_once("../models/Empleado.php");
    $empleado = new Empleado();

    switch($_GET["op"]){
        
           case "validar_dni":
            $dni = $_POST["dni"];
            $id = $_POST["id"];
            $dniOriginal = $_POST["dniOriginal"];

            if ($dni === $dniOriginal && !empty($id)) {
                // Si el DNI no ha cambiado en la edición, no es duplicado
                echo "no_existe";
            } else {
                $existe_dni = $empleado->validar_dni_existente($dni, $id);
                if ($existe_dni) {
                    echo "existe";
                } else {
                    echo "no_existe";
                }
            }
        break;

        case "combo":
            $datos = $empleado->get_empleado();
            if(is_array($datos)==true and count($datos)>0){
                echo "<option value=''>Selecciona</option>"; // Opción inicial por defecto
                $html;
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['id']."'>".$row['nombre']."</option>";
                }
                echo $html;
            }
        break;

          case "guardaryeditar":
            if(empty($_POST["id"])){       
                $empleado->insert_empleado($_POST["dni"],$_POST["nombre"],$_POST["profesion"],$_POST["id_departamento"],$_POST["id_unidad"],$_POST["id_oficina"],$_POST["id_servicio"]);     
            }
            else {
                $empleado->update_empleado($_POST["id"],$_POST["dni"],$_POST["nombre"],$_POST["profesion"],$_POST["id_departamento"],$_POST["id_unidad"],$_POST["id_oficina"],$_POST["id_servicio"]);
            }
        break;
        
case "listar":
    $datos = $empleado->get_asistencia();
    $data = array();

    foreach ($datos as $row) {
        $sub_array = array();

        $sub_array[] = $row["idAsistencia"];
        $sub_array[] = $row["nombreEmpleado"];
        $sub_array[] = $row["horaEntrada"];
        $sub_array[] = $row["horaSalida"];

        if ($row["ubicacionAsistencia"] == "Ubicación no disponible") {
            $sub_array[] = '<span class="text-danger font-weight-bold">' . $row["ubicacionAsistencia"] . '</span>';
        } else {
            $sub_array[] = $row["ubicacionAsistencia"];
        }

        $sub_array[] = '<img src="../../public/' . $row["fotoAsistencia"] . '" class="img-thumbnail" width="80" height="80" alt="Foto de Asistencia">';
        $sub_array[] = $row["tardanza"];
        $sub_array[] = $row["horas_trabajadas"];
        $sub_array[] = $row["horas_extras"];

        // Mostrar badge según tardanza: si es diferente de "00:00:00" llegó tarde, si no, puntualidad
        if ($row["tardanza"] !== "00:00:00") {
            $sub_array[] = '<button type="button" class="btn btn-inline btn-danger btn-sm ladda-button">Llegó tarde</button>';
        } else {
            $sub_array[] = '<button type="button" class="btn btn-inline btn-success btn-sm ladda-button">Puntualidad</button>';
        }

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



        

        case "listar_empleados":
            $datos=$empleado->get_empleado();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["id"];
                $sub_array[] = $row["usuario"];
                $sub_array[] = $row["dni"];
                $sub_array[] = $row["nombre"];
                $sub_array[] = $row["profesion"];
                $sub_array[] = $row["departamento"];
                $sub_array[] = $row["unidad"];
                $sub_array[] = $row["oficina"];
                $sub_array[] = $row["servicio"];
                $sub_array[] = $row["fecha_registro"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["id"].');"  id="'.$row["id"].'" class="btn btn-inline btn-warning btn-sm ladda-button">Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["id"].');"  id="'.$row["id"].'" class="btn btn-inline btn-danger btn-sm ladda-button">Eliminar</button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;
        
         case "listar_empleados_x_usu":
            $datos=$empleado->get_empleado_x_usu($_POST["usu_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["id"];
                $sub_array[] = $row["usuario"];
                $sub_array[] = $row["dni"];
                $sub_array[] = $row["nombre"];
                $sub_array[] = $row["profesion"];
                $sub_array[] = $row["departamento"];
                $sub_array[] = $row["unidad"];
                $sub_array[] = $row["oficina"];
                $sub_array[] = $row["servicio"];
                $sub_array[] = $row["fecha_registro"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["id"].');"  id="'.$row["id"].'" class="btn btn-inline btn-warning btn-sm ladda-button">Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["id"].');"  id="'.$row["id"].'" class="btn btn-inline btn-danger btn-sm ladda-button">Eliminar</button>';
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
            $empleado->delete_empleado($_POST["id"]);
        break;

        case "mostrar";
            $datos=$empleado->get_empleado_x_id($_POST["id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["id"] = $row["id"];
                    $output["dni"] = $row["dni"];
                    $output["nombre"] = $row["nombre"];
                    $output["profesion"] = $row["profesion"];
                    $output["id_departamento"] = $row["id_departamento"];
                    $output["id_unidad"] = $row["id_unidad"];
                    $output["id_oficina"] = $row["id_oficina"];
                    $output["id_servicio"] = $row["id_servicio"];
                }
                echo json_encode($output);
            }   
        break;

    }
?>