<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <h3 class="my-4">Hola <?php echo $this->session->userdata('user_data')->nombre; ?></h3>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
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

            <div class="col-lg-4 col-md-6 col-sm-6">
                <a href="<?php echo base_url(); ?>startups">
                    <div class="card card-stats">
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">rocket_launch</i>
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

            <div class="col-lg-4 col-md-6 col-sm-6">
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

        </div>
    </div>
</div>