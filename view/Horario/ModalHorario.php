<div id="modalTurno" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-white" id="mdltitulo"></h4>
            </div>
            <form method="post" id="turno_form">
                <div class="modal-body">
                    <input type="hidden" id="turno_id" name="turno_id">

                    <div class="form-group">
                        <label class="form-label" for="id_empleado">Empleado</label>
                        <input type="text" class="form-control" id="id_empleado" name="id_empleado" placeholder="Ingrese Empleado" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hora_inicio">Hora Inicio</label>
                        <input type="time" class="form-control" id="hora_inicio" name="hora_inicio"  required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hora_fin">Hora Final</label>
                        <input type="time" class="form-control" id="hora_fin" name="hora_fin"  required>
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