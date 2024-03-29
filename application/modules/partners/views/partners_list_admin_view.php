<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url(); ?>home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Listado de Partners</li>
                    </ol>
                </nav>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">groups</i>
                        </div>
                        <h4 class="card-title ">Lista de partners</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar mb-3 border-bottom pb-2">
                        </div>
                        <div class="material-datatables">
                            <table data-fix-header="true" id="dataTableComun" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width:20%">Razón Social</th>
                                        <th style="width:20%">Nombre de contacto</th>
                                        <th style="width:20%">Tipo de partner</th>
                                        <th style="width: 30%;">Teléfono</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Perfil</th>
                                        <th class="text-center">Fecha alta</th>
                                        <th class="text-center">Ult. Login</th>
                                        <th class="text-center">Cant. desafíos compartidos</th>
                                        <th class="disabled-sorting text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="width:20%">Razón Social</th>
                                        <th style="width:20%">Nombre de contacto</th>
                                        <th style="width:20%">Tipo de partner</th>
                                        <th style="width: 30%;">Teléfono</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Perfil</th>
                                        <th class="text-center">Fecha alta</th>
                                        <th class="text-center">Ult. Login</th>
                                        <th class="text-center">Cant. desafíos compartidos</th>
                                        <th class="disabled-sorting text-center">Acción</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php if (!@$partners) :; ?>
                                        <tr>
                                            <td colspan="10" class="text-center">No hay partners registradas</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($partners as $partner) :; ?>
                                            <tr id="row_partner_id_<?php echo $partner->usuario_id; ?>">
                                                <td><?php echo $partner->razon_social; ?></td>
                                                <td><?php echo $partner->nombre . ' ' . $partner->apellido; ?></td>
                                                <td><?php echo $partner->descripcion_tipo_de_partner; ?></td>
                                                <td><?php echo $partner->telefono; ?></td>
                                                <td><?php echo $partner->email; ?></td>
                                                <td class="text-center"><?php echo $partner->perfil_completo ? 'Completo' : 'Incompleto'; ?></td>
                                                <td class="text-center dt-nowrap"><?php echo date('d-m-Y', strtotime($partner->fecha_alta)); ?></td>
                                                <td class="text-center dt-nowrap"><?php echo date('d-m-Y', strtotime($partner->ultimo_login)); ?></td>
                                                <td class="text-center"><?php echo $partner->desafios_compartidos; ?></td>
                                                <td class="text-center dt-nowrap">
                                                    <a class="m-1" href="<?php echo base_url(); ?>partners/ver/<?php echo $partner->usuario_id; ?>"><i class="fas fa-eye"></i></a>

                                                    <?php if ($this->session->userdata('user_data')->rol_id == ROL_ADMIN_PLATAFORMA) : ?>
                                                        <?php if ($partner->id_estado_usuario == USR_PENDING) : ?>
                                                            <span class="text-warning m-1" title="Usuario pendiente de validación."><i class="fas fa-user-clock"></i></span>
                                                        <?php elseif ($partner->id_estado_usuario == USR_ENABLED || $partner->id_estado_usuario == USR_VERIFIED) : ?>
                                                            <a class="text-success m-1" id="cambiar_estado_usuario_id_<?php echo $partner->usuario_id; ?>" onclick="cambiarEstadoUsuario(this)" data-estado="activado" data-usuario-id="<?php echo $partner->usuario_id; ?>" href="javascript:void(0);" title="Activado"><i class="fas fa-toggle-on"></i></a>
                                                        <?php else : /*USR_DISABLED*/ ?>
                                                            <a class="text-dark m-1" id="cambiar_estado_usuario_id_<?php echo $partner->usuario_id; ?>" onclick="cambiarEstadoUsuario(this)" data-estado="desactivado" data-usuario-id="<?php echo $partner->usuario_id; ?>" href="javascript:void(0);" title="Desactivado"><i class="fas fa-toggle-off"></i></a>
                                                        <?php endif; ?>
                                                        <a class="text-danger m-1" onclick="eliminarPartnerModal(this)" data-nombre-partner="<?php echo $partner->razon_social; ?>" data-usuario-id="<?php echo $partner->usuario_id; ?>" href="javascript:void(0);" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>
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

<div class="modal fade" id="modalEliminarPartner" tabindex="-1" role="dialog" aria-labelledby="modalEliminarPartnerLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarPartnerLabel">Eliminar partner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Esta a punto de eliminar este partner: <span id="nombre_de_la_partner_modal"></span><br>
                Una vez eliminado no podra revertir estos cambios.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default m-2" data-dismiss="modal">Cancelar</button>
                <button type="button" id="botonEliminarPartner" onclick="eliminarPartner(this)" data-usuario-id="" class="btn btn-danger m-2">Eliminar</button>
            </div>
        </div>
    </div>
</div>