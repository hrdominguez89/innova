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
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $startup->nombre_del_desafio; ?> </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $startup->razon_social; ?> </li>

                            </ol>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-md-12 mb-5">
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon card-header-primary">
                        <div class="card-icon">
                            <img class="img-fluid" style="max-width:100px" src="<?php echo base_url(); ?>uploads/imagenes_de_usuarios/<?php echo $startup->usuario_id; ?>.png">
                        </div>
                        <h3 class="card-title font-weight-bold"><?php echo $startup->razon_social; ?></h3>
                        <?php if ($validacion) :; ?>
                            <span class="badge badge-success">Validado</span>
                        <?php else :; ?>
                            <span class="badge badge-warning">Validación pendiente</span>
                        <?php endif; ?>
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
                        <hr>
                        <?php if (!$validacion) :; ?>
                            <form method="post">
                                <input type="hidden" value="<?php echo $startup->postulacion_id; ?>" name="postulacion_id">
                                <div class="row">
                                    <div class="col-12">
                                        <h3 class="card-title font-weight-bold">Validar postulación</h3>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <div class="dropdown bootstrap-select show-tick">
                                            <select class="select_chosen" id="selectValidarPostulacion" name="validar_postulacion" data-style="select-with-transition" title="Seleccione un estado" data-size="7" tabindex="-98" required>
                                                <option hidden selected disabled <?php echo set_select('validar_postulacion', '', true); ?>> Seleccione un estado</option>
                                                <option value="<?php echo POST_VALIDADO; ?>" <?php echo set_select('validar_postulacion', POST_VALIDADO); ?> <?php echo @$validacion ? 'selected' : ''; ?>> Validado</option>
                                            </select>
                                            <?php echo form_error('validar_postulacion'); ?>
                                        </div>
                                    </div>
                                    <div class="col-12 text-right">
                                        <button type="submit" class="btn btn-primary">Validar</button>
                                    </div>
                                </div>
                            </form>
                        <?php else :; ?>
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="card-title font-weight-bold">Postulación validada el <?php echo date('d-m-Y', strtotime($validacion->fecha_alta_validacion)); ?></h3>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 text-right">
                <a href="<?php echo base_url().'postulados';?>" class="btn btn-dafault">Volver</a>
            </div>
        </div>
    </div>
</div>