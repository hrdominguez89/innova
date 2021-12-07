<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-md-4 col-sm-8 ml-auto mr-auto">
            <div class="container-xl text-center align-self-center">
                <div class="text-left mx-auto my-5">
                    
                    <form form method="POST" action="<?php echo base_url();?>auth/reset_password">
                    
                        <div class="card card-login">

                            <div class="card-header card-header-primary text-center">
                                <h4 class="card-title">Olvide mi contraseña</h4>
                            </div>

                            <div class="card-body">
                                <?php echo validation_errors();?>
                                <?php if(@$error_message):;?>
                                    <div class="alert alert-danger">
                                        <?php echo $error_message;?>
                                    </div>
                                <?php endif;?>
                                Escriba el correo con el que se registró y le enviaremos un enlace temporal para que pueda reiniciar su contraseña.

                                <div class="form-row mt-3">

                                    <div class="form-group col">
                                        <label class="font-weight-bold" for="email">E-mail</label>
                                        <input type="text" class="form-control" id="email" name="email" value="<?php echo set_value('email');?>" required  placeholder="Ingrese su e-mail">
                                        <?php echo form_error('email'); ?>
                                    </div>

                                </div>

                                <div class="form-row">
                                    
                                    <input type="hidden" id="g-recaptcha" name="g-recaptcha" class="mb-2" data-action='reset_password' data-site-key="<?php echo $this->data_captcha_google->siteKey;?>">

                                    <div class="form-group col">
                                        <button type="submit" class="btn btn-primary btn-block">Enviar e-mail</button>
                                    </div>
    
                                </div>
    
                                <div class="form-row">
    
                                    <div class="form-group col">
    
                                        <div class="mb-3 mx-auto mt-3 text-left">
                                            Volver al <a href="<?php echo base_url();?>auth/login">login</a>.
                                        </div>
    
                                    </div>
    
                                </div>

                            </div>

                        </div>
              
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
