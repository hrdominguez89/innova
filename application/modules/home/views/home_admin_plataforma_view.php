<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <h3 class="my-4">Hola <?php echo $this->session->userdata('user_data')->nombre; ?></h3>
                <!-- <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Home</li>
                    </ol>
                </nav> -->
            </div>

            <div class="col-md-4 d-flex align-items-stretch">
                <div class="card card-stats">
                    <div class="card-header">
                        <h4 class="card-title text-left">
                            <span class="font-weight-bold">
                                Tipos de usuarios registrados
                            </span>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="ct-chart ct-minor-sixth" id="tiposDeUsuarios"></div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <i class="fa fa-circle ct-series-a"></i> Startups <span id="porcentaje0"></span> <br>
                                <i class="fa fa-circle ct-series-b"></i> Empresas <span id="porcentaje1"></span> <br>
                                <i class="fa fa-circle ct-series-c"></i> Partners <span id="porcentaje2"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 d-flex align-items-stretch">

                <div class="card card-stats">
                    <div class="card-header">
                        <h4 class="card-title text-left">
                            <span class="font-weight-bold">
                                Categorías seleccionadas
                            </span>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="ct-chart ct-double-octave" id="categoriasSeleccionadas"></div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <i class="fa fa-circle ct-series-a"></i> Desafíos <br>
                                <i class="fa fa-circle ct-series-b"></i> Categorias Startups <br>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12"></div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="<?php echo base_url(); ?>desafios">
                    <div class="card card-stats">
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">ballot</i>
                            </div>
                            <h4 class="card-title text-left">
                                <span class="font-weight-bold">
                                    Desafíos
                                </span>
                            </h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="<?php echo base_url(); ?>postulados">
                    <div class="card card-stats">
                        <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">emoji_people</i>
                            </div>
                            <h4 class="card-title text-left">
                                <span class="font-weight-bold">
                                    Postulaciones
                                </span>
                            </h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="<?php echo base_url(); ?>startups">
                    <div class="card card-stats">
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">store</i>
                            </div>
                            <h4 class="card-title text-left">
                                <span class="font-weight-bold">
                                    Startups
                                </span>
                            </h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="<?php echo base_url(); ?>empresas">
                    <div class="card card-stats">
                        <div class="card-header card-header-danger card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">apartment</i>
                            </div>
                            <h4 class="card-title text-left">
                                <span class="font-weight-bold">
                                    Empresas
                                </span>
                            </h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <a href="<?php echo base_url(); ?>usuarios">
                    <div class="card card-stats">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">people_outline</i>
                            </div>
                            <h4 class="card-title text-left">
                                <span class="font-weight-bold">
                                    Usuarios
                                </span>
                            </h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6">
                <a href="<?php echo base_url(); ?>categories">
                    <div class="card card-stats">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">category</i>
                            </div>
                            <h4 class="card-title text-left">
                                <span class="font-weight-bold">
                                    Categorías
                                </span>
                            </h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                            </div>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-lg-4 col-md-6 col-sm-6">
                <a href="<?php echo base_url(); ?>configuraciones">
                    <div class="card card-stats">
                        <div class="card-header card-header-default card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">settings_suggest</i>
                            </div>
                            <h4 class="card-title text-left">
                                <span class="font-weight-bold">
                                    Configuraciones
                                </span>
                            </h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                            </div>
                        </div>
                    </div>
                </a>
            </div>


        </div>
    </div>
</div>