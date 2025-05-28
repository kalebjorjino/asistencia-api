<?php
    class Turno extends Conectar{

        public function get_turno(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    id_turno,
                    nombre,
                    hora_inicio,
                    hora_fin,
                    tolerancia_minutos 
                FROM turnos
                WHERE est = 1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_turno_x_id_turno($id_turno){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM turnos WHERE est=1 AND id_turno = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_turno);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_turno($nombre, $hora_inicio, $hora_fin, $tolerancia_minutos){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO turnos (id_turno, nombre, hora_inicio, hora_fin, tolerancia_minutos, est) VALUES (NULL,?,?,?,?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $nombre);
            $sql->bindValue(2, $hora_inicio);
            $sql->bindValue(3, $hora_fin);
            $sql->bindValue(4, $tolerancia_minutos);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_turno($id_turno, $nombre, $hora_inicio, $hora_fin, $tolerancia_minutos){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE turnos set
                nombre = ?,
                hora_inicio = ?,
                hora_fin = ?,
                tolerancia_minutos = ?
                WHERE
                id_turno = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $nombre);
            $sql->bindValue(2, $hora_inicio);
            $sql->bindValue(3, $hora_fin);
            $sql->bindValue(4, $tolerancia_minutos);
            $sql->bindValue(5, $id_turno);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_turno($id_turno){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE turnos 
            SET 
            est='0'
            where id_turno=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_turno);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

       

    }
?>