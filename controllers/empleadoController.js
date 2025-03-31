const empleadoModel = require('../models/empleadoModel');

async function obtenerEmpleadoPorId(req, res) {
    const id = parseInt(req.params.id);
    if (isNaN(id) || id <= 0) {
        return res.status(400).json({ error: 'ID de empleado no válido' });
    }
    try {
        const empleado = await empleadoModel.obtenerEmpleadoPorId(id);
        if (empleado) {
            res.json(empleado);
        } else {
            res.status(404).json({ message: 'Empleado no encontrado' });
        }
    } catch (error) {
        console.error('Error al obtener empleado por ID:', error);
        res.status(500).json({ error: 'Error al obtener empleado' });
    }
}

async function obtenerEmpleadoPorDNI(req, res) {
    const dni = req.params.dni;
    if (!dni) {
        return res.status(400).json({ error: 'DNI no proporcionado' });
    }
    try {
        const empleado = await empleadoModel.obtenerEmpleadoPorDNI(dni);
        if (empleado) {
            res.json(empleado);
        } else {
            res.status(404).json({ message: 'Empleado no encontrado' });
        }
    } catch (error) {
        console.error('Error al obtener empleado por DNI:', error);
        res.status(500).json({ error: 'Error al obtener empleado' });
    }
}

async function crearEmpleado(req, res) {
    const { dni, nombre, profesion } = req.body; // THIS LINE IS MISSING IN YOUR CODE
    if (!dni || !nombre) {
        return res.status(400).json({ error: 'DNI y nombre son obligatorios' });
    }
    try {
        const nuevoEmpleado = await empleadoModel.crearEmpleado(dni, nombre, profesion);
        res.status(201).json({ id: nuevoEmpleado.id, message: 'Empleado creado exitosamente' });
    } catch (error) {
        console.error('Error al crear empleado (Controller):', error);
        if (error.code === 'ER_DUP_ENTRY') {
            return res.status(409).json({ error: 'Ya existe un empleado con ese DNI' });
        }
        res.status(500).json({ error: 'Error al crear empleado' });
    }
}

async function actualizarEmpleado(req, res) {
    const id = parseInt(req.params.id);
    if (isNaN(id) || id <= 0) {
        return res.status(400).json({ error: 'ID de empleado no válido' });
    }
    const { nombre, profesion } = req.body;
    if (!nombre) {
        return res.status(400).json({ error: 'El nombre es obligatorio para la actualización' });
    }
    try {
        const affectedRows = await empleadoModel.actualizarEmpleado(id, nombre, profesion);
        if (affectedRows > 0) {
            res.json({ message: 'Empleado actualizado exitosamente' });
        } else {
            res.status(404).json({ message: 'Empleado no encontrado' });
        }
    } catch (error) {
        console.error('Error al actualizar empleado:', error);
        res.status(500).json({ error: 'Error al actualizar empleado' });
    }
}

async function eliminarEmpleado(req, res) {
    const id = parseInt(req.params.id);
    if (isNaN(id) || id <= 0) {
        return res.status(400).json({ error: 'ID de empleado no válido' });
    }
    try {
        const affectedRows = await empleadoModel.eliminarEmpleado(id);
        if (affectedRows > 0) {
            res.json({ message: 'Empleado eliminado exitosamente' });
        } else {
            res.status(404).json({ message: 'Empleado no encontrado' });
        }
    } catch (error) {
        console.error('Error al eliminar empleado:', error);
        res.status(500).json({ error: 'Error al eliminar empleado' });
    }
}

async function listarEmpleados(req, res) {
    try {
        const empleados = await empleadoModel.listarEmpleados();
        res.json(empleados);
    } catch (error) {
        console.error('Error al listar empleados:', error);
        res.status(500).json({ error: 'Error al listar empleados' });
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