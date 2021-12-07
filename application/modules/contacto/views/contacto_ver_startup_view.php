<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>home">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>contacto">Solicitudes de contacto</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $contacto_data->nombre_startup; ?></li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-12 mb-5">
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-icon card-header-primary">
                        <div class="card-icon">
                            <img class="img-fluid" style="max-width:100px" src="<?php echo base_url(); ?>uploads/imagenes_de_usuarios/<?php echo @$contacto_data->startup_id; ?>.png">
                        </div>
                        <h3 class="card-title font-weight-bold"><?php echo @$contacto_data->nombre_startup; ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <p class=""><b class="text-primary font-weight-bold">Titular:</b> <?php echo @$contacto_data->titular_startup; ?></p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <p class=""><b class="text-primary font-weight-bold">CUIT:</b> <?php echo @$contacto_data->cuit_startup; ?></p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <p class=""><b class="text-primary font-weight-bold">Descripción:</b> <?php echo @$contacto_data->descripcion_startup; ?></p>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <p class=""><b class="text-primary font-weight-bold">¿Exporta?:</b> <?php echo @$contacto_data->exporta_startup; ?></p>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="mb-3">
                                    <p class=""><b class="text-primary font-weight-bold">Rubro:</b> <?php echo @$contacto_data->rubro_startup; ?></p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <p class=""><b class="text-primary font-weight-bold">País:</b> <?php echo @$contacto_data->pais_startup; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <p class=""><b class="text-primary font-weight-bold">Pronvicia/Estado:</b> <?php echo @$contacto_data->provincia_startup; ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <p class=""><b class="text-primary font-weight-bold">Localidad:</b> <?php echo @$contacto_data->localidad_startup; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <p class=""><b class="text-primary font-weight-bold">Desafío al que se postula:</b> <?php echo @$contacto_data->nombre_del_desafio; ?></p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <p class=""><b class="text-primary font-weight-bold">Descripción del desafio:</b> <?php echo @$contacto_data->descripcion_del_desafio; ?></p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <p class=""><b class="text-primary font-weight-bold">Servicios / Productos que solicita:</b> <?php echo @$contacto_data->nombre_de_categorias; ?></p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <p class=""><b class="text-primary font-weight-bold">Requisitos del desafio:</b> <?php echo @$contacto_data->requisitos_del_desafio; ?></p>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title font-weight-bold">Datos de contacto</h3>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <p class=""><b class="text-primary font-weight-bold">Nombre:</b> <?php echo @$contacto_data->nombre_contacto_startup; ?></p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <p class=""><b class="text-primary font-weight-bold">Apellido:</b> <?php echo @$contacto_data->apellido_contacto_startup; ?></p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <p class=""><b class="text-primary font-weight-bold">Email:</b> <?php echo @$contacto_data->email_contacto_startup; ?></p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <p class=""><b class="text-primary font-weight-bold">Telefono:</b> <?php echo @$contacto_data->telefono_contacto_startup; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>