<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="content mb-5">
    <div class="container-fluid">
        <div class="row">
            <?php if ($this->session->userdata('user_data')) :; ?>
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>home">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Postulaciones </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-md-12 mb-5">
            </div>
            <?php if (!$desafios) : ?>
                <div class="col-12 text-center">
                    <h3 class="font-weight-bold">Aún no hay postulaciones realizadas.</h3>
                    <a href="<?php echo base_url() . 'home'; ?>" class="btn btn-primary m-5">Volver al inicio</a>
                </div>
            <?php endif; ?>
            <?php foreach ($desafios as $desafio) :; ?>
                <?php if ($desafio->desafio_id) :; ?>
                    <div class="col-md-6 mb-5 d-flex align-items-stretch">
                        <div class="card card-profile">
                            <div class="card-avatar">
                                <img class="img bg-white" src="<?php echo $desafio->logo ? base_url() . 'uploads/imagenes_de_usuarios/' . $desafio->id_empresa . '.png?v=' . rand() : base_url() . 'assets/img/usuario.jpeg?v=' . rand(); ?>">
                            </div>
                            <div class="card-body">
                                <h2 class="card-category text-gray"><?php echo $desafio->nombre_empresa; ?> </h2>
                                <h3 class="card-category text-gray"><?php echo $desafio->nombre_del_desafio; ?></h3>
                                <div class="row">
                                    <div class="col-12 text-justify">
                                        <p class="card-description">
                                            <b class="font-weight-bold text-primary">Servicios/Productos que solicita:</b> <?php echo $desafio->nombre_de_categorias; ?>
                                        </p>
                                        <p class="card-description">
                                            <b class="font-weight-bold text-primary">Descripción del desafío:</b> <?php echo $desafio->descripcion_del_desafio; ?>
                                        </p>
                                        <p class="card-description">
                                            <b class="font-weight-bold text-primary">Requisitos:</b> <?php echo $desafio->requisitos_del_desafio; ?>
                                        </p>
                                        <p class="card-description">
                                            <b class="font-weight-bold text-primary">Rubro:</b> <?php echo $desafio->rubro; ?>
                                        </p>
                                        <p class="card-description">
                                            <b class="font-weight-bold text-primary">Información de la empresa:</b> <?php echo $desafio->descripcion_empresa; ?>
                                        </p>
                                        <p class="card-description">
                                            <b class="font-weight-bold text-primary"><i class="fas fa-calendar-day"></i> Fin de postulación:</b> <?php echo date('d-m-Y', strtotime($desafio->fecha_fin_de_postulacion)); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <?php
                                switch ($desafio->estado_postulacion) {
                                    case POST_PENDIENTE:
                                        $badge_color_postulacion = 'badge-warning';
                                        $badge_estado_postulacion = 'Pendiente de validación';
                                        break;
                                    case POST_VALIDADO:
                                        $badge_color_postulacion = 'badge-info';
                                        $badge_estado_postulacion = 'Validado';
                                        break;
                                    case POST_ACEPTADO:
                                        $badge_color_postulacion = 'badge-success';
                                        $badge_estado_postulacion = 'Aceptado';
                                        break;
                                    case POST_RECHAZADO:
                                        $badge_color_postulacion = 'badge-danger';
                                        $badge_estado_postulacion = 'Rechazado';
                                        break;
                                }
                                ?>
                                <span class="badge <?php echo $badge_color_postulacion; ?>"><?php echo $badge_estado_postulacion; ?></span>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="modal fade" id="desafio-modal-<?php echo $desafio->desafio_id; ?>" tabindex="-1" role="dialog" aria-labelledby="desafio-modal-<?php echo $desafio->desafio_id; ?>Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="" id="desafio-modal-<?php echo $desafio->desafio_id; ?>Label"><?php echo $desafio->nombre_del_desafio; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Está por postularse a este desafío, ¿Está seguro?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default m-2" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary m-2 botonPostularme" data-desafio-id="<?php echo $desafio->desafio_id; ?>">Si, postularme</button>
                                </div>
                            </div>
                        </div>
                    </div> -->
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>