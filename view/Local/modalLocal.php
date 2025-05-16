<div id="modalLocal" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-white" id="mdltitulo"></h4>
            </div>
            <form method="post" id="local_form">
                <div class="modal-body">
                    <input type="hidden" id="local_id" name="local_id">

                    <div class="form-group">
                        <label class="form-label" for="local_nom">Local</label>
                        <input type="text" class="form-control" id="local_nom" name="local_nom" placeholder="Ingrese Local" required>
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
