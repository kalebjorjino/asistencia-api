<?php
    class Local extends Conectar{

        public function get_local(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_local WHERE est=1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

       

    }
?>