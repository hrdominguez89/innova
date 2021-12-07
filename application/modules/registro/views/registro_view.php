<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-md-6 col-sm-8 ml-auto mr-auto">
            <div class="container-xl text-center align-self-center">  
                <div class="mb-3 mx-auto mt-3">
                    <h3 class="font-weight-bold">Registro</h3>
                    <p class="text-justify">
                        Para participar del programa de Innova 4.0 debe registrarse. luego nuestros administradores analizaran la información y habilitarán 
                        su cuenta para que pueda empezar a operar. Si usted ya poseé cuenta, inicie sesión haciendo <a href="<?php echo base_url();?>auth/login">click aquí</a>.
                    </p>
                </div>
                <div class="text-left mx-auto my-5">
                    
                    <form form method="POST" action="<?php echo base_url();?>registro">
                    
                        <div class="card card-login">

                            <div class="card-header card-header-primary text-center">
                                <h4 class="card-title">Datos de contacto</h4>
                            </div>

                            <div class="card-body">

                                <div class="form-row mt-3">

                                    <div class="form-group col">
                                        <label class="font-weight-bold" for="name">Nombre<small class="text-danger"> *</small></label>
                                        <input type="text" class="form-control text-capitalize" id="name" name="name" value="<?php echo set_value('name');?>" required>
                                        <?php echo form_error('name'); ?>
                                    </div>

                                    <div class="form-group col">
                                        <label class="font-weight-bold" for="lastname">Apellido<small class="text-danger"> *</small></label>
                                        <input type="text" class="form-control text-capitalize" id="lastname" name="lastname" value="<?php echo set_value('lastname');?>" required>
                                        <?php echo form_error('lastname'); ?>
                                    </div>

                                </div>

                                <div class="form-row">

                                    <div class="form-group col">
                                        <label class="font-weight-bold" for="email">E-Mail<small class="text-danger"> *</small></label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email');?>" required>
                                        <?php echo form_error('email'); ?>
                                    </div>

                                    <div class="form-group col">
                                        <label class="font-weight-bold" for="phone">Teléfono<small class="text-danger"> *</small></label>
                                        <input type="phone" class="form-control" id="phone" name="phone" value="<?php echo set_value('phone');?>" required>
                                        <?php echo form_error('phone'); ?>
                                    </div>
                                    
                                </div>
                                
                                <div class="form-row">

                                    <div class="form-group col">
                                        <label class="font-weight-bold" for="password">Contraseña <small class="text-danger"> *</small></label>
                                        <input type="password" class="form-control" id="password" name="password" value="<?php echo set_value('password');?>" required>
                                        <?php echo form_error('password'); ?>
                                    </div>

                                    <div class="form-group col">
                                        <label class="font-weight-bold" for="re_password">Confirmar contraseña<small class="text-danger"> *</small></label>
                                        <input type="password" class="form-control" id="re_password" name="re_password" value="<?php echo set_value('re_password');?>" required>
                                        <?php echo form_error('re_password'); ?>
                                    </div>
                                    
                                </div>

                                <div class="form-row">

                                    <div class="form-group col">
                                        <label class="font-weight-bold" for="kind_of_enterprise">Tipo de empresa<small class="text-danger"> *</small></label>
                                        <select class="form-control selectpicker" data-style="btn btn-link" id="kind_of_enterprise" name="kind_of_enterprise">
                                            <option value="" selected hidden disabled>Elija una opción</option>
                                            <option value="1" <?php echo set_select('kind_of_enterprise',1);?>>Startup</option>
                                            <option value="2" <?php echo set_select('kind_of_enterprise',2);?>>Empresa</option>
                                        </select>
                                        <?php echo form_error('kind_of_enterprise');?>
                                    </div>

                                </div>

                                <div class="form-row mt-3">

                                    <div class="form-group col">
                                        <label class="font-weight-bold" for="enterprise_name">Nombre de la empresa<small class="text-danger"> *</small></label>
                                        <input type="text" class="form-control text-capitalize" id="enterprise_name" name="enterprise_name" value="<?php echo set_value('enterprise_name');?>" required>
                                        <?php echo form_error('enterprise_name');?>
                                    </div>

                                </div>

                                <div class="form-row">

                                    <label class="font-weight-bold" for="objective_and_motivation">¿Cuáles son sus principales objetivos o motivaciones para participar en Innova&nbsp4.0?<small class="text-danger"> *</small></label>
                                
                                </div>

                                <div class="form-row mt-3">

                                    <div class="form-group col">
                                        <textarea class="form-control" id="objective_and_motivation" name="objetive_and_motivation" rows="3" required><?php echo set_value('objetive_and_motivation');?></textarea>
                                        <?php echo form_error('objetive_and_motivation'); ?>
                                    </div>

                                </div>

                                <div class="form-group">

                                    <div class="form-check">
                                        <label class="font-weight-bold" class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="terminos" value="true" <?php echo set_checkbox('terminos', 'true', false);?>>
                                            Acepto los <a href="#">términos y condiciones</a>.<small class="text-danger"> *</small>
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                        <?php echo form_error('terminos'); ?>
                                    </div>

                                </div>

                            </div>

                            <div class="card-footer justify-content-center">

                                <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                            
                            </div>

                        </div>
                        <input type="hidden" id="g-recaptcha" name="g-recaptcha" class="mb-2" data-action='registro' data-site-key="<?php echo $this->data_captcha_google->siteKey;?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>