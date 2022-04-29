<div class="user">
    <div class="photo">
        <img src="<?php echo $this->session->userdata('user_data')->logo ? base_url() . 'uploads/imagenes_de_usuarios/'.$this->session->userdata('user_data')->id.'.png?v='.rand() : base_url() . 'assets/img/usuario.jpeg?v='.rand(); ?>">
    </div>
    <div class="user-info">
        <a data-toggle="collapse" href="#collapseUserdata" class="username">
            <span>
                <p><?php echo $this->session->userdata('user_data')->nombre . ' ' . $this->session->userdata('user_data')->apellido; ?>
                    <b class="caret"></b>
                </p>
            </span>
        </a>
        <?php
        //$notificaciones = $this->session->userdata('notificaciones');
        //$notificaciones_sin_leer = 0;
        //foreach ($notificaciones as $notificacion) {
        //    if (!$notificacion->leido) {
        //        $notificaciones_sin_leer++;
        //    }
        //}; ?>
        <div class="collapse" id="collapseUserdata">
            <ul class="nav">
                <!-- <li class="nav-item <?php //echo $this->uri->segment(URI_SEGMENT) == 'notificaciones' ? 'active' : ''; ?>">
                    <a class="nav-link" data-toggle="collapse" href="#menuNotificaciones">
                        <span class="sidebar-mini"> <i class="material-icons notificacion-icono-menu"><?php //echo $notificaciones_sin_leer ? 'notifications_active' : 'notifications'; ?></i> </span>
                        <span class="sidebar-normal">
                            Notificaciones
                            <?php //if ($notificaciones_sin_leer) :; ?>
                                <span class="badge badge-pill badge-primary notificacion-total-menu"><?php //echo $notificaciones_sin_leer; ?></span>
                            <?php //endif; ?>
                        </span>
                    </a>
                    <div class="user collapse <?php //echo $this->uri->segment(URI_SEGMENT) == 'notificaciones' && $this->uri->segment(URI_SEGMENT + 1) == NULL ? 'show' : ''; ?>" id="menuNotificaciones">
                        <ul class="nav">
                            <?php //$notificaciones_maximas_menu = $this->session->userdata('notificaciones_maximas_menu'); ?>
                            <?php //foreach ($notificaciones as $notificacion) :; ?>
                                <li class="nav-item">
                                    <a class="nav-link verNotificacion <?php //echo !$notificacion->leido ? 'font-weight-bold font-italic notificacion-fuente-menu-' . $notificacion->id : ''; ?>" href="#" data-notificacion-id="<?php echo $notificacion->id; ?>" data-toggle="modal" data-target="#notificacionesModal">
                                        <?php //echo !$notificacion->leido ? '<i class="material-icons notificacion-icono-menu-' . $notificacion->id . '">email</i>' : '<i class="material-icons">drafts</i>'; ?>
                                        <span class="sidebar-normal">
                                            <?php
                                            //echo substr($notificacion->titulo_mensaje, 0, 28);
                                            //echo strlen($notificacion->titulo_mensaje) > 28 ? '...' : '';
                                            ?>
                                        </span>
                                    </a>
                                </li>

                                <?php
                                // if (!$notificacion->leido) {
                                //     $notificaciones_sin_leer--;
                                // }
                                // $notificaciones_maximas_menu--;
                                // if ($notificaciones_maximas_menu == 0) {
                                //     break;
                                //}; ?>
                            <?php //endforeach; ?>
                            <li class="nav-item <?php //echo $this->uri->segment(URI_SEGMENT) == 'notificaciones' && $this->uri->segment(URI_SEGMENT + 1) == NULL ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php //echo base_url(); ?>notificaciones">
                                    <i class="material-icons">inbox</i>
                                    <span class="sidebar-normal"> Ver todas las notificaciones&nbsp;&nbsp;<?php //echo $notificaciones_sin_leer ? '<span class="badge badge-pill badge-secondary notificacion-total-bandeja-menu">' . $notificaciones_sin_leer . '</span>' : ''; ?></span>
                                </a>
                            </li>
                        </ul>

                    </div>

                </li> -->
                <li class="nav-item <?php echo $this->uri->segment(URI_SEGMENT) == 'profile' && $this->uri->segment(URI_SEGMENT + 1) == NULL ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo base_url(); ?>profile">
                        <span class="sidebar-mini"> MP </span>
                        <span class="sidebar-normal"> Mi Perfil </span>
                    </a>
                </li>
                <li class="nav-item <?php echo $this->uri->segment(URI_SEGMENT) == 'cambiarpassword' && $this->uri->segment(URI_SEGMENT + 1) == null ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo base_url(); ?>cambiarpassword">
                        <span class="sidebar-mini"> CC </span>
                        <span class="sidebar-normal"> Cambiar contraseña </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>auth/logout">
                        <span class="sidebar-mini"> CS </span>
                        <span class="sidebar-normal"> Cerrar sesión </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>