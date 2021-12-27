<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url(); ?>home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Desafíos</li>
                    </ol>
                </nav>
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">ballot</i>
                        </div>
                        <h4 class="card-title ">Lista de desafíos</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar mb-3 border-bottom pb-2">
                        </div>
                        <div class="material-datatables">
                            <table id="dataTableComun" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width:20%">Empresa</th>
                                        <th style="width:20%">Nombre del desafío</th>
                                        <th style="width: 30%;">Descripción</th>
                                        <th class="text-center">Fecha inicio de postulación</th>
                                        <th class="text-center">Fecha fin de postulación</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Cant. Postulados</th>
                                        <th class="text-center">Cateorías</th>
                                        <th class="disabled-sorting text-center" style="width:100px">Acción</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Empresa</th>
                                        <th>Nombre del desafío</th>
                                        <th>Descripción</th>
                                        <th class="text-center">Fecha inicio de postulación</th>
                                        <th class="text-center">Fecha fin de postulación</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Cant. Postulados</th>
                                        <th class="text-center">Cateorías</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php if (!$desafios) :; ?>
                                        <tr>
                                            <td colspan="9" class="text-center">No hay desafíos registrados</td>
                                        </tr>
                                    <?php else :; ?>
                                        <?php foreach ($desafios as $desafio) :; ?>
                                            <tr id="row_desafio_id_<?php echo $desafio->desafio_id;?>">
                                                <td><?php echo $desafio->nombre_empresa; ?></td>
                                                <td><?php echo $desafio->nombre_del_desafio; ?></td>
                                                <td><?php echo $desafio->descripcion_del_desafio; ?></td>
                                                <td class="text-center"><?php echo date('d-m-Y', strtotime($desafio->fecha_inicio_de_postulacion)); ?></td>
                                                <td class="text-center"><?php echo date('d-m-Y', strtotime($desafio->fecha_fin_de_postulacion)); ?></td>
                                                <td class="text-center"><?php echo $desafio->desafio_estado_descripcion; ?></td>
                                                <td class="text-center"><?php echo $desafio->cantidad_de_startups_postuladas; ?></td>
                                                <td><?php echo $desafio->nombre_de_categorias; ?></td>
                                                <td class="text-center dt-nowrap">
                                                    <a class="m-2 text-primary" title="Ver desafío <?php echo $desafio->nombre_del_desafio; ?>" href="<?php echo base_url(); ?>desafios/verDesafio/<?php echo $desafio->desafio_id; ?>"><i class="far fa-eye"></i></a>
                                                    <?php if($this->session->userdata('user_data')->rol_id == ROL_ADMIN_PLATAFORMA):;?>
                                                    <a class="m-2 text-warning"  onclick="editarDesafio(<?php echo $desafio->desafio_id;?>)" title="Editar desafío <?php echo $desafio->nombre_del_desafio; ?>" href="javascript:void(0);"><i class="far fa-edit"></i></a>
                                                    <a class="m-2 text-danger"  onclick="eliminarDesafioModal(this)" data-nombre-desafio="<?php echo $desafio->nombre_del_desafio;?>" data-desafio-id="<?php echo $desafio->desafio_id;?>" title="Eliminar desafío <?php echo $desafio->nombre_del_desafio; ?>" href="javascript:void(0);"><i class="fas fa-trash-alt"></i></a>
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php echo $this->load->view('modals/desafios/editar_desafio_modal_view'); ?>
                        <?php echo $this->load->view('modals/desafios/eliminar_desafio_modal_view'); ?>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
        </div>
    </div>
</div>