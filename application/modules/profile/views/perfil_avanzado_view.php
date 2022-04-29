<div class="col-md-8">


    <div id="opcionesAvanzadas" role="tablist">
        <?php if ($this->session->userdata('user_data')->rol_id != ROL_PARTNER) :; ?>
            <div class="card card-collapse">
                <div class="card-header p-2" role="tab" id="cambiarRolHead">
                    <h5 class="mb-0 pl-2">
                        <a data-toggle="collapse" href="#cambiarRolBody" aria-expanded="false" aria-controls="cambiarRolBody">
                            Cambiar de rol
                            <i class="material-icons">keyboard_arrow_down</i>
                        </a>
                    </h5>
                </div>

                <div id="cambiarRolBody" class="collapse border <?php echo @$collapse_cambiar_rol ? 'show' : ''; ?>" role="tabpanel" aria-labelledby="cambiarRolHead" data-parent="#opcionesAvanzadas">
                    <div class="card-body bg-white p-3">
                        <p>Estimado usuario, al cambiar de rol se eliminaran los datos cargados en su rol actual y no podrán recuperarse.</p>
                        <div>
                            <form method="post" action="">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="bmd-label-floating" for="rol">Elija un rol: <small class="text-danger">*</small></label>
                                        <select id="rol" class="select_chosen" name="rol" title="Elija un rol" data-size="9" tabindex="-98" required>
                                            <?php
                                            $roles = [1 => 'Startup', 2 => 'Empresa'];
                                            foreach ($roles as $rol_id => $rol_descripcion) :
                                                if ($rol_id != $this->session->userdata('user_data')->rol_id) :
                                            ?>
                                                    <option value="<?php echo $rol_id; ?>" <?php echo @$this->input->post('rol') == $rol_id ? 'selected' : ''; ?>> <?php echo $rol_descripcion; ?> </option>
                                            <?php
                                                endif;
                                            endforeach;
                                            ?>
                                        </select>
                                        <?php echo form_error('rol'); ?>
                                    </div>
                                </div>
                                <div class="row text-right">
                                    <div class="col-12">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cambiarRolModal">
                                            Cambiar rol
                                        </button>
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="cambiarRolModal" tabindex="-1" role="dialog" aria-labelledby="cambiarRolModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="cambiarRolModalLabel">Cambiar rol</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Esta seguro que desea cambiar de rol?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default m-2" data-dismiss="modal">Cerrar</button>
                                                <input type="hidden" name="formulario" value="cambiar_rol">
                                                <button type="submit" class="btn btn-primary m-2">Si, cambiar rol</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="card card-collapse">
            <div class="card-header p-2" role="tab" id="eliminarCuentaHead">
                <h5 class="mb-0 pl-2">
                    <a class="collapsed" data-toggle="collapse" href="#eliminarCuentaBody" aria-expanded="false" aria-controls="eliminarCuentaBody">
                        Eliminar cuenta
                        <i class="material-icons">keyboard_arrow_down</i>
                    </a>
                </h5>
            </div>
            <div id="eliminarCuentaBody" class="collapse border <?php echo @$collapse_eliminar_cuenta ? 'show' : ''; ?>" role="tabpanel" aria-labelledby="eliminarCuentaHead" data-parent="#opcionesAvanzadas">
                <div class="card-body bg-white p-3">
                    <p>Estimado usuario, al eliminar la cuenta se borrarán los datos cargados y no podra recuperarlos.</p>
                    <form method="post" action="">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating" for="password">Contraseña <small class="text-danger">*</small></label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <small>Escriba su contraseña para confirmar la eliminación de su cuenta.</small>
                                    <?php echo form_error('password'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row text-right">
                            <div class="col-12">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#eliminarCuentaModal">
                                    Eliminar cuenta
                                </button>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="eliminarCuentaModal" tabindex="-1" role="dialog" aria-labelledby="eliminarCuentaModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="eliminarCuentaModalLabel">Eliminar cuenta</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Esta seguro que desea eliminar su cuenta?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default m-2" data-dismiss="modal">Cerrar</button>
                                        <input type="hidden" name="formulario" value="eliminar_cuenta">
                                        <button type="submit" class="btn btn-primary m-2">Si, eliminar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>