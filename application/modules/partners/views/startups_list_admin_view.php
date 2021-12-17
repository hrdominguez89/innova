<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url(); ?>home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Listado de Startups</li>
                    </ol>
                </nav>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">store</i>
                        </div>
                        <h4 class="card-title ">Lista de startups</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar mb-3 border-bottom pb-2">
                        </div>
                        <div class="material-datatables">
                            <table id="dataTableComun" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width:20%">Razón Social</th>
                                        <th style="width:20%">Nombre de contacto</th>
                                        <th style="width: 30%;">Teléfono</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Perfil</th>
                                        <th style="width:20%" class="text-center">Fecha alta</th>
                                        <th class="text-center">Cant. Postulaciones</th>
                                        <th class="text-center">Cant. Matcheos</th>
                                        <th class="disabled-sorting text-center" style="width:100px">Acción</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="width:20%">Razón Social</th>
                                        <th style="width:20%">Nombre de contacto</th>
                                        <th style="width: 30%;">Teléfono</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Perfil</th>
                                        <th style="width:20%" class="text-center">Fecha alta</th>
                                        <th class="text-center">Cant. Postulaciones</th>
                                        <th class="text-center">Cant. Matcheos</th>
                                        <th class="disabled-sorting text-center" style="width:100px">Acción</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php if (!@$startups) :; ?>
                                        <tr>
                                            <td colspan="9" class="text-center">No hay startups registradas</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($startups as $startup) :; ?>
                                            <tr>
                                                <td><?php echo $startup->razon_social; ?></td>
                                                <td><?php echo $startup->nombre . ' ' . $startup->apellido; ?></td>
                                                <td class="text-center"><?php echo $startup->telefono; ?></td>
                                                <td class="text-center"><?php echo $startup->email; ?></td>
                                                <td class="text-center"><?php echo $startup->perfil_completo ? 'Completo' : 'Incompleto'; ?></td>
                                                <td class="text-center"><?php echo date('d-m-Y', strtotime($startup->fecha_alta)); ?></td>
                                                <td class="text-center"><?php echo $startup->cantidad_de_postulaciones; ?></td>
                                                <td class="text-center"><?php echo $startup->cantidad_de_matcheos; ?></td>
                                                <td class="text-center"><a href="<?php echo base_url(); ?>startups/ver/<?php echo $startup->usuario_id; ?>"><i class="fas fa-eye"></i></a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
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