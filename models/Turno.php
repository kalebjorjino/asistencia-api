<?php
    class Turno extends Conectar{

        public function get_turno(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            turno_id,
            turno_nom,
            hora_inicio,
            hora_fin 
            FROM tm_turno 
            WHERE est=1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_turno_x_id($turno_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            turno_id,
            turno_nom,
            hora_inicio,
            hora_fin
            FROM tm_turno 
            WHERE est=1
                AND tm_turno.turno_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $turno_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_turno($turno_nom,$hora_inicio,$hora_fin){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO tm_turno (turno_id, turno_nom, hora_inicio, hora_fin, fech_crea, est) VALUES (NULL,?,?,?,now(),'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $turno_nom);
            $sql->bindValue(2, $hora_inicio);
            $sql->bindValue(3, $hora_fin);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_turno($turno_id,$turno_nom,$hora_inicio,$hora_fin){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_turno set
                turno_nom = ?,
                hora_inicio = ?,
                hora_fin = ?
                WHERE
                turno_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $turno_nom);
            $sql->bindValue(2, $hora_inicio);
            $sql->bindValue(3, $hora_fin);
            $sql->bindValue(4, $turno_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_turno($turno_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_turno 
            SET 
            est='0'
            where turno_id=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $turno_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

       

    }
?>