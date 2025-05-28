<div id="modalTurno" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-white" id="mdltitulo"></h4>
            </div>
            <form method="post" id="turno_form">
                <div class="modal-body">
                    <input type="hidden" id="id_turno" name="id_turno">

                    <div class="form-group">
                        <label class="form-label" for="nombre">Nombre Turno</label>
                         <select class="form-control" id="nombre" name="nombre">
                            <option value="mañana">Mañana</option>
                            <option value="tarde">Tarde</option>
                            <option value="noche">Noche</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hora_inicio">Hora Inicio</label>
                        <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hora_fin">Hora Fin</label>
                        <input type="time" class="form-control" id="hora_fin" name="hora_fin">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tolerancia_minutos">Tolerancia/Minutos</label>
                        <input type="time" class="form-control" id="tolerancia_minutos" name="tolerancia_minutos"  required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-inline btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" id="#" value="add" class="btn btn-inline btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
