<div id="modalEmpleado" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-white" id="mdltitulo"></h4>
            </div>
            <form method="post" id="empleado_form">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="usu_id" name="usu_id" value="<?php echo $_SESSION["usu_id"] ?>">

                    <div class="form-group">
                        <label class="form-label" for="dni">DNI</label>
                        <input type="text" class="form-control" id="dni" name="dni" placeholder="Ingrese DNI" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="nombre">Nombres Completos</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese Nombre" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="profesion">Profesion</label>
                        <input type="text" class="form-control" id="profesion" name="profesion" placeholder="Ingrese Profesion" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="id_departamento">Departamento</label>
                        <select id="id_departamento" name="id_departamento" class="form-control" required="required">
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="id_unidad">Unidad</label>
                        <select id="id_unidad" name="id_unidad" class="form-control" required="required">
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="id_oficina">Oficina (Opcional)</label>
                        <select id="id_oficina" name="id_oficina" class="form-control" >
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="id_servicio">Servicio (Opcional</label>
                        <select id="id_servicio" name="id_servicio" class="form-control" >
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
