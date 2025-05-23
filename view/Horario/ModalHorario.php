<div id="modalHorario" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-white" id="mdltitulo"></h4>
            </div>
            <form method="post" id="horario_form">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">

                    <div class="form-group">
                        <label class="form-label" for="id_empleado">Empleado</label>
                         <select id="id_empleado" name="id_empleado" class="form-control" required="required">
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hora_inicio">Hora Inicio</label>
                        <input type="time" class="form-control" id="hora_inicio" name="hora_inicio"  required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hora_fin">Hora Final</label>
                        <input type="time" class="form-control" id="hora_fin" name="hora_fin"  required>
                    </div>

                     <div class="form-group">
                        <label class="form-label" for="hora_fin">Tolerancia/Minutos</label>
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