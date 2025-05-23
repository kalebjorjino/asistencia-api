<?php
    class Horario extends Conectar{

        public function get_horario(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            horarios.id,
            e.nombre AS empleado,
            hora_inicio,
            hora_fin,
            tolerancia_minutos 
            FROM horarios
            INNER JOIN empleados e ON horarios.id_empleado = e.id
            WHERE horarios.est=1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_horario_x_id($id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM horarios WHERE est=1 AND id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_horario($id_empleado,$hora_inicio,$hora_fin,$tolerancia_minutos){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO horarios (id, id_empleado, hora_inicio, hora_fin, tolerancia_minutos, fecha_inicio, est) VALUES (NULL,?,?,?,?,now(),'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_empleado);
            $sql->bindValue(2, $hora_inicio);
            $sql->bindValue(3, $hora_fin);
            $sql->bindValue(4, $tolerancia_minutos);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_horario($id,$id_empleado,$hora_inicio,$hora_fin,$tolerancia_minutos){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE horarios set
                id_empleado = ?,
                hora_inicio = ?,
                hora_fin = ?,
                tolerancia_minutos = ?
                WHERE
                id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_empleado);
            $sql->bindValue(2, $hora_inicio);
            $sql->bindValue(3, $hora_fin);
            $sql->bindValue(4, $tolerancia_minutos);
            $sql->bindValue(5, $id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_horario($id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE horarios 
            SET 
            est='0'
            where id=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

       

    }
?>