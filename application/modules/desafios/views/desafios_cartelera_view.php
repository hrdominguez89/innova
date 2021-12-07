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
                                <li class="breadcrumb-item active" aria-current="page">Listado de desafíos </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-md-12 mb-5">
            </div>
            <?php if (!$desafios) : ?>
                <div class="col-12 text-center">
                <h3 class="font-weight-bold">No se encontraron desafíos disponibles.</h3>
                <a href="<?php echo base_url().'home';?>" class="btn btn-primary m-5">Volver al inicio</a>
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
                                <p class="card-description text-left">
                                    <b class="font-weight-bold text-primary">Servicios/Productos que solicita:</b> <?php echo $desafio->nombre_de_categorias; ?>
                                </p>
                                <p class="card-description text-left">
                                    <b class="font-weight-bold text-primary">Descripción del desafío:</b> <?php echo $desafio->descripcion_del_desafio; ?>
                                </p>
                                <p class="card-description text-left">
                                    <b class="font-weight-bold text-primary"><i class="fas fa-calendar-day"></i> Fin de postulación:</b> <?php echo date('d-m-Y', strtotime($desafio->fecha_fin_de_postulacion)); ?>
                                </p>
                                <p class="text-right">
                                    <a class="botonVerMas" id="botonVerMas<?php echo $desafio->desafio_id; ?>" data-value="false" data-desafio-id="<?php echo $desafio->desafio_id; ?>" href="javascript: void(0)">
                                        Ver más... <i class="fas fa-chevron-circle-down"></i>
                                    </a>
                                </p>
                                <div class="collapse" id="verMasDesafioCollapse<?php echo $desafio->desafio_id; ?>">

                                    <p class="card-description text-left">
                                        <b class="font-weight-bold text-primary">Requisitos:</b> <?php echo $desafio->requisitos_del_desafio; ?>
                                    </p>
                                    <p class="card-description text-left">
                                        <b class="font-weight-bold text-primary">Rubro:</b> <?php echo $desafio->rubro; ?>
                                    </p>
                                    <p class="card-description text-left text-left">
                                        <b class="font-weight-bold text-primary">Información de la empresa:</b> <?php echo $desafio->descripcion_empresa; ?>
                                    </p>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#desafio-modal-<?php echo $desafio->desafio_id; ?>">Postularme</button>
                                </div>
                                <div class="row text-center">
                                    <!-- <div class="col-6">
                                        <b class="font-weight-bold text-primary">Inicio de postulación:</b> <?php echo date('d-m-Y', strtotime($desafio->fecha_inicio_de_postulacion)); ?>
                                    </div> -->

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="desafio-modal-<?php echo $desafio->desafio_id; ?>" tabindex="-1" role="dialog" aria-labelledby="desafio-modal-<?php echo $desafio->desafio_id; ?>Label" aria-hidden="true">
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
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>