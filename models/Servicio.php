<?php
    class Servicio extends Conectar{

        public function get_servicio(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM servicios WHERE est=1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_servicio($nombre_servicio, $descripcion_servicio){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO servicios (id_servicio, nombre_servicio, descripcion_servicio, est) VALUES (NULL,?,?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $nombre_servicio);
            $sql->bindValue(2, $descripcion_servicio);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_servicio($id_servicio,$nombre_servicio, $descripcion_servicio){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE servicios set
                nombre_servicio = ?,
                descripcion_servicio = ?
                WHERE
                id_servicio = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $nombre_servicio);
            $sql->bindValue(2, $descripcion_servicio);
            $sql->bindValue(3, $id_servicio);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_servicio($id_servicio){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE servicios SET est='0' where id_servicio=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_servicio);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        

        public function get_serviciolist(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT
            servicios.id_servicio,
            servicios.nombre_servicio,
            servicios.descripcion_servicio
        FROM 
            servicios
        WHERE
               servicios.est = 1
                ";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_servicio_x_id($id_servicio){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            servicios.id_servicio,
            servicios.nombre_servicio,
            servicios.descripcion_servicio
                FROM 
                servicios
                WHERE
                servicios.est = 1
                AND servicios.id_servicio = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_servicio);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
?>