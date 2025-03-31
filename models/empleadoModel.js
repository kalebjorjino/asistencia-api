const pool = require('../config/db');

async function obtenerEmpleadoPorId(id) {
    try {
        const [rows] = await pool.query('SELECT * FROM empleados WHERE id = ?', [id]);
        return rows[0];
    } catch (error) {
        console.error('Error al obtener empleado por ID:', error);
        throw error;
    }
}

async function obtenerEmpleadoPorDNI(dni) {
    try {
        const [rows] = await pool.query('SELECT * FROM empleados WHERE dni = ?', [dni]);
        return rows[0];
    } catch (error) {
        console.error('Error al obtener empleado por DNI:', error);
        throw error;
    }
}

async function crearEmpleado(dni, nombre, profesion) {
    try {
        const [result] = await pool.query(
            'INSERT INTO empleados (dni, nombre, profesion) VALUES (?, ?, ?)',
            [dni, nombre, profesion]
        );
        return { id: result.insertId };
    } catch (error) {
        console.error('Error al crear empleado:', error);
        throw error;
    }
}

async function actualizarEmpleado(id, nombre, profesion) {
    try {
        const [result] = await pool.query(
            'UPDATE empleados SET nombre = ?, profesion = ? WHERE id = ?',
            [nombre, profesion, id]
        );
        return result.affectedRows;
    } catch (error) {
        console.error('Error al actualizar empleado:', error);
        throw error;
    }
}

async function eliminarEmpleado(id) {
    try {
        const [result] = await pool.query('DELETE FROM empleados WHERE id = ?', [id]);
        return result.affectedRows;
    } catch (error) {
        console.error('Error al eliminar empleado:', error);
        throw error;
    }
}

async function listarEmpleados() {
    try {
        const [rows] = await pool.query('SELECT * FROM empleados');
        return rows;
    } catch (error) {
        console.error('Error al listar empleados:', error);
        throw error;
    }
}

module.exports = {
    obtenerEmpleadoPorId,
    obtenerEmpleadoPorDNI,
    crearEmpleado,
    actualizarEmpleado,
    eliminarEmpleado,
    listarEmpleados,
};