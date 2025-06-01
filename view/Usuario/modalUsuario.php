<div id="modalUsuario" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-white" id="mdltitulo"></h4>
            </div>
            <form method="post" id="usuario_form">
                <div class="modal-body">
                    <input type="hidden" id="usu_id" name="usu_id">

                    <div class="form-group">
                        <label class="form-label" for="usu_nom">Empleado</label>
                        <select id="id_empleado" name="id_empleado" class="form-control" required="required">
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="usu_correo">Correo Electronico</label>
                        <input type="email" class="form-control" id="usu_correo" name="usu_correo" placeholder="Ingrese Correo" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="usu_pass">Contraseña</label>
                        <input type="password" class="form-control" id="usu_pass" name="usu_pass" placeholder="************" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="rol_id">Rol</label>
                        <select class="form-control" id="rol_id" name="rol_id">
                            <option value="2">Administrador</option>
                            <option value="1">Supervisor</option>
                        </select>
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
