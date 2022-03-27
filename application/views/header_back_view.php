<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <h3 class="mx-3"><?php echo $title; ?></h3>
        </div>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <?php if ($this->session->userdata('user_data')->estado_id != USR_ENABLED && $this->session->userdata('user_data')->perfil_completo) :; ?>
                    <span class="badge badge-danger">Cuenta pendiente de habilitación</span>
                <?php endif; ?>
                <li class="nav-item dropdown">
                    <?php
                    $notificaciones = $this->session->userdata('notificaciones');
                    $notificaciones_sin_leer = 0;
                    foreach ($notificaciones as $notificacion) {
                        if (!$notificacion->leido) {
                            $notificaciones_sin_leer++;
                        }
                    }; ?>

                    <?php if(!($this->session->userdata('user_data')->rol_id == ROL_PARTNER || $this->session->userdata('user_data')->rol_id == null)):;?>
                    <a class="nav-link <?php echo $notificaciones_sin_leer ? 'text-primary notificacion-color-header' : ''; ?>" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons notificacion-icono-header"><?php echo $notificaciones_sin_leer ? 'notifications_active' : 'notifications'; ?></i>
                        Notificaciones
                        <?php if ($notificaciones_sin_leer) :; ?>
                            &nbsp;&nbsp;<span class="badge badge-pill badge-primary notificacion-total-header"><?php echo $notificaciones_sin_leer; ?></span>
                        <?php endif; ?>
                    </a>
                    <?php endif;?>
                    <div style="width:300px;max-height:250px;overflow-y:auto;" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                        <?php
                        $notificaciones_maximas_header = $this->session->userdata('notificaciones_maximas_header');
                        foreach ($notificaciones as $notificacion) :; ?>
                            <a class="dropdown-item verNotificacion <?php echo !$notificacion->leido ? 'notificacion-fuente-header-'.$notificacion->id.' font-weight-bold font-italic' : ''; ?>" href="#" data-notificacion-id="<?php echo $notificacion->id; ?>" data-toggle="modal" data-target="#notificacionesModal">
                                <?php
                                echo !$notificacion->leido ? '<i class="notificacion-icono-header-'.$notificacion->id.' fas fa-envelope"></i>' : '<i class="far fa-envelope-open"></i>'; ?>
                                &nbsp;&nbsp;
                                <?php
                                echo substr($notificacion->titulo_mensaje, 0, 28);
                                echo strlen($notificacion->titulo_mensaje) > 28 ? '...' : '';
                                ?>
                            </a>
                            <div class="dropdown-divider"></div>

                            <?php
                            if (!$notificacion->leido) {
                                $notificaciones_sin_leer--;
                            }
                            $notificaciones_maximas_header--;
                            if ($notificaciones_maximas_header == 0) {
                                break;
                            };
                            ?>
                        <?php endforeach; ?>
                        <a class="dropdown-item" href="<?php echo base_url(); ?>notificaciones"><i class="fas fa-inbox"></i>&nbsp;&nbsp;Ver todas las notificaciones<?php echo $notificaciones_sin_leer ? '&nbsp;&nbsp;<span class="badge badge-pill badge-secondary notificacion-total-bandeja-header">' . $notificaciones_sin_leer . '</span>' : ''; ?></a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">person</i>
                        <?php echo $this->session->userdata('user_data')->email; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                        <a class="dropdown-item" href="<?php echo base_url() . 'profile'; ?>">Mi perfil</a>
                        <a class="dropdown-item" href="<?php echo base_url() . 'cambiarpassword'; ?>">Cambiar contraseña</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url(); ?>auth/logout">Cerrar sesión</a>
                        <?php echo ENVIRONMENT == 'testing'? '<a class="dropdown-item" href="'.base_url().'auth/logout/all">Cerrar completamente</a>':'';?>
                    </div>
                </li>
            </ul>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>
    </div>
</nav>
<!-- End Navbar -->