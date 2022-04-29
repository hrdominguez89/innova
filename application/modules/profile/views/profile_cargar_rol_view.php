<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php if ($this->session->flashdata('message_elegir_rol')) : ?>
    <script>
        window.addEventListener('load', () => {
            $('#alertas_modal').modal('show');
        });
    </script>
    <!-- Modal -->
    <div class="modal fade" id="alertas_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="font-weight-bold" id="staticBackdropLabel"><?php echo $this->session->flashdata('message_elegir_rol')->titulo; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $this->session->flashdata('message_elegir_rol')->mensaje_cuerpo; ?>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
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
                    <div class="card-body">
                        <form method="POST" action="<?php echo base_url() . 'profile'; ?>">
                            <div class="row mb-4">
                                <h4 class="pl-3 font-weight-bolder">Elija un rol</h4>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="rol">Elija un rol: <small class="text-danger">*</small></label>
                                        <select id="rol" class="select_chosen" name="rol" title="Elija un rol" data-size="9" tabindex="-98" required>
                                            <option value="" selected hidden disabled>Elija un rol</option>
                                            <?php
                                            $roles = [1 => 'Startup', 2 => 'Empresa', 5 => 'Partner'];
                                            foreach ($roles as $rol_id => $rol_descripcion) :
                                                if ($rol_id != $this->session->userdata('user_data')->rol_id) :
                                            ?>
                                                    <option value="<?php echo $rol_id; ?>" <?php echo @$this->input->post('rol') == $rol_id ? 'selected' : ''; ?>> <?php echo $rol_descripcion; ?> </option>
                                            <?php
                                                endif;
                                            endforeach;
                                            ?>
                                        </select>
                                        <?php echo form_error('rol'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-12 text-right">
                                    <input type="hidden" name="formulario" value="elegir_rol">
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