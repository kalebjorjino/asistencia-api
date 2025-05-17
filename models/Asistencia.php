<?php
    class Asistencia extends Conectar{
        public function get_asistencia(){
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
                WHERE a.est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
        }

        public function obtenerEmpleadoPorDNI($dni){
            $conectar=parent::conexion();
            parent::set_names();
            $sql="SELECT id AS idEmpleado FROM empleados WHERE dni = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $dni);
            $sql->execute();
            return $resultado=$sql->fetch(PDO::FETCH_ASSOC);
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

        public function crearAsistencia($usuarioId, $ubicacion, $foto){
            $conectar=parent::conexion();
            parent::set_names();
            $sql="INSERT INTO asistencia
            (
                id_empleado,
                ubicacion,
                foto,
                hora_entrada
            )
            VALUES (?, ?, ?, CURRENT_TIMESTAMP)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usuarioId);
            $sql->bindValue(2, $ubicacion);
            $sql->bindValue(3, $foto);
            $sql->execute();
            return $conectar->lastInsertId();
        }

        public function tieneEntradaActiva($empleadoId){
            $conectar=parent::conexion();
            parent::set_names();
            $sql="SELECT id_as AS idAsistencia FROM asistencia WHERE id_empleado = ? AND hora_salida IS NULL ORDER BY hora_entrada DESC LIMIT 1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $empleadoId);
            $sql->execute();
            $resultado = $sql->fetch(PDO::FETCH_ASSOC);
            return (is_array($resultado) && count($resultado) > 0);
        }

        public function registrarSalida($empleadoId){
            $conectar=parent::conexion();
            parent::set_names();
            $sql="UPDATE asistencia SET hora_salida = CURRENT_TIMESTAMP WHERE id_empleado = ? AND hora_salida IS NULL ORDER BY hora_entrada DESC LIMIT 1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $empleadoId);
            $sql->execute();
            return $sql->rowCount();
        }

        public function obtenerAsistenciaActivaPorEmpleado($empleadoId){
            $conectar=parent::conexion();
            parent::set_names();
            $sql="SELECT hora_salida FROM asistencia WHERE id_empleado = ? AND hora_salida IS NULL ORDER BY hora_entrada DESC LIMIT 1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $empleadoId);
            $sql->execute();
            return $resultado=$sql->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerAsistenciaPorId($idAsistencia){
            $conectar=parent::conexion();
            parent::set_names();
            $sql="SELECT hora_entrada FROM asistencia WHERE id_as = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $idAsistencia);
            $sql->execute();
            return $resultado=$sql->fetch(PDO::FETCH_ASSOC);
        }

        public function tieneEntradaHoy($empleadoId) {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT id_as FROM asistencia WHERE id_empleado = ? AND DATE(hora_entrada) = CURDATE() AND hora_salida IS NULL";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $empleadoId);
            $sql->execute();
            return $sql->fetch(PDO::FETCH_ASSOC);
        }
    }
?>