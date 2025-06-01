<div id="modalUnidad" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-white" id="mdltitulo"></h4>
            </div>
            <form method="post" id="unidad_form">
                <div class="modal-body">
                    <input type="hidden" id="id_unidad" name="id_unidad">

                    <div class="form-group">
                        <label class="form-label" for="id_departamento">Departamento</label>
                        <select id="id_departamento" name="id_departamento" class="form-control" required="required">
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="nombre_unidad">Unidad</label>
                        <input type="text" class="form-control" id="nombre_unidad" name="nombre_unidad" placeholder="Ingrese Nombre de la Unidad" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="descripcion_unidad">Descripcion</label>
                        <input type="text" class="form-control" id="descripcion_unidad" name="descripcion_unidad" placeholder="Ingrese Descripcion" required>
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