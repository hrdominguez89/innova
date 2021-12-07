<?php if ($this->session->flashdata('mensaje')) : ?>
    <script>
    window.addEventListener('load', () => {
        swal({
            title: "<?php echo $this->session->flashdata('mensaje')['title'];?>",
            type: "<?php echo $this->session->flashdata('mensaje')['type'];?>",
            buttonsStyling: "<?php echo $this->session->flashdata('mensaje')['buttonsStyling'];?>",
            timer: "<?php echo $this->session->flashdata('mensaje')['timer'];?>",
            confirmButtonClass: "<?php echo $this->session->flashdata('mensaje')['confirmButtonClass'];?>",
        });
    })
</script>
<?php endif; ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url(); ?>home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cambiar contraseña</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6">
                <form method="POST">
                    <div class="card ">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">password</i>
                            </div>
                            <h4 class="card-title">Cambiar contraseña</h4>
                        </div>
                        <div class="card-body ">
                            <div class="form-group bmd-form-group is-filled">
                                <label for="password" class="bmd-label-floating"> Contraseña <span class="text-danger"> *</span></label>
                                <input type="password" class="form-control valid" maxlength="72" name="password" id="password" required aria-required="true" aria-invalid="false">
                                <label id="password-error" class="error" for="password"></label>
                                <div class="text-danger"><?php echo form_error('password'); ?></div>
                            </div>
                            <div class="form-group bmd-form-group is-filled">
                                <label for="re_password" class="bmd-label-floating"> Repita contraseña <span class="text-danger"> *</span></label>
                                <input type="password" class="form-control valid" maxlength="72" name="re_password" id="re_password" required aria-required="true" aria-invalid="false">
                                <label id="re_password-error" class="error" for="re_password"></label>
                                <div class="text-danger"><?php echo form_error('re_password'); ?></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>