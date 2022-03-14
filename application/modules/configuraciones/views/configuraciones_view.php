<div class="content" id="top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo base_url(); ?>home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Configuraciones de la plataforma</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12">
                <?php if (isset($message_sweat_alert)) :; ?>
                    <div class="alert alert-<?php echo $message_sweat_alert['status']? 'success':'danger';?>"><?php echo $message_sweat_alert['msg'];?></div>
                <?php endif; ?>
                <div class="card ">
                    <div class="card-header ">
                    </div>
                    <div class="card-body ">
                        <div class="d-flex justify-content-center">
                            <ul class="nav nav-pills nav-pills-primary" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $this->input->post('config_mensajes') ? '' : 'active show'; ?>" data-toggle="tab" href="#link1" role="tablist">
                                        Plataforma
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $this->input->post('config_mensajes') ? 'active show' : ''; ?>" data-toggle="tab" href="#link2" role="tablist">
                                        Mensajes
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <hr>
                        <div class="tab-content tab-space pt-0">

                            <div class="tab-pane <?php echo $this->input->post('config_mensajes') ? '' : 'active show'; ?>" id="link1">
                                <form method="post">
                                    <div class="card-body pt-0">
                                        <div class="row border-bottom mt-0 pt-0 pb-3">
                                            <div class="col-12 pl-0">
                                                <h5 class="font-weight-bold pl-0">Postulaciones</h5>
                                            </div>
                                            <div class="col-md-6 col-lg-4 col-xl-3">
                                                <div class="row">
                                                    <label class="text-primary col-sm-6 col-form-label text-left" for="postulaciones_maximas"><span class="font-weight-bold text-primary">Nro de postulaciones permitidas</span><span class="text-danger"> *</span><br><small>(Cant. Max. de postulaciones simultaneas)</small></label>
                                                    <div class="col-sm-6 d-flex align-items-center">
                                                        <div class="form-group bmd-form-group is-filled">
                                                            <input type="number" min="1" class="form-control text-center" id="postulaciones_maximas" name="postulaciones_maximas" value="<?php echo set_value('postulaciones_maximas', $configuraciones_de_la_plataforma->postulaciones_maximas); ?>" required>
                                                            <?php echo form_error('postulaciones_maximas'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row py-3">

                                            <div class="col-12 pl-0">
                                                <h5 class="font-weight-bold pl-0">Notificaciones</h5>
                                            </div>

                                            <div class="col-md-6 col-lg-4 col-xl-3">
                                                <div class="row">
                                                    <label class="text-primary col-sm-6 col-form-label text-left" for="notificaciones_maximas_header"><span class="font-weight-bold text-primary">Nro de notificaciones en el Header</span><span class="text-danger"> *</span><br><small>(Indicar la cantidad de notificaciones que se mostrarán)</small></label>
                                                    <div class="col-sm-6 d-flex align-items-center">
                                                        <div class="form-group bmd-form-group is-filled">
                                                            <input type="number" min="1" max="9" class="form-control text-center" id="notificaciones_maximas_header" name="notificaciones_maximas_header" value="<?php echo set_value('notificaciones_maximas_header', $configuraciones_de_la_plataforma->notificaciones_maximas_header); ?>" required>
                                                            <?php echo form_error('notificaciones_maximas_header'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4 col-xl-3">
                                                <div class="row">
                                                    <label class="text-primary col-sm-6 col-form-label text-left" for="notificaciones_maximas_menu_lateral"><span class="font-weight-bold text-primary">Nro de notificaciones en el menu ateral</span><span class="text-danger"> *</span><br><small>(Indicar la cantidad de notificaciones que se mostrarán)</small></label>
                                                    <div class="col-sm-6 d-flex align-items-center">
                                                        <div class="form-group bmd-form-group is-filled">
                                                            <input type="number" min="1" max="9" class="form-control text-center" id="notificaciones_maximas_menu_lateral" name="notificaciones_maximas_menu_lateral" value="<?php echo set_value('notificaciones_maximas_menu_lateral', $configuraciones_de_la_plataforma->notificaciones_maximas_menu_lateral); ?>" required>
                                                            <?php echo form_error('notificaciones_maximas_menu_lateral'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row d-flex align-items-center">

                                            <label class="text-primary col-sm-4 col-md-3 col-form-label text-left" for="nombre_notificacion_validador"><span class="font-weight-bold text-primary">Nombre "Validador"</span><span class="text-danger"> *</span><br><small>(Escriba el nombre para mostrar en las notificaciones)</small></label>
                                            <div class="col-sm-8 col-md-9">
                                                <div class="form-group bmd-form-group is-filled">
                                                    <input type="text" maxlength="255" class="form-control" id="nombre_notificacion_validador" name="nombre_notificacion_validador" value="<?php echo set_value('nombre_notificacion_validador', $configuraciones_de_la_plataforma->nombre_notificacion_validador); ?>" required>
                                                    <?php echo form_error('nombre_notificacion_validador'); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row d-flex align-items-center">

                                            <label class="text-primary col-sm-4 col-md-3 col-form-label text-left" for="correo_notificacion_validador"><span class="font-weight-bold text-primary">Correo "Validador"</span><span class="text-danger"> *</span><br><small>(Escriba la cuenta de correo que se mostrará en las notificaciones)</small></label>
                                            <div class="col-sm-8 col-md-9">
                                                <div class="form-group bmd-form-group is-filled">
                                                    <input type="email" maxlength="255" class="form-control" id="correo_notificacion_validador" name="correo_notificacion_validador" value="<?php echo set_value('correo_notificacion_validador', $configuraciones_de_la_plataforma->correo_notificacion_validador); ?>" required>
                                                    <?php echo form_error('correo_notificacion_validador'); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row d-flex align-items-center">

                                            <label class="text-primary col-sm-4 col-md-3 col-form-label text-left" for="nombre_notificacion_admin_plataforma"><span class="font-weight-bold text-primary">Nombre "Admin Plataforma"</span><span class="text-danger"> *</span><br><small>(Escriba el nombre para mostrar en las notificaciones)</small></label>
                                            <div class="col-sm-8 col-md-9">
                                                <div class="form-group bmd-form-group is-filled">
                                                    <input type="text" maxlength="255" class="form-control" id="nombre_notificacion_admin_plataforma" name="nombre_notificacion_admin_plataforma" value="<?php echo set_value('nombre_notificacion_admin_plataforma', $configuraciones_de_la_plataforma->nombre_notificacion_admin_plataforma); ?>" required>
                                                    <?php echo form_error('nombre_notificacion_admin_plataforma'); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row d-flex align-items-center">

                                            <label class="text-primary col-sm-4 col-md-3 col-form-label text-left" for="correo_notificacion_admin_plataforma"><span class="font-weight-bold text-primary">Correo "Admin Plataforma"</span><span class="text-danger"> *</span><br><small>(Escriba la cuenta de correo que se mostrará en las notificaciones)</small></label>
                                            <div class="col-sm-8 col-md-9">
                                                <div class="form-group bmd-form-group is-filled">
                                                    <input type="email" maxlength="255" class="form-control" id="correo_notificacion_admin_plataforma" name="correo_notificacion_admin_plataforma" value="<?php echo set_value('correo_notificacion_admin_plataforma', $configuraciones_de_la_plataforma->correo_notificacion_admin_plataforma); ?>" required>
                                                    <?php echo form_error('correo_notificacion_admin_plataforma'); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row d-flex align-items-center">

                                            <label class="text-primary col-sm-4 col-md-3 col-form-label text-left" for="nombre_notificacion_no_responder"><span class="font-weight-bold text-primary">Nombre "No Responder"</span><span class="text-danger"> *</span><br><small>(Escriba el nombre para mostrar en las notificaciones)</small></label>
                                            <div class="col-sm-8 col-md-9">
                                                <div class="form-group bmd-form-group is-filled">
                                                    <input type="text" maxlength="255" class="form-control" id="nombre_notificacion_no_responder" name="nombre_notificacion_no_responder" value="<?php echo set_value('nombre_notificacion_no_responder', $configuraciones_de_la_plataforma->nombre_notificacion_no_responder); ?>" required>
                                                    <?php echo form_error('nombre_notificacion_no_responder'); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row d-flex align-items-center">

                                            <label class="text-primary col-sm-4 col-md-3 col-form-label text-left" for="correo_notificacion_no_responder"><span class="font-weight-bold text-primary">Correo "No Responder"</span><span class="text-danger"> *</span><br><small>(Escriba la cuenta de correo que se mostrará en las notificaciones)</small></label>
                                            <div class="col-sm-8 col-md-9">
                                                <div class="form-group bmd-form-group is-filled">
                                                    <input type="email" maxlength="255" class="form-control" id="correo_notificacion_no_responder" name="correo_notificacion_no_responder" value="<?php echo set_value('correo_notificacion_no_responder', $configuraciones_de_la_plataforma->correo_notificacion_no_responder); ?>" required>
                                                    <?php echo form_error('correo_notificacion_no_responder'); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row d-flex align-items-center">

                                            <label class="text-primary col-sm-4 col-md-3 col-form-label text-left" for="nombre_notificacion_comunicacion"><span class="font-weight-bold text-primary">Nombre "Comunicación"</span><span class="text-danger"> *</span><br><small>(Escriba el nombre para mostrar en las notificaciones)</small></label>
                                            <div class="col-sm-8 col-md-9">
                                                <div class="form-group bmd-form-group is-filled">
                                                    <input type="text" maxlength="255" class="form-control" id="nombre_notificacion_comunicacion" name="nombre_notificacion_comunicacion" value="<?php echo set_value('nombre_notificacion_comunicacion', $configuraciones_de_la_plataforma->nombre_notificacion_comunicacion); ?>" required>
                                                    <?php echo form_error('nombre_notificacion_comunicacion'); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row d-flex align-items-center">

                                            <label class="text-primary col-sm-4 col-md-3 col-form-label text-left" for="correo_notificacion_comunicacion"><span class="font-weight-bold text-primary">Correo "Comunicación"</span><span class="text-danger"> *</span><br><small>(Escriba la cuenta de correo que se mostrará en las notificaciones)</small></label>
                                            <div class="col-sm-8 col-md-9">
                                                <div class="form-group bmd-form-group is-filled">
                                                    <input type="email" maxlength="255" class="form-control" id="correo_notificacion_comunicacion" name="correo_notificacion_comunicacion" value="<?php echo set_value('correo_notificacion_comunicacion', $configuraciones_de_la_plataforma->correo_notificacion_comunicacion); ?>" required>
                                                    <?php echo form_error('correo_notificacion_comunicacion'); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row d-flex align-items-center">

                                            <label class="text-primary col-sm-4 col-md-3 col-form-label text-left" for="nombre_notificacion_informacion"><span class="font-weight-bold text-primary">Nombre "Información"</span><span class="text-danger"> *</span><br><small>(Escriba el nombre para mostrar en las notificaciones)</small></label>
                                            <div class="col-sm-8 col-md-9">
                                                <div class="form-group bmd-form-group is-filled">
                                                    <input type="text" maxlength="255" class="form-control" id="nombre_notificacion_informacion" name="nombre_notificacion_informacion" value="<?php echo set_value('nombre_notificacion_informacion', $configuraciones_de_la_plataforma->nombre_notificacion_informacion); ?>" required>
                                                    <?php echo form_error('nombre_notificacion_informacion'); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row d-flex align-items-center">

                                            <label class="text-primary col-sm-4 col-md-3 col-form-label text-left" for="correo_notificacion_informacion"><span class="font-weight-bold text-primary">Correo "Información"</span><span class="text-danger"> *</span><br><small>(Escriba la cuenta de correo que se mostrará en las notificaciones)</small></label>
                                            <div class="col-sm-8 col-md-9">
                                                <div class="form-group bmd-form-group is-filled">
                                                    <input type="email" maxlength="255" class="form-control" id="correo_notificacion_informacion" name="correo_notificacion_informacion" value="<?php echo set_value('correo_notificacion_informacion', $configuraciones_de_la_plataforma->correo_notificacion_informacion); ?>" required>
                                                    <?php echo form_error('correo_notificacion_informacion'); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 text-right mt-5 border-top pt-5">
                                            <button type="submit" name="config_plataforma" value="config_plataforma" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Configuraciones de mensajes -->

                            <div class="tab-pane <?php echo $this->input->post('config_mensajes') ? 'active show' : ''; ?>" id="link2">

                                <div class="row text-center">
                                    <div class="col-12">
                                        <label>Escriba y seleccione un mensaje.
                                            <input list="dataListTitulosMensajes" id="dataListTitulosMensajesInput" class="form-control">
                                        </label>
                                        <datalist id="dataListTitulosMensajes">
                                            <?php
                                            foreach ($mensajes_de_la_plataforma as $mensaje_de_la_plataforma) : ?>
                                                <option value="<?php echo $mensaje_de_la_plataforma->id . '-' . $mensaje_de_la_plataforma->titulo_mensaje; ?>"><?php echo $mensaje_de_la_plataforma->id . '-' . $mensaje_de_la_plataforma->titulo_mensaje; ?></option>
                                            <?php endforeach; ?>
                                        </datalist>
                                        <button class="btn btn-sm btn-primary m-2" id="dataListTitulosMensajesBotonIrAlMensaje">Ir al mensaje</button>

                                        <button class="btn btn-sm btn-primary m-2" id="dataListTitulosMensajesBotonLimpiar">Limpiar</button>
                                    </div>
                                    <div class="col-12" id="dataListTitulosMensajesError" style="display:none;">
                                        <small class="badge badge-danger">Debe elegir un mensaje del listado.</small>
                                    </div>

                                </div>

                                <form method="post">
                                    <div class="card-body">
                                        <?php $i = 0;
                                        foreach ($mensajes_de_la_plataforma as $mensaje_de_la_plataforma) : ?>
                                            <div style="<?php echo $i % 2 != 0 ? 'background-color:#d6d6d610' : ''; ?>" id="card-mensaje-id-<?php echo $mensaje_de_la_plataforma->id; ?>" class="border my-5 p-5">
                                                <input type="hidden" value="<?php echo $mensaje_de_la_plataforma->id; ?>" name="mensaje_id[]">
                                                <?php echo form_error('mensaje_id[]'); ?>
                                                <h5 class="font-weight-bold text-primary"><?php echo $mensaje_de_la_plataforma->titulo_mensaje; ?></h5>
                                                <?php if ($mensaje_de_la_plataforma->tipo_de_mensaje_id == MSJ_PLATAFORMA) :; ?>
                                                    <input type="hidden" name="asunto_mensaje[]" value="NULL">
                                                <?php else :; ?>
                                                    <div class="row">
                                                        <label class="text-primary col-sm-2 col-form-label">Asunto <span class="text-danger"> *</span></label>
                                                        <div class="col-sm-10">
                                                            <div class="form-group bmd-form-group is-filled">
                                                                <input type="text" class="form-control" name="asunto_mensaje[]" value="<?php echo $mensaje_de_la_plataforma->asunto_mensaje; ?>" required>
                                                            </div>
                                                            <?php echo form_error('asunto_mensaje[]'); ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="row">
                                                    <label class="text-primary col-sm-2 col-form-label">Mensaje <span class="text-danger"> *</span></label>
                                                    <div class="col-sm-10">
                                                        <div class="form-group bmd-form-group is-filled">
                                                            <textarea class="form-control" name="texto_mensaje[]" rows="5" required><?php echo $mensaje_de_la_plataforma->texto_mensaje; ?></textarea>
                                                        </div>
                                                        <?php echo form_error('texto_mensaje[]'); ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="text-primary col-sm-2 col-form-label">Tipo de mensaje: <small></small></label>
                                                    <label class="col-form-label text-left pl-3 text-dark col-sm-10">
                                                        <?php switch ($mensaje_de_la_plataforma->tipo_de_mensaje_id) {
                                                            case MSJ_PLATAFORMA:
                                                                echo 'Mensaje de plataforma';
                                                                break;
                                                            case MSJ_NOTIFICACION:
                                                                echo 'Mensaje de notificación.';
                                                                break;
                                                            case MSJ_EMAIL:
                                                                echo 'Mensaje solo para ser enviado por E-Mail.';
                                                                break;
                                                            case MSJ_NOTIF_EMAIL:
                                                                echo 'Definido por el admin plataforma.';
                                                                break;
                                                        } ?>
                                                    </label>
                                                </div>
                                                <?php if ($mensaje_de_la_plataforma->tipo_de_mensaje_id == MSJ_NOTIF_EMAIL) :; ?>
                                                    <div class="row">
                                                        <label class="text-primary col-sm-2 col-form-label">Tipo de envio <span class="text-danger"> *</span></label>
                                                        <div class="col-sm-10 mt-3">
                                                            <select class="select_chosen" data-style="select-with-transition" name="tipo_de_envio_id[]" title="Elija un tipo de notificación" data-size="9" tabindex="-98" required>
                                                                <?php foreach ($tipos_de_envio as $tipo_de_envio) :; ?>
                                                                    <option value="<?php echo $tipo_de_envio->id; ?>" <?php echo @$this->input->post('tipo_de_envio_id')[$i] == $tipo_de_envio->id || $mensaje_de_la_plataforma->tipo_de_envio_id == $tipo_de_envio->id ? 'selected' : ''; ?>><?php echo $tipo_de_envio->descripcion_de_envio; ?> </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <?php echo form_error('tipo_de_envio_id[]'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="text-primary col-sm-2 col-form-label">Enviar mensaje desde <span class="text-danger"> *</span></label>
                                                        <div class="col-sm-10 mt-3">
                                                            <select class="select_chosen" data-style="select-with-transition" name="notificador_id[]" title="Elija un notificador" data-size="9" tabindex="-98" required>
                                                                <?php foreach ($notificadores as $notificador) :; ?>
                                                                    <option value="<?php echo $notificador->id; ?>" <?php echo @$this->input->post('notificador_id')[$i] == $notificador->id || $mensaje_de_la_plataforma->notificador_id == $notificador->id ? 'selected' : ''; ?>><?php echo $notificador->notificador_descripcion; ?> </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <?php echo form_error('notificador_id[]'); ?>
                                                        </div>
                                                    </div>
                                                <?php elseif ($mensaje_de_la_plataforma->tipo_de_mensaje_id == MSJ_EMAIL || $mensaje_de_la_plataforma->tipo_de_mensaje_id == MSJ_NOTIFICACION) :; ?>
                                                    <input type="hidden" name="tipo_de_envio_id[]" value="NULL">
                                                    <div class="row">
                                                        <label class="text-primary col-sm-2 col-form-label">Enviar mensaje desde <span class="text-danger"> *</span></label>
                                                        <div class="col-sm-10 mt-3">
                                                            <select class="select_chosen" data-style="select-with-transition" name="notificador_id[]" title="Elija un notificador" data-size="9" tabindex="-98" required>
                                                                <?php foreach ($notificadores as $notificador) :; ?>
                                                                    <option value="<?php echo $notificador->id; ?>" <?php echo @$this->input->post('notificador_id')[$i] == $notificador->id || $mensaje_de_la_plataforma->notificador_id == $notificador->id ? 'selected' : ''; ?>><?php echo $notificador->notificador_descripcion; ?> </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <?php echo form_error('notificador_id[]'); ?>
                                                        </div>
                                                    </div>
                                                <?php elseif ($mensaje_de_la_plataforma->tipo_de_mensaje_id == MSJ_PLATAFORMA) : ?>
                                                    <input type="hidden" name="tipo_de_envio_id[]" value="NULL">
                                                    <input type="hidden" name="notificador_id[]" value="NULL">
                                                <?php endif; ?>
                                                <?php if ($mensaje_de_la_plataforma->personalizadores) :; ?>
                                                    <div class="row">
                                                        <label class="text-primary col-sm-2 col-form-label">Personalizadores <small> (embebe la informacion en el mensaje)</small></label>
                                                        <label class="col-form-label text-left pl-3 text-dark col-sm-10">
                                                            <?php echo $mensaje_de_la_plataforma->personalizadores; ?>
                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php $i++;
                                        endforeach; ?>
                                        <div style="position: fixed;right:30px;bottom:80px;">
                                            <div class="col-12">
                                                <button type="submit" name="config_mensajes" value="config_mensajes" class="btn btn-primary">Guardar</button>
                                            </div>
                                            <div class="col-12 mt-5 text-center">
                                                <a title="Ir arriba" href="#top" style="font-size: 40px;"><i class="fas fa-arrow-alt-circle-up"></i></a>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>