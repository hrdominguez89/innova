<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url(); ?>home">Home</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url(); ?>startups">Startups</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $startup->razon_social; ?></li>
                    </ol>
                </nav>
            </div>
            <div class="col-xl-12">
                <div class="col-md-12 my-5 d-flex align-items-stretch">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <img class="img bg-white" src="<?php echo $startup->logo ? base_url() . 'uploads/imagenes_de_usuarios/' . $startup->usuario_id . '.png?v=' . rand() : base_url() . 'assets/img/usuario.jpeg?v=' . rand(); ?>">
                        </div>
                        <div class="card-body">
                            <h2 class="card-category text-gray"><?php echo $startup->razon_social; ?> </h2>
                            <div class="row">
                                <div class="col-12 text-justify">
                                    <h3>Datos de contacto</h3>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Nombre:</b> <?php echo $startup->apellido . ' ' . $startup->nombre; ?>
                                    </p>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Email:</b> <?php echo $startup->email_contacto; ?>
                                    </p>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Teléfono:</b> <?php echo $startup->telefono_contacto; ?>
                                    </p>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Titular:</b> <?php echo $startup->titular; ?>
                                    </p>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">C.U.I.T.:</b> <?php echo $startup->cuit; ?>
                                    </p>
                                    <hr>
                                    <h3>Datos de la startup</h3>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Servicios/Productos que ofrece:</b> <?php echo $startup->nombre_de_categorias; ?>
                                    </p>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Rubro:</b> <?php echo $startup->rubro; ?>
                                    </p>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Información de la empresa:</b> <?php echo $startup->descripcion; ?>
                                    </p>

                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">E-mail empresa:</b> <?php echo $startup->email_empresa; ?>
                                    </p>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Teléfono empresa:</b> <?php echo $startup->telefono_empresa; ?>
                                    </p>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Pais:</b> <?php echo $startup->pais; ?>
                                    </p>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Provincia:</b> <?php echo $startup->provincia; ?>
                                    </p>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Localidad:</b> <?php echo $startup->localidad; ?>
                                    </p>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Dirección:</b> <?php echo $startup->direccion; ?>
                                    </p>

                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Antecedentes: </b><?php echo $startup->antecedentes; ?>
                                    </p>

                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">¿Exporta?: </b><?php echo $startup->exporta; ?>
                                    </p>

                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Sitio Web: </b><?php echo $startup->url_web; ?>
                                    </p>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">YouTube </b><?php echo $startup->url_youtube; ?>
                                    </p>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Facebook </b><?php echo $startup->url_facebook; ?>
                                    </p>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Instagram </b><?php echo $startup->url_instagram; ?>
                                    </p>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Twitter </b><?php echo $startup->url_twitter; ?>
                                    </p>

                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Objetivo/motivo por el que se registró en RIA: </b><?php echo $startup->objetivo_y_motivacion; ?>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 card">
                    <div class="toolbar mb-3 border-bottom pb-2">
                        <h3>Postulaciones</h3>
                    </div>
                    <div class="material-datatables">
                        <table id="dataTableComun" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Desafío nombre</th>
                                    <th>Empresa</th>
                                    <th class="text-center">Estado postulación</th>
                                    <th class="text-center">Fecha postulacion</th>
                                    <th class="text-center">Estado desafío</th>
                                    <th class="disabled-sorting ">Acción</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Desafío nombre</th>
                                    <th>Empresa</th>
                                    <th class="text-center">Estado postulación</th>
                                    <th class="text-center">Fecha postulacion</th>
                                    <th class="text-center">Estado desafío</th>
                                    <th class="disabled-sorting ">Acción</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php if (!$postulaciones) :; ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No hay postulaciones registradas</td>
                                    </tr>
                                <?php else :; ?>
                                    <?php foreach ($postulaciones as $postulaciones) :; ?>
                                        <tr>
                                            <td><?php echo $postulaciones->nombre_del_desafio; ?></td>
                                            <td><?php echo $postulaciones->nombre_empresa; ?></td>
                                            <td class="text-center"><?php echo $postulaciones->estado_postulacion_nombre; ?></td>
                                            <td class="text-center"><?php echo date('d-m-Y', strtotime($postulaciones->fecha_postulacion)); ?></td>
                                            <td class="text-center"><?php echo $postulaciones->desafio_estado_descripcion; ?></td>
                                            <td class="text-center"><a href="<?php echo base_url() . 'postulados/startup/' . $startup->usuario_id . '/' . $postulaciones->desafio_id; ?>"><i class="far fa-eye"></i>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--  end card  -->
            </div>
        </div>
    </div>
</div>