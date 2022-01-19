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
                            <div class="row mb-4">
                                <h4 class="pl-3 font-weight-bolder">Datos de la empresa</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="titular">Titular<small class="text-danger"> *</small></label>
                                        <input type="text" class="form-control" id="titular" name="titular" value="<?php echo set_value('titular', $data_perfil->titular); ?>" required>
                                        <?php echo form_error('titular'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="razon_social">Razón Social / Nombre de la empresa<small class="text-danger"> *</small></label>
                                        <input type="text" class="form-control" id="razon_social" name="razon_social" value="<?php echo set_value('razon_social', $data_perfil->razon_social); ?>" required>
                                        <?php echo form_error('razon_social'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-left pl-3" for="logo_imagen">Logo de la empresa</label>
                                <input class="form-control pl-3" type="file" id="logo_imagen" name="logo_imagen" accept="image/png, image/jpeg">
                                <?php echo form_error('profile_img'); ?>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="cuit">C.U.I.T.<small>(sin guiones ni espacios) <span class="text-danger">*</span></small></label>
                                        <input type="text" pattern="\d*" minlength="11" maxlength="11" class="form-control" name="cuit" id="cuit" value="<?php echo set_value('cuit', $data_perfil->cuit); ?>" required>
                                        <?php echo form_error('cuit'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="email_empresa">E-mail de la empresa <i class="fas fa-envelope"></i><small> (opcional)</small></label>
                                        <input type="email" class="form-control" id="email_empresa" name="email_empresa" value="<?php echo set_value('email_empresa', $data_perfil->email_empresa); ?>">
                                        <?php echo form_error('email_empresa'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="telefono_empresa">Teléfono de la empresa <i class="fas fa-phone"></i><small> (opcional)</small></label>
                                        <input type="text" class="form-control" name="telefono_empresa" id="telefono_empresa" value="<?php echo set_value('telefono_empresa', $data_perfil->telefono_empresa); ?>">
                                        <?php echo form_error('telefono_empresa'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="pais">País <small class="text-danger"> *</small></label>
                                        <input type="text" class="form-control" name="pais" id="pais" value="<?php echo set_value('pais', $data_perfil->pais); ?>" required>
                                        <?php echo form_error('pais'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="provincia">Provincia/Estado <small class="text-danger"> *</small></label>
                                        <input type="text" class="form-control" id="provincia" name="provincia" value="<?php echo set_value('provincia', $data_perfil->provincia); ?>" required>
                                        <?php echo form_error('provincia'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="localidad">Localidad/Ciudad <i class="fas fa-city"></i><small class="text-danger"> *</small></label>
                                        <input type="text" class="form-control" name="localidad" id="localidad" value="<?php echo set_value('localidad', $data_perfil->localidad); ?>" required>
                                        <?php echo form_error('localidad'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="direccion">Dirección <i class="fas fa-map-marked"></i><small class="text-danger"> *</small></label>
                                        <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo set_value('direccion', $data_perfil->direccion); ?>" required>
                                        <?php echo form_error('direccion'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="url_web">URL Web <i class="fas fa-globe"></i></label>
                                        <input type="url" class="form-control" id="url_web" name="url_web" value="<?php echo set_value('url_web', $data_perfil->url_web); ?>">
                                        <?php echo form_error('url_web'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="url_youtube">URL YouTube <i class="fab fa-youtube"></i></label>
                                        <input type="url" class="form-control" id="url_youtube" name="url_youtube" value="<?php echo set_value('url_youtube', $data_perfil->url_youtube); ?>">
                                        <?php echo form_error('url_youtube'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="url_instagram">URL Instagram <i class="fab fa-instagram"></i></label>
                                        <input type="url" class="form-control" id="url_instagram" name="url_instagram" value="<?php echo set_value('url_instagram', $data_perfil->url_instagram); ?>">
                                        <?php echo form_error('url_instagram'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="url_facebook">URL Facebook <i class="fab fa-facebook-square"></i></label>
                                        <input type="url" class="form-control" id="url_facebook" name="url_facebook" value="<?php echo set_value('url_facebook', $data_perfil->url_facebook); ?>">
                                        <?php echo form_error('url_facebook'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="url_twitter">URL Twitter <i class="fab fa-twitter"></i></label>
                                        <input type="url" class="form-control" name="url_twitter" id="url_twitter" value="<?php echo set_value('url_twitter', $data_perfil->url_twitter); ?>">
                                        <?php echo form_error('url_twitter'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="rubro">Rubro </label>
                                        <input type="text" class="form-control" id="rubro" name="rubro" value="<?php echo set_value('rubro', $data_perfil->rubro); ?>">
                                        <?php echo form_error('rubro'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Descripción <small class="text-danger"> *</small></label>
                                        <textarea name="descripcion" id="descripcion" class="form-control" rows="3" required><?php echo set_value('descripcion', $data_perfil->descripcion); ?></textarea>
                                        <?php echo form_error('descripcion'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-sm-3 col-form-label text-left pl-3" for="exporta">¿Exporta? <small class="text-danger"> *</small></label>
                                <div class="col-sm-9">
                                    <div class="form-group bmd-form-group">
                                        <select name="exporta" id="exporta" class="form-control" required>
                                            <option selected disabled hidden>Seleccione una opción</option>
                                            <option value="Si" <?php echo $data_perfil->exporta == 'Si' ? 'selected' : ''; ?><?php echo set_select('exporta', $data_perfil->exporta); ?>>Si</option>
                                            <option value="No" <?php echo $data_perfil->exporta == 'No' ? 'selected' : ''; ?><?php echo set_select('exporta', $data_perfil->exporta); ?>>No</option>
                                        </select>
                                        <?php echo form_error('exporta'); ?>
                                    </div>
                                </div>
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
                                        <label class="bmd-label-floating" for="telefono">Teléfono <small class="text-danger"> *</small></label>
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