<?php
    class Empleado extends Conectar{

        public function get_asistencia(){
            $conectar=parent::conexion();
            parent::set_names();
            $sql="SELECT
                a.id_as AS idAsistencia,
                e.nombre AS nombreEmpleado,
                a.hora_entrada AS horaEntrada,
                a.hora_salida AS horaSalida,
                a.ubicacion AS ubicacionAsistencia,
                a.foto AS fotoAsistencia
                FROM asistencia a
                INNER JOIN empleados e ON a.id_empleado = e.id
                ;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_asistencia_x_id($id_as){
            $conectar=parent::conexion();
            parent::set_names();
            $sql="SELECT
                a.id_as AS idAsistencia,
                e.nombre AS nombreEmpleado,
                a.hora_entrada AS horaEntrada,
                a.hora_salida AS horaSalida,
                a.ubicacion AS ubicacionAsistencia,
                a.foto AS fotoAsistencia
                FROM asistencia a
                INNER JOIN empleados e ON a.id_empleado = e.id
                WHERE a.est = 1
                AND a.id_as = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_as);
            $sql->execute();
            return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
        }

         public function insert_empleado($dni,$nombre,$profesion){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO empleados (id, dni, nombre, profesion,  fecha_registro, est) VALUES (NULL,?,?,?,now(),'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $dni);
            $sql->bindValue(2, $nombre);
            $sql->bindValue(3, $profesion);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_empleado($id,$dni,$nombre,$profesion){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE empleados set
                dni = ?,
                nombre = ?,
                profesion = ?
                WHERE
                id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $dni);
            $sql->bindValue(2, $nombre);
            $sql->bindValue(3, $profesion);
            $sql->bindValue(4, $id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_empleado($id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE empleados 
            SET 
            est='0'
            where id=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_empleado(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            id, 
            dni, 
            nombre, 
            profesion, 
            fecha_registro
        FROM 
            empleados e
        WHERE
            e.est = 1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_empleado_x_id($id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            id, 
            dni, 
            nombre, 
            profesion, 
            fecha_registro
                FROM 
                empleados e
                WHERE
                e.est = 1
                AND e.id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
?>
