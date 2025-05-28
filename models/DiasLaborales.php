<?php
class DiasLaborales extends Conectar {

    public function get_dias_laborales() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                    dl.id,
                    dl.id_horario,
                    h.id_turno,
                    dl.dia,
                    dl.activo
                FROM dias_laborales dl
                INNER JOIN horarios h ON dl.id_horario = h.id_horario
                WHERE dl.est = 1";
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
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE dias_laborales 
                SET id_horario = ?, dia = ?, activo = ?
                WHERE id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_horario);
        $sql->bindValue(2, $dia);
        $sql->bindValue(3, $activo);
        $sql->bindValue(4, $id);
        $sql->execute();
        return $sql->rowCount();
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
