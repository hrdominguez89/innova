<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url(); ?>home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Postulados</li>
                    </ol>
                </nav>
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">emoji_people</i>
                        </div>
                        <h4 class="card-title ">Lista de postulados</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar mb-3 border-bottom pb-2">
                            <a href="?filtrar=pendiente" class="btn btn-primary mx-2 <?php echo strtolower(@$this->input->get('filtrar')) != 'todos' && strtolower(@$this->input->get('filtrar')) == 'pendiente' && strtolower(@$this->input->get('filtrar')) != 'validado' || !$this->input->get('filtrar') ? 'active' : ''; ?>">Pendientes</a>
                            <a href="?filtrar=validado" class="btn btn-primary mx-2 <?php echo strtolower(@$this->input->get('filtrar') == 'validado') ? 'active' : '' ;?>">Validados</a>
                                <a href="?filtrar=todos" class="btn btn-primary mx-2 <?php echo strtolower(@$this->input->get('filtrar') == 'todos') ? 'active' : '' ;?>">Todos</a>
                        </div>
                        <div class="material-datatables">
                            <table id="dataTableComun" data-fix-header="true" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width:20%">Razón social</th>
                                        <th style="width:20%">Contacto</th>
                                        <th style="width: 30%;">Desafio</th>
                                        <th style="width: 30%;">Descripción del desafío</th>
                                        <th class="text-center">Fecha de postulación</th>
                                        <th class="text-center">Fecha límite de postulación</th>
                                        <th class="text-center">Estado postulación</th>
                                        <th class="disabled-sorting text-center" style="width:100px">Acción</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Razón social</th>
                                        <th>Contacto</th>
                                        <th>Desafio</th>
                                        <th>Descripción del desafío</th>
                                        <th class="text-center">Fecha de postulación</th>
                                        <th class="text-center">Fecha límite de postulación</th>
                                        <th class="text-center">Estado postulación</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($postulados as $postulado) :; ?>
                                        <?php if (
                                                    $this->input->get('filtrar')
                                                    && 
                                                    (
                                                        strtolower(@$this->input->get('filtrar')) == 'pendiente'
                                                        ||
                                                        strtolower(@$this->input->get('filtrar')) == 'validado'
                                                        ||
                                                        strtolower(@$this->input->get('filtrar')) == 'todos'
                                                    )
                                                ):; ?>
                                            <?php if (strtolower($postulado->estado_validacion) == strtolower(@$this->input->get('filtrar'))) :; ?>
                                                <tr id="row_postulacion_id_<?php echo $postulado->postulacion_id; ?>">
                                                    <td><?php echo $postulado->razon_social; ?></td>
                                                    <td><?php echo $postulado->nombre . ' ' . $postulado->apellido; ?></td>
                                                    <td><?php echo $postulado->nombre_del_desafio; ?></td>
                                                    <td><?php echo $postulado->descripcion_del_desafio; ?></td>
                                                    <td class="text-center"><?php echo date('d-m-Y', strtotime($postulado->fecha_postulacion)); ?></td>
                                                    <td class="text-center"><?php echo date('d-m-Y', strtotime($postulado->fecha_fin_de_postulacion)); ?></td>
                                                    <td class="text-center"><?php echo $postulado->estado_validacion; ?></td>
                                                    <td class="text-center">
                                                        <a title="Ver startup" href="<?php echo base_url(); ?>postulados/startup/<?php echo $postulado->startup_id . '/' . $postulado->desafio_id; ?>"><i class="far fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            <?php elseif (strtolower(@$this->input->get('filtrar')) == 'todos') :; ?>
                                                <tr id="row_postulacion_id_<?php echo $postulado->postulacion_id; ?>">
                                                    <td><?php echo $postulado->razon_social; ?></td>
                                                    <td><?php echo $postulado->nombre . ' ' . $postulado->apellido; ?></td>
                                                    <td><?php echo $postulado->nombre_del_desafio; ?></td>
                                                    <td><?php echo $postulado->descripcion_del_desafio; ?></td>
                                                    <td class="text-center"><?php echo date('d-m-Y', strtotime($postulado->fecha_postulacion)); ?></td>
                                                    <td class="text-center"><?php echo date('d-m-Y', strtotime($postulado->fecha_fin_de_postulacion)); ?></td>
                                                    <td class="text-center"><?php echo $postulado->estado_validacion; ?></td>
                                                    <td class="text-center">
                                                        <a title="Ver startup" href="<?php echo base_url(); ?>postulados/startup/<?php echo $postulado->startup_id . '/' . $postulado->desafio_id; ?>"><i class="far fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php else :; ?>
                                            <?php if (strtolower($postulado->estado_validacion) == 'pendiente') :; ?>

                                                <tr id="row_postulacion_id_<?php echo $postulado->postulacion_id; ?>">
                                                    <td><?php echo $postulado->razon_social; ?></td>
                                                    <td><?php echo $postulado->nombre . ' ' . $postulado->apellido; ?></td>
                                                    <td><?php echo $postulado->nombre_del_desafio; ?></td>
                                                    <td><?php echo $postulado->descripcion_del_desafio; ?></td>
                                                    <td class="text-center"><?php echo date('d-m-Y', strtotime($postulado->fecha_postulacion)); ?></td>
                                                    <td class="text-center"><?php echo date('d-m-Y', strtotime($postulado->fecha_fin_de_postulacion)); ?></td>
                                                    <td class="text-center"><?php echo $postulado->estado_validacion; ?></td>
                                                    <td class="text-center">
                                                        <a title="Ver startup" href="<?php echo base_url(); ?>postulados/startup/<?php echo $postulado->startup_id . '/' . $postulado->desafio_id; ?>"><i class="far fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
        </div>
    </div>
</div>