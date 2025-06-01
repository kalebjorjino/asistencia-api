<?php
class Reporte extends Conectar{

    // ... (métodos existentes como traducirDia, obtenerEmpleadoPorDNI, etc. se mantienen) ...
    function traducirDia($diaIngles) {
        $dias = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        ];
        return $dias[$diaIngles] ?? null;
    }

    public function obtenerEmpleadoPorDNI($dni){
        $conectar=parent::conexion();
        parent::set_names();
        $sql="SELECT id AS idEmpleado FROM empleados WHERE dni = ? AND est = 1"; // Asegurar que el empleado esté activo
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
            a.tardanza,
            a.horas_trabajadas,
            a.horas_extras,
            a.ubicacion AS ubicacionAsistencia,
            a.foto AS fotoAsistencia,
            a.est
            FROM asistencia a
            INNER JOIN empleados e ON a.id_empleado = e.id
            WHERE a.id_as = ?"; // No filtrar por est=1 aquí, podría querer verse un registro específico inactivo
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $id_as);
        $sql->execute();
        return $resultado=$sql->fetch(PDO::FETCH_ASSOC); // Devolver solo una fila
    }


    



    public function obtenerAsistenciaActivaPorEmpleado($empleadoId){
        // Este método parece devolver la hora_salida, lo cual será NULL si está activa.
        // Podría ser confuso. Renombrar o ajustar si es necesario.
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
        // Devolver más datos si son útiles después de crear
        $sql="SELECT id_as, id_empleado, hora_entrada, tardanza FROM asistencia WHERE id_as = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $idAsistencia);
        $sql->execute();
        return $resultado=$sql->fetch(PDO::FETCH_ASSOC);
    }

    public function tieneEntradaHoy($empleadoId) {
        $conectar = parent::conexion();
        parent::set_names();
        // Verifica si hay una entrada HOY sin salida
        $sql = "SELECT id_as FROM asistencia WHERE id_empleado = ? AND DATE(hora_entrada) = CURDATE() AND hora_salida IS NULL";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $empleadoId);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    // --- Nuevos Métodos para DataTables Server-Side --- 

    private function build_where_clause($filtros, &$params) {
        $sql_where = "";
        $conditions = [];

        // Filtro por ID Empleado
        if (!empty($filtros['id_empleado'])) {
            $conditions[] = "a.id_empleado = ?";
            $params[] = $filtros['id_empleado'];
        }

        // Filtro por Tardanza
        if (isset($filtros['tardanza'])) {
            if ($filtros['tardanza'] === 'con') {
                $conditions[] = "a.tardanza > '00:00:00'";
            } elseif ($filtros['tardanza'] === 'sin') {
                $conditions[] = "(a.tardanza IS NULL OR a.tardanza = '00:00:00')";
            }
        }

        // Filtro por Horas Extras
        if (isset($filtros['horas_extras'])) {
            if ($filtros['horas_extras'] === 'con') {
                $conditions[] = "a.horas_extras > '00:00:00'";
            } elseif ($filtros['horas_extras'] === 'sin') {
                $conditions[] = "(a.horas_extras IS NULL OR a.horas_extras = '00:00:00')";
            }
        }
        
        // Filtro por Horas Trabajadas (Mínimo)
        if (!empty($filtros['horas_trabajadas'])) {
            // Convertir horas a formato HH:MM:SS para comparación
            $min_horas = intval($filtros['horas_trabajadas']);
            if ($min_horas >= 0) {
                 $min_horas_str = sprintf('%02d:00:00', $min_horas);
                 $conditions[] = "a.horas_trabajadas >= ?";
                 $params[] = $min_horas_str;
            }
        }

        // Filtro por Rango de Fechas (usando hora_entrada)
        if (!empty($filtros['fecha_inicio'])) {
            $conditions[] = "DATE(a.hora_entrada) >= ?";
            $params[] = $filtros['fecha_inicio'];
        }
        if (!empty($filtros['fecha_fin'])) {
            $conditions[] = "DATE(a.hora_entrada) <= ?";
            $params[] = $filtros['fecha_fin'];
        }
        
        // Filtro por Periodicidad (solo filtra por fecha, no agrupa aquí)
        if (!empty($filtros['periodicidad'])) {
            $fecha_ref = !empty($filtros['fecha_inicio']) ? $filtros['fecha_inicio'] : date('Y-m-d'); // Usa fecha inicio o hoy
             try {
                 $dateObj = new DateTime($fecha_ref);
                 if ($filtros['periodicidad'] === 'dia') {
                     $conditions[] = "DATE(a.hora_entrada) = ?";
                     $params[] = $dateObj->format('Y-m-d');
                 } elseif ($filtros['periodicidad'] === 'mes') {
                     $conditions[] = "YEAR(a.hora_entrada) = ? AND MONTH(a.hora_entrada) = ?";
                     $params[] = $dateObj->format('Y');
                     $params[] = $dateObj->format('m');
                 } elseif ($filtros['periodicidad'] === 'anio') {
                     $conditions[] = "YEAR(a.hora_entrada) = ?";
                     $params[] = $dateObj->format('Y');
                 }
             } catch (Exception $e) {
                 // Manejar fecha inválida si es necesario, por ahora ignoramos el filtro
                 error_log("Fecha inválida para periodicidad: " . $fecha_ref);
             }
        }

        // Siempre filtramos por estado activo de asistencia? Opcional.
        // $conditions[] = "a.est = 1"; 

        if (!empty($conditions)) {
            $sql_where = " WHERE " . implode(" AND ", $conditions);
        }

        return $sql_where;
    }

    public function get_asistencia_filtrada($start, $length, $orderColumn, $orderDir, $filtros) {
        $conectar = parent::conexion();
        parent::set_names();
        $params = [];
        $sql_where = $this->build_where_clause($filtros, $params);

        $sql = "SELECT
                    a.id_as AS idAsistencia,
                    e.dni AS dniEmpleado,
                    e.nombre AS nombreEmpleado,
                    a.hora_entrada AS horaEntrada,
                    a.hora_salida AS horaSalida,
                    a.tardanza,
                    a.horas_trabajadas,
                    a.horas_extras,
                    a.ubicacion AS ubicacionAsistencia,
                    a.foto AS fotoAsistencia,
                    a.est
                FROM asistencia a
                INNER JOIN empleados e ON a.id_empleado = e.id "
               . $sql_where .
               " ORDER BY " . $orderColumn . " " . $orderDir .
               " LIMIT " . intval($start) . ", " . intval($length);

        $stmt = $conectar->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_total_asistencia() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as total FROM asistencia a"; // Contar todos
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }

    public function get_total_asistencia_filtrada($filtros) {
        $conectar = parent::conexion();
        parent::set_names();
        $params = [];
        $sql_where = $this->build_where_clause($filtros, $params);

        $sql = "SELECT COUNT(*) as total 
                FROM asistencia a 
                INNER JOIN empleados e ON a.id_empleado = e.id " 
               . $sql_where;

        $stmt = $conectar->prepare($sql);
        $stmt->execute($params);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }
}
?>
