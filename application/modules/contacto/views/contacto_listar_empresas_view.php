<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Solicitudes de contacto</li>
                    </ol>
                </nav>
            </div>
            <?php if (!$contactos_data) :; ?>
                <div class="col-12 text-center">
                    <h3 class="font-weight-bold">Sin solicitudes de contacto.</h3>
                    <a href="<?php echo base_url(); ?>home" class="btn btn-primary m-5">Volver al inicio</a>
                </div>
            <?php else : ?>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">connect_without_contact</i>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="material-datatables">
                                <table id="dataTableComun" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width:20%">Nombre de la empresa</th>
                                            <th style="width: 30%;">Dato de contacto</th>
                                            <th>Nombre desafío</th>
                                            <th class="text-center">Fecha fin de postulación</th>
                                            <th class="disabled-sorting text-center" style="width:100px">Acción</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Nombre de la empresa</th>
                                            <th>Dato de contacto</th>
                                            <th>Nombre desafío</th>
                                            <th class="text-center">Fecha fin de postulación</th>
                                            <th class="text-center">Acción</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        <?php foreach ($contactos_data as $contacto_data) :; ?>
                                            <tr>
                                                <td>
                                                    <?php echo $contacto_data->nombre_empresa; ?>
                                                </td>
                                                <td>
                                                    <?php echo $contacto_data->nombre_contacto_empresa . ' ' . $contacto_data->apellido_contacto_empresa; ?>
                                                </td>
                                                <td>
                                                    <?php echo $contacto_data->nombre_del_desafio; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo date('d-m-Y', strtotime($contacto_data->fecha_fin_de_postulacion)); ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?php echo base_url() . 'contacto/empresa/' . $contacto_data->empresa_id . '/' . $contacto_data->desafio_id; ?>"><i class="fas fa-address-card"></i></a>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end content-->
                    </div>
                    <!--  end card  -->
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>