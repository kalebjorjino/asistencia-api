<?php
    session_start();

    class Conectar{
        protected $dbh;

        public function Conexion(){
            try {
				$conectar = $this->dbh = new PDO("mysql:host=hrcallao.gob.pe;dbname=hrcallao_asistencia_db","hrcallao_20159238si","3Nf4rm1t3c1root5");
				return $conectar;	
			} catch (Exception $e) {
				print "¡Error BD!: " . $e->getMessage() . "<br/>";
				die();	
			}
        }

        public function set_names(){	
			return $this->dbh->query("SET NAMES 'utf8'");
        }
        
        public static function ruta(){
			return "http://localhost/asistencia/";
		}
      

    }
?>