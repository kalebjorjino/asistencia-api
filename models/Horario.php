<?php
class Horario extends Conectar {

    public function get_horario(){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="SELECT 
            horarios.id_horario,
            e.nombre AS empleado,
            t.nombre AS turno,
            fecha_inicio,
            fecha_fin
            FROM horarios
            INNER JOIN empleados e ON horarios.id_empleado = e.id
            INNER JOIN turnos t ON horarios.id_turno = t.id_turno
            WHERE horarios.est=1;";
        $sql=$conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function get_horario_x_id($id_horario){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="SELECT * FROM horarios WHERE est=1 AND id_horario = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $id_horario);
        $sql->execute();
        return $sql->fetchAll();
    }

    // Validación para existencia de empleado
    private function empleado_existe($id_empleado) {
        $conectar= parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) FROM empleados WHERE id = ? AND est = 1";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id_empleado);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Validación para existencia de turno
    private function turno_existe($id_turno) {
        $conectar= parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) FROM turnos WHERE id_turno = ? AND est = 1";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id_turno);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Validar solapamientos para un empleado (para insert)
    private function hay_solapamiento($id_empleado, $fecha_inicio, $fecha_fin, $excluir_id = null) {
        $conectar= parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) FROM horarios
                WHERE id_empleado = ? AND est = 1
                AND ((fecha_inicio <= ? AND fecha_fin >= ?) OR (fecha_inicio <= ? AND fecha_fin >= ?))";
        if ($excluir_id !== null) {
            $sql .= " AND id_horario != ?";
        }
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id_empleado);
        $stmt->bindValue(2, $fecha_fin);
        $stmt->bindValue(3, $fecha_inicio);
        $stmt->bindValue(4, $fecha_fin);
        $stmt->bindValue(5, $fecha_inicio);
        if ($excluir_id !== null) {
            $stmt->bindValue(6, $excluir_id);
        }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function insert_horario($id_empleado, $id_turno, $fecha_inicio, $fecha_fin){
        // Validar fechas
        if (strtotime($fecha_inicio) === false || strtotime($fecha_fin) === false) {
            return ["error" => "Formato de fecha inválido"];
        }
        if ($fecha_inicio > $fecha_fin) {
            return ["error" => "La fecha inicio no puede ser mayor que la fecha fin"];
        }
        // Validar existencia empleado y turno
        if (!$this->empleado_existe($id_empleado)) {
            return ["error" => "Empleado no existe o está inactivo"];
        }
        if (!$this->turno_existe($id_turno)) {
            return ["error" => "Turno no existe o está inactivo"];
        }
        // Validar solapamiento
        if ($this->hay_solapamiento($id_empleado, $fecha_inicio, $fecha_fin)) {
            return ["error" => "El empleado tiene otro horario asignado que se solapa con estas fechas"];
        }

        $conectar= parent::conexion();
        parent::set_names();
        $sql="INSERT INTO horarios (id_empleado, id_turno, fecha_inicio, fecha_fin, est) VALUES (?,?,?,?,1);";
        $stmt=$conectar->prepare($sql);
        $stmt->bindValue(1, $id_empleado);
        $stmt->bindValue(2, $id_turno);
        $stmt->bindValue(3, $fecha_inicio);
        $stmt->bindValue(4, $fecha_fin);
        $stmt->execute();
        return ["success" => true, "id" => $conectar->lastInsertId()];
    }

    public function update_horario($id_horario, $id_empleado, $id_turno, $fecha_inicio, $fecha_fin){
        // Validar fechas
        if (strtotime($fecha_inicio) === false || strtotime($fecha_fin) === false) {
            return ["error" => "Formato de fecha inválido"];
        }
        if ($fecha_inicio > $fecha_fin) {
            return ["error" => "La fecha inicio no puede ser mayor que la fecha fin"];
        }
        // Validar existencia empleado y turno
        if (!$this->empleado_existe($id_empleado)) {
            return ["error" => "Empleado no existe o está inactivo"];
        }
        if (!$this->turno_existe($id_turno)) {
            return ["error" => "Turno no existe o está inactivo"];
        }
        // Validar solapamiento (excluir el registro actual)
        if ($this->hay_solapamiento($id_empleado, $fecha_inicio, $fecha_fin, $id_horario)) {
            return ["error" => "El empleado tiene otro horario asignado que se solapa con estas fechas"];
        }

        $conectar= parent::conexion();
        parent::set_names();
        $sql="UPDATE horarios SET
            id_empleado = ?,
            id_turno = ?,
            fecha_inicio = ?,
            fecha_fin = ?
            WHERE id_horario = ?";
        $stmt=$conectar->prepare($sql);
        $stmt->bindValue(1, $id_empleado);
        $stmt->bindValue(2, $id_turno);
        $stmt->bindValue(3, $fecha_inicio);
        $stmt->bindValue(4, $fecha_fin);
        $stmt->bindValue(5, $id_horario);
        $stmt->execute();
        return ["success" => true, "rows_affected" => $stmt->rowCount()];
    }

    public function delete_horario($id_horario){
    $conectar = parent::conexion();
    parent::set_names();

    // Puedes añadir validaciones extra aquí (por ejemplo: verificar que no tenga asistencia asociada)

    $sql = "UPDATE horarios SET est = '0' WHERE id_horario = ?";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1, $id_horario);

    if ($sql->execute()) {
        return ["success" => true];
    } else {
        return ["error" => "No se pudo eliminar el horario."];
    }
}


}
?>
