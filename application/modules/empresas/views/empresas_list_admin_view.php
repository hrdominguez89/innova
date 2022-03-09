<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url(); ?>home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Listado de Empresas</li>
                    </ol>
                </nav>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">apartment</i>
                        </div>
                        <h4 class="card-title ">Lista de empresas</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar mb-3 border-bottom pb-2">
                        </div>
                        <div class="material-datatables">
                            <table data-fix-header="true" id="dataTableComun" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Razón social</th>
                                        <th>Nombre</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Teléfono</th>
                                        <th class="text-center">Perfil</th>
                                        <th class="text-center">Fecha alta</th>
                                        <th class="text-center">Ult. login</th>
                                        <th class="text-center">Cant. desafíos</th>
                                        <th class="text-center">Cant. postulados</th>
                                        <th class="text-center">Cant. Matcheos</th>
                                        <th class="disabled-sorting text-center" style="width:100px">Acción</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Razón social</th>
                                        <th>Nombre</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Teléfono</th>
                                        <th class="text-center">Perfil</th>
                                        <th class="text-center">Fecha alta</th>
                                        <th class="text-center">Ult. login</th>
                                        <th class="text-center">Cant. desafíos</th>
                                        <th class="text-center">Cant. postulados</th>
                                        <th class="text-center">Cant. Matcheos</th>
                                        <th class="disabled-sorting text-center" style="width:100px">Acción</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php if (!@$empresas) :; ?>
                                        <tr>
                                            <td colspan="9" class="text-center">No hay empresas registradas</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($empresas as $empresa) :; ?>
                                            <tr id="row_empresa_id_<?php echo $empresa->usuario_id; ?>">

                                                <td><?php echo $empresa->razon_social; ?></td>
                                                <td><?php echo $empresa->apellido . ' ' . $empresa->nombre; ?></td>
                                                <td class="text-center"><?php echo $empresa->email; ?></td>
                                                <td class="text-center"><?php echo $empresa->telefono; ?></td>
                                                <td class="text-center"><?php echo $empresa->perfil_completo ? 'Completo' : 'Incompleto'; ?></td>
                                                <td class="text-center dt-nowrap"><?php echo date('d-m-Y', strtotime($empresa->fecha_alta)); ?></td>
                                                <td class="text-center dt-nowrap"><?php echo date('d-m-Y', strtotime($empresa->ultimo_login)); ?></td>
                                                <td class="text-center"><?php echo $empresa->cantidad_de_desafios; ?></td>
                                                <td class="text-center"><?php echo $empresa->cantidad_de_postulaciones; ?></td>
                                                <td class="text-center"><?php echo $empresa->cantidad_de_matcheos; ?></td>
                                                <td class="text-center dt-nowrap">
                                                    <a class="m-1" href="<?php echo base_url(); ?>empresas/ver/<?php echo $empresa->usuario_id; ?>"><i class="fas fa-eye"></i></a>

                                                    <?php if ($this->session->userdata('user_data')->rol_id == ROL_ADMIN_PLATAFORMA) : ?>
                                                        <?php if ($empresa->estado_id == USR_PENDING) : ?>
                                                            <span class="text-warning m-1" title="Usuario pendiente de validación."><i class="fas fa-user-clock"></i></span>
                                                        <?php elseif ($empresa->estado_id == USR_ENABLED || $empresa->estado_id == USR_VERIFIED) : ?>
                                                            <a class="text-success m-1" id="cambiar_estado_usuario_id_<?php echo $empresa->usuario_id; ?>" onclick="cambiarEstadoUsuario(this)" data-estado="activado" data-usuario-id="<?php echo $empresa->usuario_id; ?>" href="javascript:void(0);" title="Activado"><i class="fas fa-toggle-on"></i></a>
                                                        <?php else : /*USR_DISABLED*/ ?>
                                                            <a class="text-dark m-1" id="cambiar_estado_usuario_id_<?php echo $empresa->usuario_id; ?>" onclick="cambiarEstadoUsuario(this)" data-estado="desactivado" data-usuario-id="<?php echo $empresa->usuario_id; ?>" href="javascript:void(0);" title="Desactivado"><i class="fas fa-toggle-off"></i></a>
                                                        <?php endif; ?>
                                                        <a class="text-danger m-1" onclick="eliminarEmpresaModal(this)" data-nombre-empresa="<?php echo $empresa->razon_social; ?>" data-usuario-id="<?php echo $empresa->usuario_id; ?>" href="javascript:void(0);" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalEliminarEmpresa" tabindex="-1" role="dialog" aria-labelledby="modalEliminarEmpresaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarEmpresaLabel">Eliminar empresa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Esta a punto de eliminar esta empresa: <span id="nombre_de_la_empresa_modal"></span><br>
                Una vez eliminado no podra revertir estos cambios.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default m-2" data-dismiss="modal">Cancelar</button>
                <button type="button" id="botonEliminarEmpresa" onclick="eliminarEmpresa(this)" data-usuario-id="" class="btn btn-danger m-2">Eliminar</button>
            </div>
        </div>
    </div>
</div>