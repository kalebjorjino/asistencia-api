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
        hora_entrada,
        est
    )
    VALUES (?, ?, ?, CURRENT_TIMESTAMP, 1)";
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

 public function registrarSalida($empleadoId) {
    $conectar = parent::conexion();
    parent::set_names();

    // 1. Obtener el registro pendiente (sin hora_salida)
    $sql = "SELECT id_as, hora_entrada 
            FROM asistencia 
            WHERE id_empleado = ? AND hora_salida IS NULL 
            ORDER BY hora_entrada DESC 
            LIMIT 1";
    $stmt = $conectar->prepare($sql);
    $stmt->bindValue(1, $empleadoId);
    $stmt->execute();
    $asistencia = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$asistencia) {
        return 0; // No hay registro sin salida pendiente
    }

    $idAsistencia = $asistencia['id_as'];
    $horaEntrada = new DateTime($asistencia['hora_entrada']);
    $horaSalida = new DateTime(); // ahora
    $horaSalidaStr = $horaSalida->format('Y-m-d H:i:s');
    $fechaAsistencia = $horaEntrada->format('Y-m-d');

    // 2. Obtener horario vigente para esa fecha y empleado
    $sqlHorario = "SELECT hora_inicio, hora_fin 
                   FROM horarios 
                   WHERE id_empleado = ? 
                     AND fecha_inicio <= ? 
                     AND (fecha_fin IS NULL OR fecha_fin >= ?) 
                     AND est = 1 
                   ORDER BY fecha_inicio DESC 
                   LIMIT 1";
    $stmtHorario = $conectar->prepare($sqlHorario);
    $stmtHorario->bindValue(1, $empleadoId);
    $stmtHorario->bindValue(2, $fechaAsistencia);
    $stmtHorario->bindValue(3, $fechaAsistencia);
    $stmtHorario->execute();
    $horario = $stmtHorario->fetch(PDO::FETCH_ASSOC);

    if (!$horario) {
        throw new Exception("No se encontró horario vigente para el empleado $empleadoId en la fecha $fechaAsistencia.");
    }

   $zonaHoraria = new DateTimeZone('America/Lima'); // O la que uses

$horaEntradaEsperada = new DateTime("$fechaAsistencia " . $horario['hora_inicio'], $zonaHoraria);
$horaSalidaEsperada  = new DateTime("$fechaAsistencia " . $horario['hora_fin'], $zonaHoraria);

$horaEntrada = new DateTime($asistencia['hora_entrada'], $zonaHoraria);
$horaSalida = new DateTime('now', $zonaHoraria);

    // 4. Calcular horas trabajadas
    $segundosTrabajados = $horaSalida->getTimestamp() - $horaEntrada->getTimestamp();
    $horas = floor($segundosTrabajados / 3600);
    $minutos = floor(($segundosTrabajados % 3600) / 60);
    $segundos = $segundosTrabajados % 60;
    $horasTrabajadas = sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);

    // 5. Calcular tardanza
    $tardanza = '00:00:00';
    if ($horaEntrada > $horaEntradaEsperada) {
        $segundosTardanza = $horaEntrada->getTimestamp() - $horaEntradaEsperada->getTimestamp();
        $h = floor($segundosTardanza / 3600);
        $m = floor(($segundosTardanza % 3600) / 60);
        $s = $segundosTardanza % 60;
        $tardanza = sprintf('%02d:%02d:%02d', $h, $m, $s);
    }

    // 6. Calcular horas extra (si aplica)
    $horasExtras = '00:00:00';
    if ($horaSalida > $horaSalidaEsperada && $horaEntrada <= $horaSalidaEsperada) {
        $segundosExtra = $horaSalida->getTimestamp() - $horaSalidaEsperada->getTimestamp();
        $h = floor($segundosExtra / 3600);
        $m = floor(($segundosExtra % 3600) / 60);
        $s = $segundosExtra % 60;
        $horasExtras = sprintf('%02d:%02d:%02d', $h, $m, $s);
    }

    // 7. Actualizar asistencia
    $sqlUpdate = "UPDATE asistencia SET 
                    hora_salida = CURRENT_TIMESTAMP, 
                    horas_trabajadas = ?, 
                    tardanza = ? 
                  WHERE id_as = ?";
    $stmtUpdate = $conectar->prepare($sqlUpdate);
    $stmtUpdate->bindValue(1, $horasTrabajadas);
    $stmtUpdate->bindValue(2, $tardanza);
    $stmtUpdate->bindValue(3, $idAsistencia);
    $stmtUpdate->execute();

    return $stmtUpdate->rowCount();
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