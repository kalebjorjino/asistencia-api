<?php
class DiasLaborales extends Conectar {

    public function get_dias_laborales() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                    dl.id,
                    dl.id_horario,
                    dl.dia,
                    dl.activo
                FROM dias_laborales dl
                INNER JOIN horarios h ON dl.id_horario = h.id_horario
                WHERE dl.est = 1;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function get_dias_laborales_x_id($id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM dias_laborales WHERE est = 1 AND id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetchAll();
    }

   public function insert_dia_laboral($id_horario, $dia, $activo) {
    if ($this->existe_dia_en_horario($id_horario, $dia)) {
        return false;  // Ya existe, no insertar
    }

    $conectar = parent::conexion();
    parent::set_names();
    $sql = "INSERT INTO dias_laborales (id_horario, dia, activo, est)
            VALUES (?, ?, ?, 1)";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1, $id_horario);
    $sql->bindValue(2, $dia);
    $sql->bindValue(3, $activo);
    $sql->execute();
    return $conectar->lastInsertId();
}


    public function update_dia_laboral($id, $id_horario, $dia, $activo) {
    if ($this->existe_dia_en_horario($id_horario, $dia, $id)) {
        return false;  // Ya existe duplicado, no actualizar
    }

    $conectar = parent::conexion();
    parent::set_names();
    $sql = "UPDATE dias_laborales 
            SET dia = ?, activo = ?
            WHERE id = ?";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1, $dia);
    $sql->bindValue(2, $activo);
    $sql->bindValue(3, $id);
    $sql->execute();
    return $sql->rowCount();
}

    
    public function existe_dia_en_horario($id_horario, $dia, $exclude_id = null) {
    $conectar = parent::conexion();
    parent::set_names();

    $sql = "SELECT COUNT(*) as count FROM dias_laborales 
            WHERE id_horario = ? AND dia = ? AND est = 1";

    // Si es update, excluimos el registro actual para no contarlo como duplicado
    if ($exclude_id !== null) {
        $sql .= " AND id != ?";
    }

    $stmt = $conectar->prepare($sql);

    if ($exclude_id !== null) {
        $stmt->execute([$id_horario, $dia, $exclude_id]);
    } else {
        $stmt->execute([$id_horario, $dia]);
    }

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['count'] > 0; // true si existe duplicado, false si no
}


    public function delete_dia_laboral($id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE dias_laborales SET est = 0 WHERE id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->rowCount();
    }
}
?>
