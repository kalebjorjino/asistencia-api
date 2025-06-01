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
            // Validación: hora_inicio debe ser menor que hora_fin
            if (strtotime($hora_inicio) >= strtotime($hora_fin)) {
                // Lanzar una excepción o devolver un error específico
                throw new Exception("La hora de inicio debe ser anterior a la hora de fin.");
                // O podrías devolver un código/mensaje de error:
                // return array("error" => "La hora de inicio debe ser anterior a la hora de fin.");
            }

            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO turnos (id_turno, nombre, hora_inicio, hora_fin, tolerancia_minutos, est) VALUES (NULL,?,?,?,?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $nombre);
            $sql->bindValue(2, $hora_inicio);
            $sql->bindValue(3, $hora_fin);
            $sql->bindValue(4, $tolerancia_minutos);
            $sql->execute();
            // Devolver el ID insertado o un indicador de éxito
            return $conectar->lastInsertId(); 
        }

        public function update_turno($id_turno, $nombre, $hora_inicio, $hora_fin, $tolerancia_minutos){
             // Validación: hora_inicio debe ser menor que hora_fin
            if (strtotime($hora_inicio) >= strtotime($hora_fin)) {
                throw new Exception("La hora de inicio debe ser anterior a la hora de fin.");
                // O podrías devolver un código/mensaje de error:
                // return array("error" => "La hora de inicio debe ser anterior a la hora de fin.");
            }

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
            // Devolver el número de filas afectadas o un indicador de éxito
            return $sql->rowCount(); 
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
            // Devolver el número de filas afectadas o un indicador de éxito
            return $sql->rowCount(); 
        }
        
        public function nombre_existe($nombre, $id_turno = null) {
    $conectar = parent::conexion();
    parent::set_names();

    if ($id_turno === null) {
        // Para inserción: buscar si ya existe el nombre activo
        $sql = "SELECT COUNT(*) FROM turnos WHERE nombre = ? AND est = 1";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $nombre);
    } else {
        // Para actualización: buscar si existe otro con el mismo nombre excluyendo este id_turno
        $sql = "SELECT COUNT(*) FROM turnos WHERE nombre = ? AND est = 1 AND id_turno <> ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $nombre);
        $stmt->bindValue(2, $id_turno);
    }

    $stmt->execute();
    $count = $stmt->fetchColumn();

    return $count > 0; // true si ya existe
}


       

    }
?>
