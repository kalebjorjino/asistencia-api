<?php
class EmpleadoEstructura extends Conectar {

    public function get_empleado_estructuras() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT ee.id, ee.id_empleado, e.nombre AS empleado, ee.id_estructura, eo.nombre AS estructura, ee.fecha_inicio, ee.fecha_fin
                FROM empleado_estructura ee
                INNER JOIN empleados e ON ee.id_empleado = e.id
                INNER JOIN estructuras_organizacionales eo ON ee.id_estructura = eo.id
                WHERE ee.est = 1";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function get_empleado_estructura_x_id($id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM empleado_estructura WHERE id = ? AND est = 1";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insert_empleado_estructura($id_empleado, $id_estructura, $fecha_inicio, $fecha_fin) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO empleado_estructura (id_empleado, id_estructura, fecha_inicio, fecha_fin, est) 
                VALUES (?, ?, ?, ?, 1)";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id_empleado);
        $stmt->bindValue(2, $id_estructura);
        $stmt->bindValue(3, $fecha_inicio);
        $stmt->bindValue(4, $fecha_fin);
        $stmt->execute();
        return $conectar->lastInsertId();
    }

    public function update_empleado_estructura($id, $id_empleado, $id_estructura, $fecha_inicio, $fecha_fin) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE empleado_estructura SET id_empleado = ?, id_estructura = ?, fecha_inicio = ?, fecha_fin = ? WHERE id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id_empleado);
        $stmt->bindValue(2, $id_estructura);
        $stmt->bindValue(3, $fecha_inicio);
        $stmt->bindValue(4, $fecha_fin);
        $stmt->bindValue(5, $id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete_empleado_estructura($id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE empleado_estructura SET est = 0 WHERE id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>
