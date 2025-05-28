<?php
    class Horario extends Conectar{

        public function get_horario(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            horarios.id_horario,
            e.nombre AS empleado,
            t.nombre,
            fecha_inicio,
            fecha_fin
            FROM horarios
            INNER JOIN empleados e ON horarios.id_empleado = e.id
            INNER JOIN turnos t ON horarios.id_turno = t.id_turno
            WHERE horarios.est=1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_horario_x_id($id_horario){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM horarios WHERE est=1 AND id_horario = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_horario);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_horario($id_empleado,$id_turno,$fecha_inicio,$fecha_fin){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO horarios (id_horario, id_empleado, id_turno, fecha_inicio, fecha_fin, est) VALUES (NULL,?,?,?,?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_empleado);
            $sql->bindValue(2, $id_turno);
            $sql->bindValue(3, $fecha_inicio);
            $sql->bindValue(4, $fecha_fin);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_horario($id_horario,$id_empleado,$id_turno,$fecha_inicio,$fecha_fin){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE horarios set
                id_empleado = ?,
                id_turno = ?,
                fecha_inicio = ?,
                fecha_fin = ?
                WHERE
                id_horario = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_empleado);
            $sql->bindValue(2, $id_turno);
            $sql->bindValue(3, $fecha_inicio);
            $sql->bindValue(4, $fecha_fin);
            $sql->bindValue(5, $id_horario);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_horario($id_horario){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE horarios 
            SET 
            est='0'
            where id_horario=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_horario);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

       

    }
?>