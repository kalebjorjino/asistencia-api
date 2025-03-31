const express = require('express');
const bodyParser = require('body-parser');
const asistenciaRoutes = require('./routes/asistenciaRoutes');
const empleadoRoutes = require('./routes/empleadoRoutes');
const path = require('path');
require('dotenv').config();
const cors = require('cors'); // Importa el middleware CORS

const app = express();
const port = process.env.PORT || 3000;

// Middleware CORS para permitir solicitudes desde el frontend (ajústalo según tu necesidad)
app.use(cors({
  origin: 'https://www.hrcallao.gob.pe/asistencia-frontend', // Reemplaza con la URL de tu frontend
  methods: 'POST, OPTIONS',
  allowedHeaders: 'Content-Type',
}));

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use('/api/asistencia', asistenciaRoutes);
app.use('/api/empleados', empleadoRoutes);
app.use('/public', express.static(path.join(__dirname, 'public')));

app.listen(port, () => {
  console.log(`Servidor escuchando en el puerto ${port}`);
});