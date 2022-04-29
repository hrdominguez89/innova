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
                                <li class="breadcrumb-item active" aria-current="page">Postulados </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-md-12 mb-5">
            </div>
            <?php if($desafios):;?>
            <?php foreach ($desafios as $desafio) :; ?>
                <?php if ($desafio->desafio_id) :; ?>
                    <div class="col-md-6 mb-5 d-flex align-items-stretch">
                        <div class="card card-profile">
                            <!-- <div class="card-avatar">
                                <img class="img bg-white" src="<?php //echo $desafio->logo ? base_url() . 'uploads/imagenes_de_usuarios/' . $desafio->id_empresa . '.png?v=' . rand() : base_url() . 'assets/img/usuario.jpeg?v=' . rand(); ?>">
                            </div> -->
                            <div class="card-body">
                                <!-- <h2 class="card-category text-gray"><?php //echo $desafio->nombre_empresa; ?> </h2> -->
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
                                            <b class="font-weight-bold text-primary"><i class="fas fa-calendar-day"></i> Fin de postulación:</b> <?php echo date('d-m-Y', strtotime($desafio->fecha_fin_de_postulacion)); ?>
                                        </p>
                                        <p class="card-description text-right">
                                            <a href="<?php echo base_url();?>postulados/desafio/<?php echo $desafio->desafio_id;?>" class="btn btn-sm btn-primary">Ver postulados <span class="badge badge-pill badge-default"><?php echo $desafio->cantidad_de_startups_postuladas;?></span></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">

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
            <?php else:;?>
            <div class="col-md-12 mb-5 text-center">
                <h3>No se encontraron postulaciones</h3>
            </div>
            <?php endif;?>
        </div>
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>