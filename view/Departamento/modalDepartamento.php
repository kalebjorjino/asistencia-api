<div id="modalDepartamento" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-white" id="mdltitulo"></h4>
            </div>
            <form method="post" id="departamento_form">
                <div class="modal-body">
                    <input type="hidden" id="id_departamento" name="id_departamento">

                    <div class="form-group">
                        <label class="form-label" for="nombre_departamento">Departamento</label>
                        <input type="text" class="form-control" id="nombre_departamento" name="nombre_departamento" placeholder="Ingrese Nombre del Departamento" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="descripcion_departamento">Descripcion</label>
                        <input type="text" class="form-control" id="descripcion_departamento" name="descripcion_departamento" placeholder="Ingrese Descripcion" required>
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