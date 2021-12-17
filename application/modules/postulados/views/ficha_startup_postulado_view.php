<div class="content mb-5">
  <div class="container-fluid">
    <div class="row">
      <?php if ($this->session->userdata('user_data')) :; ?>
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>home">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo base_url(); ?>postulados">Postulados</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo base_url(); ?>postulados/desafio/<?php echo $startup->desafio_id; ?>"><?php echo $startup->nombre_del_desafio; ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $startup->razon_social; ?> </li>
              </ol>
            </nav>
          </div>
        </div>
      <?php endif; ?>
      <div class="col-md-12 mb-5">
      </div>
      <div class="col-md-8">
        <div class="card">
          <div class="card-header card-header-icon card-header-primary">
            <div class="card-icon">
              <img class="img-fluid" style="max-width:100px" src="<?php echo base_url(); ?>uploads/imagenes_de_usuarios/<?php echo $startup->usuario_id; ?>.png">
            </div>
            
            <h3 class="card-title font-weight-bold"><?php echo $startup->razon_social; ?></h3>
            <?php switch ($startup->estado_postulacion) {
              case POST_PENDIENTE:
                $color_badge = 'warning';
                break;
              case POST_VALIDADO:
                $color_badge = 'success';
                break;
              case POST_ACEPTADO:
                $color_badge = 'success';
                break;
              case POST_RECHAZADO:
                $color_badge = 'danger';
                break;
              case POST_CANCELADO:
                $color_badge = 'danger';
                break;
            }; ?>
            
            <?php if($startup->estado_postulacion == POST_VALIDADO):;?>
            <span class="badge badge-<?php echo $color_badge; ?> mb-2">Startup validada por la organización </b></span><i class="fas fa-medal medalla-gold-color"></i>
            <?php elseif($startup->estado_postulacion == POST_ACEPTADO):;?>
            <span class="badge badge-<?php echo $color_badge; ?> mb-2">Startup validada por la organización </b></span><i class="fas fa-medal medalla-gold-color"></i>
            <span class="badge badge-<?php echo $color_badge; ?> mt-2">Startup contactada </b></span> <i class="material-icons contacto-color">connect_without_contact</i>
            <?php else:;?>
            <span class="badge badge-<?php echo $color_badge; ?>">Validación:</b> <?php echo $startup->nombre_estado_postulacion; ?></span>
            <?php endif;?>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <div class="mb-3">
                  <p class=""><b class="text-primary font-weight-bold">Titular:</b> <?php echo $startup->titular; ?></p>
                </div>
              </div>
              <div class="col-12">
                <div class="mb-3">
                  <p class=""><b class="text-primary font-weight-bold">CUIT:</b> <?php echo $startup->cuit; ?></p>
                </div>
              </div>
              <div class="col-12">
                <div class="mb-3">
                  <p class=""><b class="text-primary font-weight-bold">Descripción:</b> <?php echo $startup->descripcion; ?></p>
                </div>
              </div>
              <div class="col-12">
                <div class="mb-3">
                  <p class=""><b class="text-primary font-weight-bold">Antecedentes:</b> <?php echo $startup->antecedentes; ?></p>
                </div>
              </div>

              <div class="col-12">
                <div class="mb-3">
                  <p class=""><b class="text-primary font-weight-bold">¿Exporta?:</b> <?php echo $startup->exporta; ?></p>
                </div>
              </div>
              <div class="col-12">
                <div class="mb-3">
                  <p class=""><b class="text-primary font-weight-bold">Servicios / Productos que ofrece:</b> <?php echo $startup->nombre_de_categorias; ?></p>
                </div>
              </div>
              <div class="col-12">
                <div class="mb-3">
                  <p class=""><b class="text-primary font-weight-bold">Rubro:</b> <?php echo $startup->rubro; ?></p>
                </div>
              </div>
              <div class="col-12">
                <div class="mb-3">
                  <p class=""><b class="text-primary font-weight-bold">País:</b> <?php echo $startup->pais; ?></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <p class=""><b class="text-primary font-weight-bold">Pronvicia/Estado:</b> <?php echo $startup->provincia; ?></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <p class=""><b class="text-primary font-weight-bold">Localidad:</b> <?php echo $startup->localidad; ?></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="mb-3">
                  <p class=""><b class="text-primary font-weight-bold">Desafío al que se postula:</b> <?php echo $startup->nombre_del_desafio; ?></p>
                </div>
              </div>
              <div class="col-12">
                <div class="mb-3">
                  <p class=""><b class="text-primary font-weight-bold">Descripción del desafio:</b> <?php echo $startup->descripcion_del_desafio; ?></p>
                </div>
              </div>
              <div class="col-12">
                <div class="mb-3">
                  <p class=""><b class="text-primary font-weight-bold">Requisitos del desafio:</b> <?php echo $startup->requisitos_del_desafio; ?></p>
                </div>
              </div>
            </div>

            <?php if ($startup->desafio_estado_id == DESAF_FINALIZADO && $startup->estado_postulacion == POST_VALIDADO && $startup->contacto_id == NULL) :; ?>
              <div class="row text-right">
                <div class="col-md-12 mt-5 mb-2" id="botonContactar" style="display: block;">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalContactar">Contactar</button>
                </div>
              </div>
              <!-- Modal -->
              <div class="modal fade" id="modalContactar" tabindex="-1" role="dialog" aria-labelledby="modalContactarLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="" id="modalContactarLabel">Contactar a <?php echo $startup->razon_social; ?></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      ¿Está seguro que desea contactar a esta startup?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default m-2" data-dismiss="modal">Cancelar</button>
                      <button type="button" id="botonContactarModal" data-startup-id="<?php echo $startup->usuario_id; ?>" data-desafio-id="<?php echo $startup->desafio_id; ?>" class="btn btn-primary m-2">Si, contactar</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" id="datosDeContacto" style="display: none;">
                <hr>
                <div class="col-12">
                  <h3 class="card-title font-weight-bold">Datos de contacto</h3>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <p class=""><b class="text-primary font-weight-bold">Nombre:</b> <span id="dataContactoNombre"></span></p>
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <p class=""><b class="text-primary font-weight-bold">Apellido:</b> <span id="dataContactoApellido"></span></p>
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <p class=""><b class="text-primary font-weight-bold">Email:</b> <span id="dataContactoEmail"></span></p>
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <p class=""><b class="text-primary font-weight-bold">Telefono:</b> <span id="dataContactoTelefono"></span></p>
                  </div>
                </div>
              </div>
            <?php elseif ($startup->contacto_id != NULL || $startup->estado_postulacion == POST_ACEPTADO) :; ?>
              <hr>
              <div class="row">
                <div class="col-12">
                  <h3 class="card-title font-weight-bold">Datos de contacto</h3>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <p class=""><b class="text-primary font-weight-bold">Nombre:</b> <?php echo $startup->nombre; ?></p>
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <p class=""><b class="text-primary font-weight-bold">Apellido:</b> <?php echo $startup->apellido; ?></p>
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <p class=""><b class="text-primary font-weight-bold">Email:</b> <?php echo $startup->email_contacto; ?></p>
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <p class=""><b class="text-primary font-weight-bold">Telefono:</b> <?php echo $startup->telefono_contacto; ?></p>
                  </div>
                </div>
              </div>
            <?php endif; ?>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>