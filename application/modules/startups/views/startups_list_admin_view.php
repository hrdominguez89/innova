<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url(); ?>home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Listado de Startups</li>
                    </ol>
                </nav>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">store</i>
                        </div>
                        <h4 class="card-title ">Lista de startups</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar mb-3 border-bottom pb-2">
                        </div>
                        <div class="material-datatables">
                            <table id="dataTableComun" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width:20%">Razón Social</th>
                                        <th style="width:20%">Nombre de contacto</th>
                                        <th style="width: 30%;">Teléfono</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Perfil</th>
                                        <th class="text-center">Fecha alta</th>
                                        <th class="text-center">Ult. Login</th>
                                        <th class="text-center">Cant. Postulaciones</th>
                                        <th class="text-center">Cant. Matcheos</th>
                                        <th class="disabled-sorting text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="width:20%">Razón Social</th>
                                        <th style="width:20%">Nombre de contacto</th>
                                        <th style="width: 30%;">Teléfono</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Perfil</th>
                                        <th class="text-center">Fecha alta</th>
                                        <th class="text-center">Ult. Login</th>
                                        <th class="text-center">Cant. Postulaciones</th>
                                        <th class="text-center">Cant. Matcheos</th>
                                        <th class="disabled-sorting text-center">Acción</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php if (!@$startups) :; ?>
                                        <tr>
                                            <td colspan="9" class="text-center">No hay startups registradas</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($startups as $startup) :; ?>
                                            <tr id="row_startup_id_<?php echo $startup->usuario_id;?>">
                                                <td><?php echo $startup->razon_social; ?></td>
                                                <td><?php echo $startup->nombre . ' ' . $startup->apellido; ?></td>
                                                <td><?php echo $startup->telefono; ?></td>
                                                <td><?php echo $startup->email; ?></td>
                                                <td class="text-center"><?php echo $startup->perfil_completo ? 'Completo' : 'Incompleto'; ?></td>
                                                <td class="text-center dt-nowrap"><?php echo date('d-m-Y', strtotime($startup->fecha_alta)); ?></td>
                                                <td class="text-center dt-nowrap"><?php echo date('d-m-Y', strtotime($startup->ultimo_login)); ?></td>
                                                <td class="text-center"><?php echo $startup->cantidad_de_postulaciones; ?></td>
                                                <td class="text-center"><?php echo $startup->cantidad_de_matcheos; ?></td>
                                                <td class="text-center dt-nowrap">
                                                    <a class="m-1" href="<?php echo base_url(); ?>startups/ver/<?php echo $startup->usuario_id; ?>"><i class="fas fa-eye"></i></a>

                                                    <?php if ($this->session->userdata('user_data')->rol_id == ROL_ADMIN_PLATAFORMA) : ?>
                                                        <?php if ($startup->estado_id == USR_PENDING) : ?>
                                                            <span class="text-warning m-1" title="Usuario pendiente de validación."><i class="fas fa-user-clock"></i></span>
                                                        <?php elseif ($startup->estado_id == USR_ENABLED || $startup->estado_id == USR_VERIFIED) : ?>
                                                            <a class="text-success m-1" id="cambiar_estado_usuario_id_<?php echo $startup->usuario_id;?>" onclick="cambiarEstadoUsuario(this)"data-estado="activado"  data-usuario-id="<?php echo $startup->usuario_id;?>" href="javascript:void(0);" title="Activado"><i class="fas fa-toggle-on"></i></a>
                                                        <?php else : /*USR_DISABLED*/ ?>
                                                            <a class="text-dark m-1" id="cambiar_estado_usuario_id_<?php echo $startup->usuario_id;?>" onclick="cambiarEstadoUsuario(this)"data-estado="desactivado"  data-usuario-id="<?php echo $startup->usuario_id;?>" href="javascript:void(0);" title="Desactivado"><i class="fas fa-toggle-off"></i></a>
                                                        <?php endif; ?>
                                                        <a class="text-danger m-1" onclick="eliminarStartupModal(this)" data-nombre-startup="<?php echo $startup->razon_social;?>" data-usuario-id="<?php echo $startup->usuario_id;?>" href="javascript:void(0);" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></a>
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

<div class="modal fade" id="modalEliminarStartup" tabindex="-1" role="dialog" aria-labelledby="modalEliminarStartupLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEliminarStartupLabel">Eliminar startup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Esta a punto de eliminar esta startup: <span id="nombre_de_la_startup_modal"></span><br>
        Una vez eliminado no podra revertir estos cambios.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary m-2" data-dismiss="modal">Cancelar</button>
        <button type="button" id="botonEliminarStartup" onclick="eliminarStartup(this)" data-usuario-id="" class="btn btn-danger m-2">Eliminar</button>
      </div>
    </div>
  </div>
</div>
