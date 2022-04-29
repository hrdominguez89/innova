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
                    <div class="col-md-6 mb-5">
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
                                <div class="col-sm-12 text-center">
                                    <button class="btn btn-primary botonCancelarPostulacion" data-postulacion-id="<?php echo $desafio->postulacion_id; ?>">Cancelar postulación</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>

<div class="modal fade" id="cancelarPostulacionModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="cancelarPostulacionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelarPostulacionModalLabel">Cancelar postulación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                <div id="cancelarPostulacionModalDiv">
                    ¿Está seguro que desea cancelar su postulación a este desafío?
                </div>
            </div>
            <div class="modal-footer mt-2">
                <form method="POST" action="<?php echo base_url() . 'postulados/cancelarpostulacion'; ?>">
                    <input type="hidden" name="postulacion_id" value="" id="inputHiddenPostulacionId">

                    <button type="button" class="btn btn-default m-2" data-dismiss="modal" aria-label="Close">Cerrar</button>
                    <button type="submit" class="btn btn-danger m-2">Si, cancelar postulación</button>

                </form>
            </div>
        </div>
    </div>
</div>