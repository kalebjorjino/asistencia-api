<?php
    class Usuario extends Conectar{

        public function login(){
            try {
                $conectar = parent::conexion();
                parent::set_names();
                if(isset($_POST["enviar"])){
                    $correo = $_POST["usu_correo"];
                    $pass = $_POST["usu_pass"];
                    $rol = $_POST["rol_id"];
                    if(empty($correo) and empty($pass)){
                        header("Location:".Conectar::ruta()."login.php?m=2");
                        exit();
                    }else{
                        $sql = "SELECT u.*, e.nombre AS empleado
                        FROM tm_usuario u
                        INNER JOIN empleados e ON u.id_empleado = e.id
                        WHERE u.usu_correo=? and u.usu_pass=? and u.rol_id=? and u.est=1";
                        $stmt = $conectar->prepare($sql);
                        $stmt->bindValue(1, $correo);
                        $stmt->bindValue(2, $pass);
                        $stmt->bindValue(3, $rol);
                        $stmt->execute();
                        $resultado = $stmt->fetch();
                        if (is_array($resultado) and count($resultado)>0){
                            $_SESSION["usu_id"] = $resultado["usu_id"];
                            $_SESSION["id_empleado"] = $resultado["id_empleado"];
                            $_SESSION["empleado"] = $resultado["empleado"];
                            $_SESSION["rol_id"] = $resultado["rol_id"];
                            header("Location:".Conectar::ruta()."view/Asistencia/");
                            exit();
                        }else{
                            header("Location:".Conectar::ruta()."login.php?m=1");
                            exit();
                        }
                    }
                }
            } catch (Exception $e) {
                // Log the error for debugging purposes
                error_log("Error en la función login: " . $e->getMessage());
                // Optionally, redirect the user to an error page
                header("Location:".Conectar::ruta()."error.php?m=500");
                exit();
            }
        }

        public function insert_usuario($id_empleado,$usu_correo,$usu_pass,$rol_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO tm_usuario (usu_id, id_empleado, usu_correo, usu_pass, rol_id, fech_crea, fech_modi, fech_elim, est) VALUES (NULL,UPPER(?),UPPER(?),MD5(?),?,now(), NULL, NULL, '1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_empleado);
            $sql->bindValue(2, $usu_correo);
            $sql->bindValue(3, $usu_pass);
            $sql->bindValue(4, $rol_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_usuario($usu_id,$id_empleado,$usu_correo,$usu_pass,$rol_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_usuario set
                id_empleado = ?,
                usu_correo = ?,
                usu_pass = ?,
                rol_id = ?
                WHERE
                usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_empleado);
            $sql->bindValue(2, $usu_correo);
            $sql->bindValue(3, $usu_pass);
            $sql->bindValue(4, $rol_id);
            $sql->bindValue(5, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_usuario($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_usuario 
            SET 
            est='0', 
            fech_elim=now() 
            where usu_id=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        

        public function get_usuario(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            u.usu_id,
            e.nombre AS empleado,
            u.usu_correo,
            u.usu_pass,
            u.rol_id
        FROM 
            tm_usuario u
            INNER JOIN empleados e ON u.id_empleado = e.id
        WHERE
            u.est = 1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            u.usu_id,
            e.id AS id_empleado,
            e.nombre AS empleado,
            u.usu_correo,
            u.usu_pass,
            u.rol_id
        FROM 
            tm_usuario u
            INNER JOIN empleados e ON u.id_empleado = e.id
        WHERE
            u.est = 1
                AND u.usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    

    }
?>