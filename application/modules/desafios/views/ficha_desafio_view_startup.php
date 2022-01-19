<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url(); ?>home">Home</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url(); ?>desafios">Desafíos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ver desafío <?php echo $desafio->nombre_del_desafio; ?></li>
                    </ol>
                </nav>
            </div>
            <div class="col-xl-12">
                <div class="col-md-12 my-5 d-flex align-items-stretch">
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
                                <div class="row text-center">
                                    <div class="col-12">
                                        <?php if ($desafio->desafio_estado_id == DESAF_VIGENTE) :; ?>
                                            <button class="m-3 btn btn-primary botonPostularme" data-desafio-id="<?php echo $desafio->desafio_id; ?>">Postularme</button>
                                        <?php else :; ?>
                                            <div class="m-3 badge badge-danger">Fecha de postulación</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
        </div>
    </div>
</div>