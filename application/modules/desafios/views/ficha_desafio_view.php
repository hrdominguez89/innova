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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 card">
                    <div class="toolbar mb-3 border-bottom pb-2">
                        <h3>Postulados</h3>
                    </div>
                    <div class="material-datatables">
                        <table id="dataTableComun" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Razón social</th>
                                    <th>Nombre de contacto</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Estado</th>
                                    <th class="disabled-sorting ">Acción</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Razón social</th>
                                    <th>Nombre de contacto</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php foreach ($postulados as $postulado) :; ?>
                                    <tr>
                                        <td><?php echo $postulado->razon_social; ?></td>
                                        <td><?php echo $postulado->nombre . ' ' . $postulado->apellido; ?></td>
                                        <td><?php echo $postulado->email_contacto; ?></td>
                                        <td><?php echo $postulado->telefono_contacto; ?></td>
                                        <td><?php echo $postulado->estado_postulacion_descripcion; ?></td>
                                        <td class="text-center"><a href="<?php echo base_url().'postulados/startup/'.$postulado->startup_id.'/'.$desafio->desafio_id;?>" ><i class="far fa-eye"></i>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--  end card  -->
            </div>
        </div>
    </div>
</div>