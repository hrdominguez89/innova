<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url(); ?>home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Listado de Empresas</li>
                    </ol>
                </nav>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">apartment</i>
                        </div>
                        <h4 class="card-title ">Lista de empresas</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar mb-3 border-bottom pb-2">
                        </div>
                        <div class="material-datatables">
                            <table id="dataTableComun" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Razón social</th>
                                        <th>Nombre</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Teléfono</th>
                                        <th class="text-center">Perfil</th>
                                        <th class="text-center">Cant. desafíos</th>
                                        <th class="text-center">Cant. postulados</th>
                                        <th class="text-center">Cant. Matcheos</th>
                                        <th class="disabled-sorting text-center" style="width:100px">Acción</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Razón social</th>
                                        <th>Nombre</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Teléfono</th>
                                        <th class="text-center">Perfil</th>
                                        <th class="text-center">Cant. desafíos</th>
                                        <th class="text-center">Cant. postulados</th>
                                        <th class="text-center">Cant. Matcheos</th>
                                        <th class="disabled-sorting text-center" style="width:100px">Acción</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php if (!@$empresas) :; ?>
                                        <tr>
                                            <td colspan="9" class="text-center">No hay empresas registradas</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($empresas as $empresa) :; ?>
                                            <tr>
                                                <td><?php echo $empresa->razon_social;?></td>
                                                <td><?php echo $empresa->apellido.' '.$empresa->nombre;?></td>
                                                <td class="text-center"><?php echo $empresa->email;?></td>
                                                <td class="text-center"><?php echo $empresa->telefono;?></td>
                                                <td class="text-center"><?php echo $empresa->perfil_completo ? 'Completo':'Incompleto';?></td>
                                                <td class="text-center"><?php echo $empresa->cantidad_de_desafios;?></td>
                                                <td class="text-center"><?php echo $empresa->cantidad_de_postulaciones;?></td>
                                                <td class="text-center"><?php echo $empresa->cantidad_de_matcheos;?></td>
                                                <td class="text-center"><a href="<?php echo base_url();?>empresas/ver/<?php echo $empresa->id_empresa;?>"><i class="fas fa-eye"></i></a></td>
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