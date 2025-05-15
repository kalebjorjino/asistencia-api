<?php
    class Empleado extends Conectar{

        public function get_asistencia(){
            $conectar=parent::conexion();
            parent::set_names();
            $sql="SELECT
                a.id_as AS idAsistencia,
                e.dni AS dniEmpleado,
                e.nombre AS nombreEmpleado,
                l.local_nom AS localLocal,
                a.hora_entrada AS horaEntrada,
                a.hora_salida AS horaSalida,
                a.ubicacion AS ubicacionAsistencia,
                a.foto AS fotoAsistencia
                FROM asistencia a
                INNER JOIN empleados e ON a.id_empleado = e.id
                INNER JOIN tm_local l ON a.local_id = l.local_id;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_asistencia_x_id($id_as){
            $conectar=parent::conexion();
            parent::set_names();
            $sql="SELECT
                a.id_as AS idAsistencia,
                e.dni AS dniEmpleado,
                e.nombre AS nombreEmpleado,
                a.hora_entrada AS horaEntrada,
                a.hora_salida AS horaSalida,
                a.ubicacion AS ubicacionAsistencia,
                a.foto AS fotoAsistencia
                FROM asistencia a
                INNER JOIN empleados e ON a.id_empleado = e.id
                WHERE a.est = 1
                AND a.id_as = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_as);
            $sql->execute();
            return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
        }

    }
?>
