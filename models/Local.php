<?php
    class Local extends Conectar{

        public function get_local(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            local_id,
            local_nom 
            FROM tm_local 
            WHERE est=1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_local_x_id($local_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            local_id,
            local_nom 
            FROM tm_local 
            WHERE est=1
                AND tm_local.local_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $local_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_local($local_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO tm_local (local_id, local_nom, est) VALUES (NULL,?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $local_nom);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_local($local_id,$local_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_local set
                local_nom = ?
                WHERE
                local_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $local_nom);
            $sql->bindValue(2, $local_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_local($local_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_local 
            SET 
            est='0'
            where local_id=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $local_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

       

    }
?>