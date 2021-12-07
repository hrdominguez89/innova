<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
    <div class="row mb-5">
    
        <?php if($text):;?>
        <div class="col-md-4 col-sm-8 ml-auto mr-auto">
            <div class="container-xl text-center align-self-center">
                <div class="text-left mx-auto my-5">
                    <div class="card card-login">
                        <div class="card-body">
                            <?php echo $text;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php else:;?>
        <div class="col-md-4 col-sm-8 ml-auto mr-auto">
            <div class="container-xl text-center align-self-center">
                <div class="text-left mx-auto my-5">
                    
                    <form form method="POST" action="<?php echo base_url().'auth/change_password_by_link?email='.$this->input->get('email').'&code='.$this->input->get('code');?>">
                        <input type="hidden" value="<?php echo $this->input->get('email')!= NULL? $this->input->get('email'):set_value('email');?>" name="email">
                        <input type="hidden" value="<?php echo $this->input->get('code')!= NULL? $this->input->get('code'):set_value('code');?>" name="code">

                        <div class="card card-login">

                            <div class="card-header card-header-primary text-center">
                                <h4 class="card-title">Cambiar contraseña</h4>
                            </div>

                            <div class="card-body">
                                <?php if(@$error_message):;?>
                                    <div class="alert alert-danger">
                                        <?php echo $error_message;?>
                                    </div>
                                <?php endif;?>

                                <div class="form-row mt-3">

                                    <div class="form-group col">
                                        <label class="font-weight-bold" for="email">Contraseña</label>
                                        <input type="password" class="form-control" id="re_password" name="re_password" required>
                                        <?php echo form_error('password');?>
                                    </div>

                                </div>
                                
                                <div class="form-row mt-3">

                                    <div class="form-group col">
                                        <label class="font-weight-bold" for="email">Confirmar contraseña</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <?php echo form_error('re_password');?>
                                    </div>

                                </div>

                                <div class="form-row">
                                    
                                    <input type="hidden" id="g-recaptcha" name="g-recaptcha" class="mb-2" data-action='change_password' data-site-key="<?php echo $this->data_captcha_google->siteKey;?>">

                                    <div class="form-group col">
                                        <button type="submit" class="btn btn-primary btn-block">Cambiar contraseña</button>
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
        <?php endif;?>
    </div>
</div>