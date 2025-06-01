<?php
    class Oficina extends Conectar{

        public function get_oficina(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM oficinas WHERE est=1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_oficina($nombre_oficina, $direccion_oficina){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO oficinas (id_oficina, nombre_oficina, direccion_oficina, est) VALUES (NULL,?,?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $nombre_oficina);
            $sql->bindValue(2, $direccion_oficina);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_oficina($id_oficina,$nombre_oficina, $direccion_oficina){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE oficinas set
                nombre_oficina = ?,
                direccion_oficina = ?
                WHERE
                id_oficina = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $nombre_oficina);
            $sql->bindValue(2, $direccion_oficina);
            $sql->bindValue(3, $id_oficina);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_oficina($id_oficina){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE oficinas SET est='0' where id_oficina=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_oficina);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        

        public function get_oficinalist(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT
            oficinas.id_oficina,
            oficinas.nombre_oficina,
            oficinas.direccion_oficina
        FROM 
            oficinas
        WHERE
               oficinas.est = 1
                ";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_oficina_x_id($id_oficina){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            oficinas.id_oficina,
            oficinas.nombre_oficina,
            oficinas.direccion_oficina
                FROM 
                oficinas
                WHERE
                oficinas.est = 1
                AND oficinas.id_oficina = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_oficina);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
?>