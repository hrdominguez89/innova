<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php if ($this->session->flashdata('message')) : ?>
    <?php $this->load->view('modal_alertas_view'); ?>
<?php endif; ?>
<script src="https://www.linkedin.com/autofill/js/autofill.js" type="text/javascript" async></script><script type="IN/Form2"></script>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo ucfirst(mb_strtolower($subtitle, 'UTF-8')); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row justify-content-center">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-icon card-header-primary">
                        <div class="card-icon rounded-circle">
                            <img class="rounded-circle" style="background-color:#FFFFFF;max-height: 100px;" id="img-profile" src="<?php echo $this->session->userdata('user_data')->logo ? base_url() . 'uploads/imagenes_de_usuarios/' . $this->session->userdata('user_data')->id . '.png?v=' . rand() : base_url() . 'assets/img/usuario.jpeg?v=' . rand(); ?>">
                        </div>
                        <h4 class="card-title">Editar perfil
                            <?php if (!$this->session->userdata('user_data')->perfil_completo) : ?> -
                                <small class="category">Complete su perfil</small>
                            <?php endif; ?>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo base_url() . 'profile'; ?>" enctype="multipart/form-data">
                            <input type="hidden" name="profile_img" value="" id="input-hidden-profile-img">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-left pl-3" for="logo_imagen">Logo de la empresa</label>
                                <input class="form-control pl-3" type="file" id="logo_imagen" name="logo_imagen" accept="image/png, image/jpeg">
                                <?php echo form_error('profile_img'); ?>
                            </div>

                            <hr>
                            <div class="row mb-4">
                                <h4 class="pl-3 font-weight-bolder">Datos de contacto</h4>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="nombre">Nombre<small class="text-danger"> *</small></label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo set_value('nombre', $data_perfil->nombre); ?>" required>
                                        <?php echo form_error('nombre'); ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="apellido">Apellido <small class="text-danger"> *</small></label>
                                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo set_value('apellido', $data_perfil->apellido); ?>" required>
                                        <?php echo form_error('apellido'); ?>
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="email">E-mail <small class="text-danger"> *</small></label>
                                        <input type="email" class="form-control" name="email" id="email" value="<?php echo set_value('email', $data_perfil->email); ?>" required>
                                        <?php echo form_error('email'); ?>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-5">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary pull-right">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<div class="modal" id="modalProfile" data-backdrop='static' data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalProfileTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProfileTitle">Ajuste la imagen</h5>
            </div>
            <div class="modal-body">
                <div class="row d-flex justify-content-around">
                    <div class="col-7" id="preview">
                    </div>
                    <div class="col-4" id="resultado">
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-2">
                <button type="button" class="btn btn-default m-2" id="cancel-btn-modal" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary m-2" id="save-btn-modal" data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>