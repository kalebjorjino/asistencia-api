<div id="modalOficina" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-white" id="mdltitulo"></h4>
            </div>
            <form method="post" id="oficina_form">
                <div class="modal-body">
                    <input type="hidden" id="id_oficina" name="id_oficina">

                    <div class="form-group">
                        <label class="form-label" for="nombre_oficina">Oficina</label>
                        <input type="text" class="form-control" id="nombre_oficina" name="nombre_oficina" placeholder="Ingrese Nombre de la Oficina" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="direccion_oficina">Descripcion</label>
                        <input type="text" class="form-control" id="direccion_oficina" name="direccion_oficina" placeholder="Ingrese Descripcion" required>
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