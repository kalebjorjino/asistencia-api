const express = require('express');
const router = express.Router();
const asistenciaController = require('../controllers/asistenciaController');

router.post('/', asistenciaController.registrarAsistencia);




module.exports = router;