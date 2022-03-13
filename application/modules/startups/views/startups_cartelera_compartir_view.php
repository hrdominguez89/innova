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
                                <li class="breadcrumb-item active" aria-current="page">Listado de startups </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-md-12 mb-5">
            </div>
            <?php if (!$startups) : ?>
                <div class="col-12 text-center">
                    <h3 class="font-weight-bold">No se encontraron startups disponibles.</h3>
                    <a href="<?php echo base_url() . 'home'; ?>" class="btn btn-primary m-5">Volver al inicio</a>
                </div>
            <?php endif; ?>
            <?php foreach ($startups as $startup) :; ?>
                <div class="col-md-6 mb-5">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <img class="img bg-white" src="<?php echo $startup->logo ? base_url() . 'uploads/imagenes_de_usuarios/' . $startup->usuario_id . '.png?v=' . rand() : base_url() . 'assets/img/usuario.jpeg?v=' . rand(); ?>">
                        </div>
                        <div class="card-body">

                            <h2 class="card-category text-gray"><?php echo $startup->razon_social; ?> </h2>
                            <h3 class="card-category text-gray"><?php echo $startup->titular; ?></h3>
                            <p class="card-description text-left">
                                <b class="font-weight-bold text-primary">Servicios/Productos que ofrece:</b> <?php echo $startup->nombre_de_categorias; ?>
                            </p>
                            <?php if ($startup->cuit) :; ?>
                                <p class="card-description text-left">
                                    <b class="font-weight-bold text-primary">CUIT:</b> <?php echo $startup->cuit; ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($startup->pais) :; ?>

                                <p class="card-description text-left">
                                    <b class="font-weight-bold text-primary">País:</b> <?php echo $startup->pais; ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($startup->provincia) :; ?>

                                <p class="card-description text-left">
                                    <b class="font-weight-bold text-primary">Provincia:</b> <?php echo $startup->provincia; ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($startup->localidad) :; ?>

                                <p class="card-description text-left">
                                    <b class="font-weight-bold text-primary">Localidad:</b> <?php echo $startup->localidad; ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($startup->rubro) :; ?>

                                <p class="card-description text-left">
                                    <b class="font-weight-bold text-primary">Rubro:</b> <?php echo $startup->rubro; ?>
                                </p>
                            <?php endif; ?>

                            <?php if ($startup->exporta) :; ?>
                                <p class="card-description text-left">
                                    <b class="font-weight-bold text-primary">Exporta:</b> <?php echo $startup->exporta; ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($startup->descripcion) :; ?>
                                <p class="card-description text-left">
                                    <b class="font-weight-bold text-primary">Descripción:</b> <?php echo $startup->descripcion; ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($startup->antecedentes) :; ?>
                                <p class="card-description text-left">
                                    <b class="font-weight-bold text-primary">Antecedentes:</b> <?php echo $startup->antecedentes; ?>
                                </p>
                            <?php endif; ?>

                            <?php if ($startup->objetivo_y_motivacion) :; ?>
                                <p class="card-description text-left">
                                    <b class="font-weight-bold text-primary">Objetivo y motivación:</b> <?php echo $startup->objetivo_y_motivacion; ?>
                                </p>
                            <?php endif; ?>
                            <button type="button" class="btn btn-primary verDesafiosCompatibles" data-startup-id='<?php echo $startup->usuario_id; ?>'>
                                Desafíos compatibles
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
<?php $this->load->view('modal_ver_desafios_compatibles'); ?>

<?php $this->load->view('modal_desafio_compatible'); ?>