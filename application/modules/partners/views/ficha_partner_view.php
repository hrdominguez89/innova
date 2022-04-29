<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url(); ?>home">Home</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url(); ?>partners">Partners</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $partner->razon_social; ?></li>
                    </ol>
                </nav>
            </div>
            <div class="col-xl-12">
                <div class="col-md-12 my-5 d-flex align-items-stretch">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <img class="img bg-white" src="<?php echo $partner->logo ? base_url() . 'uploads/imagenes_de_usuarios/' . $partner->usuario_id . '.png?v=' . rand() : base_url() . 'assets/img/usuario.jpeg?v=' . rand(); ?>">
                        </div>
                        <div class="card-body">
                            <h2 class="card-category text-gray"><?php echo $partner->razon_social; ?> </h2>
                            <div class="row">
                                <div class="col-12 text-justify">
                                    <h3>Datos de contacto</h3>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Nombre:</b> <?php echo $partner->apellido . ' ' . $partner->nombre; ?>
                                    </p>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Email:</b> <?php echo $partner->email; ?>
                                    </p>
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Teléfono:</b> <?php echo $partner->telefono; ?>
                                    </p>
                                    <hr>
                                    <h3>Datos de la partner</h3>
                                    
                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Tipo de partner:</b> <?php echo $partner->descripcion_tipo_de_partner; ?>
                                    </p>

                                    <p class="card-description">
                                        <b class="font-weight-bold text-primary">Objetivo/motivo por el que se registró en RIA: </b><?php echo $partner->objetivo_y_motivacion; ?>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 card">
                    <div class="toolbar mb-3 border-bottom pb-2">
                        <h3>Desafíos compartidos</h3>
                    </div>
                    <div class="material-datatables">
                        <table id="dataTableComun" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Empresa</th>
                                    <th class="disabled-sorting "></th>
                                    <th>Desafío</th>
                                    <th class="disabled-sorting "></th>
                                    <th>Startup</th>
                                    <th class="disabled-sorting"></th>
                                    <th class="text-center">Fecha</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Empresa</th>
                                    <th class="disabled-sorting "></th>
                                    <th>Desafío</th>
                                    <th class="disabled-sorting "></th>
                                    <th>Startup</th>
                                    <th class="disabled-sorting "></th>
                                    <th class="text-center">Fecha</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php if (!$desafios_compartidos) :; ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No hay desafíos compartidos registrados</td>
                                    </tr>
                                <?php else :; ?>
                                    <?php foreach ($desafios_compartidos as $desafio_compartido) :; ?>
                                        <tr>
                                            <td class="text-left"><?php echo $desafio_compartido->razon_social_empresa; ?></td>
                                            <td class="text-center"><a href="<?php echo base_url() . 'empresas/ver/' . $desafio_compartido->empresa_id; ?>"><i class="far fa-eye"></td>
                                            <td class="text-left"><?php echo $desafio_compartido->nombre_del_desafio; ?></td>
                                            <td class="text-center"><a href="<?php echo base_url() . 'desafios/verDesafio/' . $desafio_compartido->desafio_id; ?>"><i class="far fa-eye"></td>
                                            <td class="text-left"><?php echo $desafio_compartido->razon_social_startup; ?></td>
                                            <td class="text-center"><a href="<?php echo base_url() . 'startups/ver/' . $desafio_compartido->startup_id; ?>"><i class="far fa-eye"></td>
                                            <td class="text-center"><?php echo date('d-m-Y',strtotime($desafio_compartido->fecha_compartido)); ?></td>
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