const express = require('express');
const router = express.Router();
const empleadoController = require('../controllers/empleadoController');

// Rutas para obtener empleados
router.get('/', empleadoController.listarEmpleados);
router.get('/id/:id', empleadoController.obtenerEmpleadoPorId);
router.get('/dni/:dni', empleadoController.obtenerEmpleadoPorDNI);

// Ruta para crear un nuevo empleado
router.post('/', empleadoController.crearEmpleado);

// Rutas para actualizar y eliminar empleados
router.put('/:id', empleadoController.actualizarEmpleado);
router.delete('/:id', empleadoController.eliminarEmpleado);

module.exports = router;