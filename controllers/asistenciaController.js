const asistenciaModel = require('../models/asistenciaModel');
const multer = require('multer');
const path = require('path');

const storage = multer.diskStorage({
    destination: (req, file, cb) => {
        cb(null, path.join(__dirname, '../public/uploads/'));
    },
    filename: (req, file, cb) => {
        cb(null, Date.now() + path.extname(file.originalname));
    },
});

const upload = multer({ storage });

async function registrarAsistencia(req, res) {
    upload.single('foto')(req, res, async (err) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }

        const { dni, nombre, ubicacion } = req.body;
        const foto = req.file ? `uploads/${req.file.filename}` : null;

        try {
            let empleado = await asistenciaModel.obtenerEmpleadoPorDNI(dni);


            const tieneEntrada = await asistenciaModel.tieneEntradaActiva(empleado.id);

            if (tieneEntrada) {
                const affectedRows = await asistenciaModel.registrarSalida(empleado.id);
                if (affectedRows > 0) {
                    return res.status(200).json({ message: 'Salida registrada correctamente' });
                } else {
                    return res.status(400).json({ message: 'No se encontró un registro de entrada activo para registrar la salida.' });
                }
            } else {
                await asistenciaModel.crearAsistencia(empleado.id, ubicacion, foto);
                return res.status(201).json({ message: 'Asistencia registrada correctamente' });
            }
        } catch (error) {
            res.status(500).json({ error: error.message });
        }
    });
}

module.exports = {
    registrarAsistencia,
};