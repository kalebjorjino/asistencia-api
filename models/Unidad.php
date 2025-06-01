<?php
    class Unidad extends Conectar{

        public function get_unidad(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM unidades WHERE est=1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        
        public function get_unidad_categoria($id_departamento){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM unidades WHERE id_departamento=? AND est=1;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_departamento);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_unidad($id_departamento, $nombre_unidad, $descripcion_unidad){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO unidades (id_unidad, id_departamento, nombre_unidad, descripcion_unidad, est) VALUES (NULL,?,?,?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_departamento);
            $sql->bindValue(2, $nombre_unidad);
            $sql->bindValue(3, $descripcion_unidad);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_unidad($id_unidad,$id_departamento, $nombre_unidad, $descripcion_unidad){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE unidades set
                id_departamento = ?,
                nombre_unidad = ?,
                descripcion_unidad = ?
                WHERE
                id_unidad = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_departamento);
            $sql->bindValue(2, $nombre_unidad);
            $sql->bindValue(3, $descripcion_unidad);
            $sql->bindValue(4, $id_unidad);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_unidad($id_unidad){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE unidades SET est='0' where id_unidad=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_unidad);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        

        public function get_unidadlist(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT
            unidades.id_unidad,
            unidades.id_departamento,
            unidades.nombre_unidad,
            unidades.descripcion_unidad
        FROM 
            unidades
        WHERE
               unidades.est = 1
                ";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_unidad_x_id($id_unidad){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            unidades.id_unidad,
            unidades.id_departamento,
            unidades.nombre_unidad,
            unidades.descripcion_unidad
                FROM 
                unidades
                WHERE
                unidades.est = 1
                AND unidades.id_unidad = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_unidad);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
?>