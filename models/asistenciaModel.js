const pool = require('../config/db');

async function crearAsistencia(usuarioId, ubicacion, foto) {
  const [result] = await pool.query(
    'INSERT INTO asistencia (id_empleado, ubicacion, foto) VALUES (?, ?, ?)',
    [usuarioId, ubicacion, foto]
  );
  return result.insertId;
}

async function obtenerEmpleadoPorDNI(dni) {
    try {
        const [rows] = await pool.query('SELECT id FROM empleados WHERE dni = ?', [dni]);
        return rows[0];
    } catch (error) {
        console.error('Error al obtener empleado por DNI:', error);
        throw error;
    }
}


async function tieneEntradaActiva(empleadoId) {
    try {
        const [rows] = await pool.query(
            'SELECT id FROM asistencia WHERE id_empleado = ? AND hora_salida IS NULL ORDER BY hora_entrada DESC LIMIT 1',
            [empleadoId]
        );
        return rows.length > 0; // Returns true if there's an active entry
    } catch (error) {
        console.error('Error al verificar entrada activa:', error);
        throw error;
    }
}

async function registrarSalida(empleadoId) {
    try {
        const [result] = await pool.query(
            'UPDATE asistencia SET hora_salida = CURRENT_TIMESTAMP WHERE id_empleado = ? AND hora_salida IS NULL ORDER BY hora_entrada DESC LIMIT 1',
            [empleadoId]
        );
        return result.affectedRows; // Returns the number of rows affected (should be 1 if successful)
    } catch (error) {
        console.error('Error al registrar salida:', error);
        throw error;
    }
}



module.exports = {
  crearAsistencia,
  obtenerEmpleadoPorDNI,
  tieneEntradaActiva,
  registrarSalida,
};