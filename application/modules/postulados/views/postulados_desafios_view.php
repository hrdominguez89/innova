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
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $desafio->nombre_del_desafio;?> </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-md-12 mb-5">
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-text card-header-warning">
                        <div class="card-text col-12">
                            <h4 class="card-title">Descripción: <?php echo $desafio->descripcion_del_desafio;?></h4>
                            <p class="card-category">Requisitos: <?php echo $desafio->requisitos_del_desafio;?></p>
                            <p class="card-category">Categorias: <?php echo $desafio->nombre_de_categorias;?></p>
                            <p class="card-category">Fin de postulación: <?php echo date('d-m-Y' ,strtotime($desafio->fecha_fin_de_postulacion));?></p>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                                <tr>
                                    <th>Nro</th>
                                    <th>Nombre Startup</th>
                                    <th>Nombre titular</th>
                                    <th>Antecedentes</th>
                                    <th class="text-center">Cant. de validaciones</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($postulados):;?>
                                <?php $i=1;foreach($postulados as $postulado):;?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $postulado->razon_social;?></td>
                                    <td><?php echo $postulado->titular;?></td>
                                    <td><?php echo $postulado->antecedentes;?></td>
                                    <td class="text-center"><?php echo $postulado->cantidad_validadores;?></td>
                                    <td class="text-center"><a href="<?php echo base_url();?>postulados/startup/<?php echo $postulado->startup_id;?>/<?php echo $desafio->desafio_id;?>" title="Ver startup"><i class="fas fa-address-card"></i></td>
                                </tr>
                                <?php $i++;?>
                                <?php endforeach;?>
                                <?php else:;?>
                                <tr>
                                    <td colspan="6" class="text-center">Este desafío todavia no cuentra con postulados.</td>
                                </tr>
                                <?php endif;?>
                            </tbody>
                        </table>
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>