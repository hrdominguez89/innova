<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="content mb-5">
    <div class="container-fluid">
        <div class="row">
            <?php if ($this->session->userdata('user_data')) :; ?>
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>home">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Listado de desafíos </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-md-12 mb-5">
            </div>
            <?php if (!$desafios) : ?>
                <div class="col-12 text-center">
                    <h3 class="font-weight-bold">No se encontraron desafíos disponibles.</h3>
                    <a href="<?php echo base_url() . 'home'; ?>" class="btn btn-primary m-5">Volver al inicio</a>
                </div>
            <?php endif; ?>
            <?php foreach ($desafios as $desafio) :; ?>
                <div class="col-md-6 mb-5">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <img class="img bg-white" src="<?php echo $desafio->logo ? base_url() . 'uploads/imagenes_de_usuarios/' . $desafio->id_empresa . '.png?v=' . rand() : base_url() . 'assets/img/usuario.jpeg?v=' . rand(); ?>">
                        </div>
                        <div class="card-body">

                            <h2 class="card-category text-gray"><?php echo $desafio->nombre_empresa; ?> </h2>
                            <h3 class="card-category text-gray"><?php echo $desafio->nombre_del_desafio; ?></h3>
                            <p class="card-description text-left">
                                <b class="font-weight-bold text-primary">Servicios/Productos que solicita:</b> <?php echo $desafio->nombre_de_categorias; ?>
                            </p>
                            <p class="card-description text-left">
                                <b class="font-weight-bold text-primary">Descripción del desafío:</b> <?php echo $desafio->descripcion_del_desafio; ?>
                            </p>
                            <p class="card-description text-left">
                                <b class="font-weight-bold text-primary"><i class="fas fa-calendar-day"></i> Fin de postulación:</b> <?php echo date('d-m-Y', strtotime($desafio->fecha_fin_de_postulacion)); ?>
                            </p>
                            <p class="card-description text-left">
                                <b class="font-weight-bold text-primary">Requisitos:</b> <?php echo $desafio->requisitos_del_desafio; ?>
                            </p>
                            <p class="card-description text-left">
                                <b class="font-weight-bold text-primary">Rubro:</b> <?php echo $desafio->rubro; ?>
                            </p>
                            <p class="card-description text-left text-left">
                                <b class="font-weight-bold text-primary">Información de la empresa:</b> <?php echo $desafio->descripcion_empresa; ?>
                            </p>
                            <button type="button" class="btn btn-primary verStartupsCompatibles" data-empresa-id='<?php echo $desafio->id_empresa; ?>' data-desafio-id='<?php echo $desafio->desafio_id; ?>'>
                                Startups compatibles
                            </button>

                            <button type="button" class="btn btn-default compartirPorEmail" data-empresa-id='<?php echo $desafio->id_empresa; ?>' data-desafio-id='<?php echo $desafio->desafio_id; ?>'>
                                Compartir <i class="fas fa-at"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>

<!-- Cargo los modals -->
<?php $this->load->view('modal_ver_startups_compatibles'); ?>

<?php $this->load->view('modal_startup_compatible'); ?>

<?php $this->load->view('modal_compartir_desafio_por_email'); ?>
