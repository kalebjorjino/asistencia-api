<div id="modalServicio" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-white" id="mdltitulo"></h4>
            </div>
            <form method="post" id="servicio_form">
                <div class="modal-body">
                    <input type="hidden" id="id_servicio" name="id_servicio">

                    <div class="form-group">
                        <label class="form-label" for="nombre_servicio">Servicio</label>
                        <input type="text" class="form-control" id="nombre_servicio" name="nombre_servicio" placeholder="Ingrese Nombre del Servicio" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="descripcion_servicio">Descripcion</label>
                        <input type="text" class="form-control" id="descripcion_servicio" name="descripcion_servicio" placeholder="Ingrese Descripcion" required>
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