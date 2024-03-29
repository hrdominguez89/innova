<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php if ($this->session->flashdata('message')) : ?>
    <?php $this->load->view('modal_alertas_view'); ?>
<?php endif; ?>
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="razon_social">Razón Social / Nombre de la empresa<small class="text-danger"> *</small></label>
                                        <input type="text" class="form-control" id="razon_social" name="razon_social" value="<?php echo set_value('razon_social', $data_perfil->razon_social); ?>" required>
                                        <?php echo form_error('razon_social'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="descripcion">Descripción<small class="text-danger"> *</small></label>
                                        <textarea class="form-control" name="descripcion" id="" cols="30" rows="3" required><?php echo set_value('descripcion', $data_perfil->descripcion); ?></textarea>
                                        <?php echo form_error('descripcion'); ?>
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-4">

                                <div class="col-md-12">
                                    <label class="bmd-label-floating" for="tipo_de_partner">Tipo de partner<small class="text-danger"> *</small></label>
                                </div>
                                <div class="col-md-4">
                                    <select id="tipo_de_partner" class="select_chosen tipo_de_partner_select" name="tipo_de_partner" title="Elija un tipo de partner" data-size="9" tabindex="-98" required>
                                        <?php foreach ($tipos_de_partners as $tipo_de_partner) :; ?>
                                            <option value="<?php echo $tipo_de_partner->id; ?>" <?php echo @$this->input->post('tipo_de_partner') == $tipo_de_partner->id || $data_perfil->tipo_de_partner_id == $tipo_de_partner->id ? 'selected' : ''; ?>><?php echo $tipo_de_partner->descripcion_partner; ?> </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('tipo_de_partner'); ?>
                                </div>
                            </div>

                            

                            <div class="row mb-4" id="descripcionOtroTipoDePartner" style="display: <?php echo @$data_perfil->tipo_de_partner_id == 8? 'block':'none';?>">

                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="descripcion_tipo_de_partner">Describa el tipo de partner <small class="text-danger"> *</small></label>
                                        <input type="text" class="form-control" id="descripcion_tipo_de_partner" maxlength="100" name="descripcion_tipo_de_partner" value="<?php echo set_value('descripcion_tipo_de_partner', @$data_perfil->tipo_de_partner_id == 8? @$data_perfil->descripcion_tipo_de_partner:''); ?>" <?php echo @$data_perfil->tipo_de_partner_id == 8? 'required':'';?>>
                                        <?php echo form_error('descripcion_tipo_de_partner'); ?>
                                    </div>
                                </div>
                            </div>


                            <div class="row my-4">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="url_linkedin">URL Linkedin <i class="fab fa-linkedin"></i></label>
                                        <input type="url" class="form-control" id="url_linkedin" name="url_linkedin" value="<?php echo set_value('url_linkedin', $data_perfil->url_linkedin); ?>">
                                        <?php echo form_error('url_linkedin'); ?>
                                    </div>
                                </div>
                            </div>

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

                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="telefono">Teléfono<small class="text-danger"> *</small></label>
                                        <input type="text" class="form-control" name="telefono" id="telefono" value="<?php echo set_value('telefono', $data_perfil->telefono); ?>" required>
                                        <?php echo form_error('telefono'); ?>
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

            <?php echo $this->load->view('perfil_avanzado_view'); ?>



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