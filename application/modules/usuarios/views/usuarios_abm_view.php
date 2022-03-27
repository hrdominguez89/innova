<div class="modal fade" id="modalCrearUsuario" tabindex="-1" role="dialog" aria-labelledby="modalCrearUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="font-weight-bold" id="modalCrearUsuarioLabel">Crear usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="crearUsuarioForm">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="nombre">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="apellido">Apellido <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="email">E-mail <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="rol_id">Rol <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <select class="select_chosen" title="Seleccione un rol" data-style="btn btn-sm btn-primary" id="rol_id" name="rol_id" required>
                                    <option disabled selected hidden>Seleccione un rol</option>
                                    <option value="3">Validador</option>
                                    <option value="4">Admin Plataforma</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-danger" id="errorCrearUsuarioModal" style="display: none;"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default m-2" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary m-2" id="botonCrearUsuario">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="font-weight-bold" id="modalEditarUsuarioLabel">Editar usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editarUsuarioForm">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input type="hidden" name="usuario_id" id="edidarUsuarioId">
                            <label for="nombre_editar">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre_editar" name="nombre" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="apellido_editar">Apellido <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="apellido_editar" name="apellido" required>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="email_editar">E-mail <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email_editar" name="email" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="rol_id_editar">Rol <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <select class="select_chosen" title="Seleccione un rol" data-style="btn btn-sm btn-primary" id="rol_id_editar" name="rol_id" required>
                                    <option disabled selected hidden>Seleccione un rol</option>
                                    <option value="3">Validador</option>
                                    <option value="4">Admin Plataforma</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="reset_password" value="TRUE">
                                Reiniciar contraseña
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="text-danger" id="errorEditarUsuarioModal" style="display: none;"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default m-2" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary m-2" id="botonGuardarUsuario">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="<?php base_url(); ?>home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">people_outline</i>
                        </div>
                        <h4 class="card-title">Lista de usuarios</h4>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="col-12 text-right mt-3 mb-2">
                            <button class="btn btn-primary" id="botonCrearUsuarioModal">Crear usuario</button>
                        </div>
                        <div class="material-datatables">
                            <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%" id="dataTableUsuarios">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Email</th>
                                        <th>Tipo de usuario</th>
                                        <th>Razón social</th>
                                        <th>Descripción</th>
                                        <th>Fecha alta</th>
                                        <th>Estado</th>
                                        <th class="text-center no-sort" width="80px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('modals/usuarios/eliminar_usuario_modal_view');?>