<?php
class EstructuraOrganizacional extends Conectar {

    public function get_estructuras() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM estructuras_organizacionales WHERE est = 1";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function get_estructura_x_id($id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM estructuras_organizacionales WHERE id = ? AND est = 1";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insert_estructura($nombre, $tipo, $estructura_padre_id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO estructuras_organizacionales (nombre, tipo, estructura_padre_id, est) VALUES (?, ?, ?, 1)";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $nombre);
        $stmt->bindValue(2, $tipo);
        $stmt->bindValue(3, $estructura_padre_id);
        $stmt->execute();
        return $conectar->lastInsertId();
    }

    public function update_estructura($id, $nombre, $tipo, $estructura_padre_id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE estructuras_organizacionales SET nombre = ?, tipo = ?, estructura_padre_id = ? WHERE id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $nombre);
        $stmt->bindValue(2, $tipo);
        $stmt->bindValue(3, $estructura_padre_id);
        $stmt->bindValue(4, $id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete_estructura($id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE estructuras_organizacionales SET est = 0 WHERE id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>
