<?php
class Empleado extends Conectar
{

    public function get_asistencia()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT
                a.id_as AS idAsistencia,
                e.nombre AS nombreEmpleado,
                a.hora_entrada AS horaEntrada,
                a.hora_salida AS horaSalida,
                a.tardanza AS tardanza,
                a.horas_extras AS horas_extras,
                a.horas_trabajadas AS horas_trabajadas,
                a.ubicacion AS ubicacionAsistencia,
                a.foto AS fotoAsistencia
                FROM asistencia a
                INNER JOIN empleados e ON a.id_empleado = e.id
                ;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }



    public function get_asistencia_x_id($id_as)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT
                a.id_as AS idAsistencia,
                e.nombre AS nombreEmpleado,
                a.hora_entrada AS horaEntrada,
                a.hora_salida AS horaSalida,
                a.ubicacion AS ubicacionAsistencia,
                a.foto AS fotoAsistencia
                FROM asistencia a
                INNER JOIN empleados e ON a.id_empleado = e.id
                WHERE a.est = 1
                AND a.id_as = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_as);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert_empleado($dni, $nombre, $profesion, $id_departamento, $id_unidad, $id_oficina, $id_servicio)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO empleados (id, dni, nombre, profesion, id_departamento, id_unidad, id_oficina, id_servicio, fecha_registro, est) VALUES (NULL,?,?,?,?,?,?,?,now(),'1');";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $dni);
        $sql->bindValue(2, $nombre);
        $sql->bindValue(3, $profesion);
        $sql->bindValue(4, $id_departamento);
        $sql->bindValue(5, $id_unidad);
        $sql->bindValue(6, $id_oficina);
        $sql->bindValue(7, $id_servicio);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function update_empleado($id, $dni, $nombre, $profesion, $id_departamento, $id_unidad, $id_oficina, $id_servicio)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE empleados set
                dni = ?,
                nombre = ?,
                profesion = ?,
                id_departamento = ?,
                id_unidad = ?,
                id_oficina = ?,
                id_servicio = ?
                WHERE
                id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $dni);
        $sql->bindValue(2, $nombre);
        $sql->bindValue(3, $profesion);
        $sql->bindValue(4, $id_departamento);
        $sql->bindValue(5, $id_unidad);
        $sql->bindValue(6, $id_oficina);
        $sql->bindValue(7, $id_servicio);
        $sql->bindValue(8, $id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function validar_dni_existente($dni, $id = null)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT dni FROM empleados WHERE dni = ?";
        if ($id !== null) {
            $sql .= " AND id != ?";
        }
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $dni);
        if ($id !== null) {
            $sql->bindValue(2, $id);
        }
        $sql->execute();
        return $resultado = $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function delete_empleado($id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE empleados 
            SET 
            est='0'
            where id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_empleado()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT
    e.id,
    eu.nombre AS usuario,
    e.dni,
    e.nombre AS nombre,
    e.profesion,
    e.id_departamento,
    d.nombre_departamento AS departamento,
    e.id_unidad,
    un.nombre_unidad AS unidad,
    e.id_oficina,
    o.nombre_oficina AS oficina,
    e.id_servicio,
    s.nombre_servicio AS servicio,
    e.fecha_registro
FROM
    empleados e
LEFT JOIN
    departamentos d ON e.id_departamento = d.id_departamento
LEFT JOIN
    unidades un ON e.id_unidad = un.id_unidad
LEFT JOIN
    oficinas o ON e.id_oficina = o.id_oficina
LEFT JOIN
    servicios s ON e.id_servicio = s.id_servicio
INNER JOIN
    tm_usuario u ON e.usu_id = u.usu_id
INNER JOIN
    empleados eu ON eu.id = u.id_empleado
WHERE
    e.est = 1;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function get_empleado_x_id($id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
    e.id,
    e.dni,
    e.nombre,
    e.profesion,
    e.id_departamento,
    d.nombre_departamento AS departamento,
    e.id_unidad,
    un.nombre_unidad AS unidad,
    e.id_oficina,
    o.nombre_oficina AS oficina,
    e.id_servicio,
    s.nombre_servicio AS servicio,
    e.fecha_registro
FROM 
    empleados e
LEFT JOIN departamentos d ON e.id_departamento = d.id_departamento
LEFT JOIN unidades un ON e.id_unidad = un.id_unidad
LEFT JOIN oficinas o ON e.id_oficina = o.id_oficina
LEFT JOIN servicios s ON e.id_servicio = s.id_servicio
WHERE
    e.est = 1
    AND e.id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_empleado_x_usu($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT
    e.id,
    eu.nombre AS usuario,
    e.dni,
    e.nombre,
    e.profesion,
    e.id_departamento,
    d.nombre_departamento AS departamento,
    e.id_unidad,
    un.nombre_unidad AS unidad,
    e.id_oficina,
    o.nombre_oficina AS oficina,
    e.id_servicio,
    s.nombre_servicio AS servicio,
    e.fecha_registro,
    u.usu_correo,
    u.rol_id
FROM
    empleados e
LEFT JOIN departamentos d ON e.id_departamento = d.id_departamento
LEFT JOIN unidades un ON e.id_unidad = un.id_unidad
LEFT JOIN oficinas o ON e.id_oficina = o.id_oficina
LEFT JOIN servicios s ON e.id_servicio = s.id_servicio
INNER JOIN
    tm_usuario u ON e.usu_id = u.usu_id
INNER JOIN
    empleados eu ON eu.id = u.id_empleado
WHERE
    e.est = 1
    AND u.est = 1
    AND u.usu_id = ?
";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}
