<?php
    class Departamento extends Conectar{

        public function get_departamento(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM departamentos WHERE est=1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_departamento($nombre_departamento, $descripcion_departamento){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO departamentos (id_departamento, nombre_departamento, descripcion_departamento, est) VALUES (NULL,?,?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $nombre_departamento);
            $sql->bindValue(2, $descripcion_departamento);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_departamento($id_departamento,$nombre_departamento, $descripcion_departamento){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE departamentos set
                nombre_departamento = ?,
                descripcion_departamento = ?
                WHERE
                id_departamento = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $nombre_departamento);
            $sql->bindValue(2, $descripcion_departamento);
            $sql->bindValue(3, $id_departamento);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_departamento($id_departamento){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE departamentos SET est='0' where id_departamento=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_departamento);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        

        public function get_departamentolist(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT
            departamentos.id_departamento,
            departamentos.nombre_departamento,
            departamentos.descripcion_departamento
        FROM 
            departamentos
        WHERE
               departamentos.est = 1
                ";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_departamento_x_id($id_departamento){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            departamentos.id_departamento,
            departamentos.nombre_departamento,
            departamentos.descripcion_departamento
                FROM 
                departamentos
                WHERE
                departamentos.est = 1
                AND departamentos.id_departamento = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_departamento);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
?>