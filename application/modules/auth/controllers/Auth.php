<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MX_Controller
{
    protected $token;

    public function __construct()
    {
        parent::__construct();

        //Cargo configuraciones personalizadas
        $this->config->load('custom_config');
        $this->data_captcha_google = $this->config->item('data_captcha_google');

        $this->google_api = $this->config->item('google_api');
        $this->linkedin_api = $this->config->item('linkedin_api');


        //Cargo Helper de Recaptcha de Google y Correo
        $this->load->helper(array('grecaptcha_helper', 'send_email_helper'));

        //Cargo Libreria que repara bug de form_validation
        $this->load->library(array('my_form_validation'));
        $this->form_validation->run($this);

        $this->load->model('Auth_model');
    }

    public function index()
    {
        switch (ENVIRONMENT) {
            case 'development':
                redirect(base_url('auth/login'));
                break;
            case 'testing':
                redirect(base_url() . 'auth/prelogin');
            case 'production':
                redirect(base_url() . URI_WP);
                break;
        }
    }

    public function prelogin()
    {
        if (ENVIRONMENT != 'testing') {
            redirect(base_url() . URI_WP);
        }
        if($this->session->userdata('prelogin')){
            redirect(base_url().'auth/login');
        }
        if ($this->input->post()) {
            $this->loginrules();

            if ($this->form_validation->run() != FALSE) {
                $email = $this->input->post('email');
                $pw_post = $this->input->post('password');
                $user_data = $this->Auth_model->getUserDataAndPasswordByEmail($email);
                if ($user_data && password_verify($pw_post, @$user_data->password)) {
                    if ($user_data->rol_id == ROL_ADMIN_PLATAFORMA) {

                        switch ($user_data->estado_id) {
                            case USR_DISABLED:
                                $mensaje_status_login = 'Su cuenta se encuentra Deshabilitada.';
                                break;
                            case USR_VERIFIED:
                            case USR_ENABLED:
                                $this->session->set_userdata('prelogin', true);
                                redirect(base_url() . 'auth/login');
                                break;
                        }
                    }
                    $_SESSION['mensaje_back'] = $mensaje_status_login;
                    redirect(base_url() . URI_WP . '/mensajes');
                } else {
                    $data['error_message'] = 'Usuario y/o Password incorrecto.';
                }
            }
        }
        $data['files_js'] = array('grecaptcha.js');
        $data['recaptcha'] = true;
        $data['sections_view'] = "prelogin_form_view";
        $this->load->view('layout_front_view', $data);
    }

    public function login()
    {
        if (ENVIRONMENT == 'testing') {
            if (!$this->session->userdata('prelogin')) {
                redirect(base_url() . 'auth/prelogin');
            };
        }
        
        if ($this->session->userdata('user_data')) {
            redirect(base_url() . 'home');
        }
        if ($this->input->post()) {
            $this->loginrules();

            if ($this->form_validation->run() != FALSE) {
                var_dump('paso el post y las validaciones');die();
                $email = $this->input->post('email');
                $pw_post = $this->input->post('password');
                $user_data = $this->Auth_model->getUserDataAndPasswordByEmail($email);
                if (ENVIRONMENT != 'production') {
                    $no_password = true;
                }
                if ($user_data && (@$no_password || password_verify($pw_post, @$user_data->password))) {
                    if ($user_data->reiniciar_password_fecha != NULL) { //si habia un pedido de reinicio de contraseña pero el usuario se acordo la password seteo a null el pedido de reinicio de password
                        $user_update['reiniciar_password_fecha'] = NULL;
                        $this->Auth_model->updateUser($user_update, $email);
                    }

                    if (ENVIRONMENT == 'development') {
                        $enlace_para_validar_email = base_url() . 'auth/resend_verify_email';
                    } else {
                        $enlace_para_validar_email = base_url() . URI_WP . '/validar-e-mail';
                    }

                    switch ($user_data->estado_id) {
                        case USR_PENDING:
                            $mensaje_status_login = 'Su E-mail, se encuentra pendiente de validación. Por favor revise su correo inclusive la casilla de spam/correo no deseado. Si necesita que se reenvie el e-mail de verificación, haga <a href="' . $enlace_para_validar_email . '">click aquí</a>.';
                            break;
                        case USR_VERIFIED:
                        case USR_ENABLED:
                            $fecha_login['ultimo_login'] = date('Y-m-d H:i:s', time());
                            $this->Auth_model->updateUser($fecha_login, $email);
                            unset($user_data['password']);
                            $this->session->set_userdata('user_data', $user_data);
                            redirect(base_url() . 'home');
                            break;
                        case USR_DISABLED:
                            $mensaje_status_login = 'Su cuenta se encuentra Deshabilitada.';
                            break;
                    }

                    switch (ENVIRONMENT) {
                        case 'development':
                            $this->session->set_flashdata('message', '<div class="alert alert-warning">' . $mensaje_status_login . '</div>');
                            redirect(base_url('auth/message'));
                            break;
                        case 'testing':
                        case 'production':
                            $_SESSION['mensaje_back'] = $mensaje_status_login;
                            redirect(base_url() . URI_WP . '/mensajes');
                            break;
                    }
                } else {
                    if (ENVIRONMENT != 'development') {
                        $_SESSION['error_login'] = '<div class="alert text-white" style="background-color:#9D71CC;">Usuario y/o Password incorrecto.</div>';
                    } else {
                        $data['error_message'] = 'Usuario y/o Password incorrecto.';
                    }
                }
            } else {
                if (ENVIRONMENT != 'development') {
                    $_SESSION['error_login'] = validation_errors();
                }
            }
        }
        switch (ENVIRONMENT) {
            case 'development':
                $data['files_js'] = array('grecaptcha.js');
                $data['recaptcha'] = true;
                $data['sections_view'] = "login_form_view";
                $this->load->view('layout_front_view', $data);
                break;
            case 'testing':
            case 'production':
                redirect(base_url() . URI_WP . '/login-ria');
                break;
        }
    }

    public function logout()
    {
        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . URI_WP . '/login-ria');
        }
        $this->session->sess_destroy();
        switch (ENVIRONMENT) {
            case 'development':
                redirect(base_url('auth/login'));
                break;
            case 'testing':
                $this->session->set_userdata('prelogin', true);
                redirect(base_url() . 'auth/login');
            case 'production':
                redirect(base_url() . URI_WP . '/login-ria');
                break;
        }
    }

    public function reset_password()
    {
        if ($this->input->post()) {
            $this->form_validation->set_error_delimiters('<div class="alert text-white" style="background-color:#9D71CC;">', '</div>');
            $this->form_validation->set_rules(
                'email',
                'E-Mail',
                'trim|required|valid_email',
                array(
                    'required' => 'El campo {field} es obligatorio.'
                )
            );
            $this->form_validation->set_rules(
                'g-recaptcha',
                'Google ReCaptcha V3',
                'required|callback_valid_captcha',
                array(
                    'valid_captcha' => 'El campo {field} no pudo ser validado correctamente, recargue la página e intente nuevamente.',
                )
            );
            if ($this->form_validation->run() !=  FALSE) {
                $email = $this->input->post('email');
                $user_data = $this->Auth_model->getUserDataByEmail($email);
                if ($user_data) {
                    if ($user_data->estado_id == USR_DISABLED) {
                        if (ENVIRONMENT != 'development') {
                            $_SESSION['mensaje_back'] = 'No es posible solicitar un reinicio de contraseña debido a que su cuenta se encuentra deshabilitada, para mas información contactese con los administradores.';
                            redirect(base_url() . URI_WP . '/mensajes');
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger">No es posible solicitar un reinicio de contraseña debido a que su cuenta se encuentra deshabilitada, para mas información contactese con los administradores.</div>');
                            redirect(base_url() . 'auth/message');
                        }
                    }
                    $date = date('Y-m-d H:i:s', time());
                    $set_data_reset['reiniciar_password_fecha'] = $date;
                    $this->Auth_model->updateUser($set_data_reset, $email);

                    $this->load->model('mensajes/Mensajes_model');

                    $configuracion_mensaje_correo_plataforma = $this->Mensajes_model->getMensaje('mensaje_olvide_contraseña');
                    if (ENVIRONMENT != 'development') {
                        $enlace = base_url() . URI_WP . '/cambiar-contrasena?email=' . $email . '&code=' . base64_encode($date);
                    } else {
                        $enlace = base_url() . 'auth/change_password_by_link?email=' . $email . '&code=' . base64_encode($date);
                    }


                    $enlace_reinicio_password = '<a href="' . $enlace . '">' . $enlace . '</a>';

                    $email_mensaje = $configuracion_mensaje_correo_plataforma->texto_mensaje;
                    $email_asunto = $configuracion_mensaje_correo_plataforma->asunto_mensaje;
                    $email_de = $configuracion_mensaje_correo_plataforma->notificador_correo;
                    $nombre_de = $configuracion_mensaje_correo_plataforma->notificador_nombre;
                    $email_para = $email;
                    $buscar_y_reemplazar = array(
                        array('buscar' => '{{NOMBRE_USUARIO}}', 'reemplazar' => $user_data->nombre),
                        array('buscar' => '{{APELLIDO_USUARIO}}', 'reemplazar' => $user_data->apellido),
                        array('buscar' => '{{ENLACE_REINICIO_PASSWORD}}', 'reemplazar' => $enlace_reinicio_password)
                    );

                    for ($i = 0; $i < count($buscar_y_reemplazar); $i++) {
                        $email_mensaje = str_replace($buscar_y_reemplazar[$i]['buscar'], $buscar_y_reemplazar[$i]['reemplazar'], $email_mensaje);
                        $email_asunto = str_replace($buscar_y_reemplazar[$i]['buscar'], $buscar_y_reemplazar[$i]['reemplazar'], $email_asunto);
                    }

                    $email_id = encolar_email($email_de, $nombre_de, $email_para, $email_mensaje, $email_asunto);


                    modules::run('cli/enviarcorreosencolados', $email_id);


                    if (ENVIRONMENT != 'development') {
                        $_SESSION['mensaje_back'] = 'Se envió un correo a la cuenta ' . $email . ', con un enlace temporal, dispone de 48 horas para poder cambiar la contraseña.';
                        redirect(base_url() . URI_WP . '/mensajes');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning">Se envió un correo a la cuenta ' . $email . ', con un enlace temporal, dispone de 48 horas para poder cambiar la contraseña.</div>');
                        redirect(base_url() . 'auth/message');
                    }
                } else {
                    if (ENVIRONMENT != 'development') {
                        $_SESSION['error_message'] = '<div class="alert text-white" style="background-color:#9D71CC;">No se encuentra registrada ninguna cuenta con este email. Verifique que este bien escrito.</div>';
                    } else {
                        $data['error_message'] = '<div class="alert text-white" style="background-color:#9D71CC;">No se encuentra registrada ninguna cuenta con este email. Verifique que este bien escrito.</div>';
                    }
                }
            } else {
                if (ENVIRONMENT != 'development') {
                    $_SESSION['error_message'] = validation_errors();
                }
            }
        }
        switch (ENVIRONMENT) {
            case 'development':
                $data['recaptcha'] = true;
                $data['files_js'] = array('grecaptcha.js');
                $data['sections_view'] = "reset_password_view";
                $this->load->view('layout_front_view', $data);
                break;
            case 'testing':
            case 'production':
                redirect(base_url() . URI_WP . '/recuperar-contrasena');
                break;
        }
    }

    public function resend_verify_email()
    {
        if ($this->input->post()) {
            $this->form_validation->set_error_delimiters('<div class="alert text-white" style="background-color:#9D71CC;">', '</div>');
            $this->form_validation->set_rules(
                'email',
                'E-Mail',
                'trim|required|valid_email',
                array(
                    'required' => 'El campo {field} es obligatorio.'
                )
            );
            $this->form_validation->set_rules(
                'g-recaptcha',
                'Google ReCaptcha V3',
                'required|callback_valid_captcha',
                array(
                    'valid_captcha' => 'El campo {field} no pudo ser validado correctamente, recargue la página e intente nuevamente.',
                )
            );
            if (!$this->form_validation->run() ==  FALSE) {
                $email = $this->input->post('email');
                $user_data = $this->Auth_model->getUserDataByEmail($email);
                if ($user_data) {
                    if ($user_data->estado_id == USR_PENDING) {
                        $this->load->model('registro/Registro_model');

                        $empresa_data = $this->Auth_model->getDataEmpresa($user_data->rol_id, $user_data->id);

                        $configuracion_mensaje_correo_plataforma = $this->Registro_model->getMensajeRegistro($user_data->rol_id);

                        $enlace_email = base_url() . 'auth/verify_email?email=' . $user_data->email . '&code=' . $user_data->codigo_de_verificacion;

                        $enlace_validacion_correo = '<a href="' . $enlace_email . '">' . $enlace_email . '</a>';
                        $email_mensaje = $configuracion_mensaje_correo_plataforma->texto_mensaje;
                        $email_asunto = $configuracion_mensaje_correo_plataforma->asunto_mensaje;
                        $email_de = $configuracion_mensaje_correo_plataforma->notificador_correo;
                        $nombre_de = $configuracion_mensaje_correo_plataforma->notificador_nombre;
                        $email_para = $user_data->email;

                        $buscar_y_reemplazar = array(
                            array('buscar' => '{{NOMBRE_RAZON_SOCIAL}}', 'reemplazar' => $empresa_data->razon_social),
                            array('buscar' => '{{NOMBRE_USUARIO}}', 'reemplazar' => $user_data->nombre),
                            array('buscar' => '{{APELLIDO_USUARIO}}', 'reemplazar' => $user_data->apellido),
                            array('buscar' => '{{ENLACE_VALIDACION_CORREO}}', 'reemplazar' => $enlace_validacion_correo)
                        );

                        for ($i = 0; $i < count($buscar_y_reemplazar); $i++) {
                            $email_mensaje = str_replace($buscar_y_reemplazar[$i]['buscar'], $buscar_y_reemplazar[$i]['reemplazar'], $email_mensaje);
                            $email_asunto = str_replace($buscar_y_reemplazar[$i]['buscar'], $buscar_y_reemplazar[$i]['reemplazar'], $email_asunto);
                        }

                        $email_id = encolar_email($email_de, $nombre_de, $email_para, $email_mensaje, $email_asunto);

                        modules::run('cli/enviarcorreosencolados', $email_id);


                        $mensaje_registro_gral = $this->Registro_model->getMensajeRegistroGral();

                        if (ENVIRONMENT != 'development') {
                            $_SESSION['mensaje_back'] = $mensaje_registro_gral->texto_mensaje;
                            redirect(base_url() . URI_WP . '/mensajes');
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-success">' . $mensaje_registro_gral->texto_mensaje . '</div>');
                            redirect(base_url() . 'auth/message');
                        }
                    } else {
                        if (ENVIRONMENT != 'development') {
                            $enlace_login = base_url('') . URI_WP . '/login-ria';
                        } else {
                            $enlace_login = base_url() . 'auth/login';
                        }
                        switch ($user_data->estado_id) {
                            case USR_VERIFIED:
                            case USR_ENABLED:
                                $mensaje_estado = 'Estimado usuario, su cuenta ya se encuentra activada, intente iniciar sesion <a href="' . $enlace_login . '">Login</a>.';
                                $alert_color = 'success';
                                break;

                            case USR_DISABLED:
                                $mensaje_estado = 'Estimado usuario, su cuentra se encuentra deshabilitada';
                                $alert_color = 'danger';
                                break;
                        }
                        if (ENVIRONMENT != 'development') {
                            $_SESSION['mensaje_back'] = $mensaje_estado;
                            redirect(base_url() . URI_WP . '/mensajes');
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-' . $alert_color . '">' . $mensaje_estado . '</div>');
                            redirect(base_url() . 'auth/message');
                        }
                    }
                } else {
                    if (ENVIRONMENT != 'development') {
                        $_SESSION['error_message'] = 'No se encuentra registrada ninguna cuenta con este email. Verifique que este bien escrito.';
                    } else {
                        $data['error_message'] = 'No se encuentra registrada ninguna cuenta con este email. Verifique que este bien escrito.';
                    }
                }
            } else {
                if (ENVIRONMENT != 'development') {
                    $_SESSION['error_message'] = validation_errors();
                }
            }
        }
        switch (ENVIRONMENT) {
            case 'development':
                $data['recaptcha'] = true;
                $data['files_js'] = array('grecaptcha.js');
                $data['sections_view'] = "resend_verify_email_view";
                $this->load->view('layout_front_view', $data);
                break;
            case 'testing':
            case 'production':
                redirect(base_url() . URI_WP . '/validar-e-mail');
                break;
        }
    }

    public function change_password_by_link()
    {
        if (!($this->input->get('code') && $this->input->get('email'))) {
            switch (ENVIRONMENT) {
                case 'development':
                    redirect(base_url() . 'auth/login');
                    break;
                case 'testing':
                case 'production':
                    redirect(base_url() . URI_WP . '/login-ria');
                    break;
            }
        }
        $code_decoded = base64_decode($this->input->get('code'));
        $user = $this->Auth_model->getUserDataByEmail($this->input->get('email'));
        if ($user) {
            if ($user->estado_id == USR_DISABLED || $user->estado_id == USR_DELETED) {
                if (ENVIRONMENT != 'development') {
                    $_SESSION['mensaje_back'] = 'No es posible realizar un cambio de contraseña debido a que su cuenta se encuentra deshabilitada, para mas información contactese con los administradores.';
                    redirect(base_url() . URI_WP . '/mensajes');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">No es posible realizar un cambio de contraseña debido a que su cuenta se encuentra deshabilitada, para mas información contactese con los administradores.</div>');
                    redirect(base_url() . 'auth/message');
                }
            }
            if ($user->reiniciar_password_fecha == $code_decoded) {

                $dateDB = new DateTime($user->reiniciar_password_fecha);
                $dateNow = new DateTime(date('Y-m-d H:i:s', time()));
                $diff = $dateNow->diff($dateDB);
                $days =  (int)$diff->format('%a');
                if ($days <= 2) {
                    if ($this->input->post()) {
                        $this->form_validation->set_error_delimiters('<div class="alert text-white" style="background-color:#9D71CC;">', '</div>');

                        $this->form_validation->set_rules(
                            'password',
                            'Contraseña nueva',
                            'trim|required|max_length[72]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,72}$/]',
                            array(
                                'required' => 'El campo {field} es obligatorio.',
                                'max_length' => 'El campo {field}, debe tener un máximo de {param} caracteres',
                                'regex_match' => 'La contraseña debe ser alfanumérica, mayor a 6 caracteres y debe contener al menos 1 caracter en mayúscula y al menos 1 caracter en minúscula.'
                            )
                        );

                        $this->form_validation->set_rules(
                            're_password',
                            'Confirmar contraseña',
                            'trim|required|matches[password]',
                            array(
                                'required' => 'El campo {field} es obligatorio.',
                                'matches'  => 'Las contraseñas no coinciden.'
                            )
                        );
                        if ($this->form_validation->run() !=  FALSE) {
                            $user_data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
                            $user_data['reiniciar_password_fecha'] = NULL;
                            if ($user->estado_id == USR_PENDING || $user->estado_id == USR_VERIFIED) {
                                $user_data['estado_id'] = USR_ENABLED;
                            }
                            $this->Auth_model->updateUser($user_data, $user->email);

                            $this->load->model('mensajes/Mensajes_model');

                            $mensaje_de_la_plataforma = $this->Mensajes_model->getMensaje('mensaje_cambio_contraseña');

                            $email_mensaje = $mensaje_de_la_plataforma->texto_mensaje;
                            $email_asunto = $mensaje_de_la_plataforma->texto_mensaje;
                            $email_de = $mensaje_de_la_plataforma->notificador_correo;
                            $nombre_de = $mensaje_de_la_plataforma->notificador_nombre;
                            $email_para = $user->email;

                            $email_id = encolar_email($email_de, $nombre_de, $email_para, $email_mensaje, $email_asunto);

                            modules::run('cli/enviarcorreosencolados', $email_id);

                            switch (ENVIRONMENT) {
                                case 'development':
                                    $this->session->set_flashdata('message', '<div class="alert alert-success">' . $mensaje_de_la_plataforma->texto_mensaje . '</a>');
                                    redirect(base_url() . 'auth/message');
                                    break;
                                case 'testing':
                                case 'production':
                                    $_SESSION['mensaje_back'] = $mensaje_de_la_plataforma->texto_mensaje;
                                    redirect(base_url() . URI_WP . '/mensajes');
                                    break;
                            }
                        } else {
                            if (ENVIRONMENT != 'development') {
                                $_SESSION['error_message'] = validation_errors();
                                redirect(base_url() . URI_WP . '/cambiar-contrasena?email=' . $this->input->get('email') . '&code=' . $this->input->get('code'));
                            }
                        }
                    }
                } else {
                    $_SESSION['mensaje_back'] = 'El enlace expiró, intente solicitar un reinicio de contaseña nuevamente haciendo <a href="' . base_url() . URI_WP . '/recuperar-contrasena">click aquí</a>.';
                    redirect(base_url() . URI_WP . '/mensajes');
                }
            } else {
                switch (ENVIRONMENT) {
                    case 'development':
                        $this->session->set_flashdata('message', '<div class="alert alert-danger">Código de validación incorrecto.</a>');
                        redirect(base_url() . 'auth/message');
                        break;
                    case 'testing':
                    case 'production':
                        $_SESSION['mensaje_back'] = 'Código de validación incorrecto.';
                        redirect(base_url() . URI_WP . '/mensajes');
                        break;
                }
            }
        } else {
            switch (ENVIRONMENT) {
                case 'development':
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">El usuario indicado no existe.</a>');
                    redirect(base_url() . 'auth/message');
                    break;
                case 'testing':
                case 'production':
                    $_SESSION['mensaje_back'] = 'El usuario indicado no existe.';
                    redirect(base_url() . URI_WP . '/mensajes');
                    break;
            }
        }
        switch (ENVIRONMENT) {
            case 'development':
                $data['recaptcha'] = true;
                $data['files_js'] = array('grecaptcha.js');
                $data['sections_view'] = "change_password_by_link_view";
                $this->load->view('layout_front_view', $data);
                break;
            case 'testing':
            case 'production':
                redirect(base_url() . URI_WP . '/cambiar-contrasena?email=' . $this->input->get('email') . '&code=' . $this->input->get('code'));
                break;
        }
    }

    public function verify_email()
    {
        if ($this->input->get('email') && $this->input->get('code')) {
            $email = $this->input->get('email');
            $user = $this->Auth_model->getUserDataByEmail($email);
            if ($user && @$user->codigo_de_verificacion == $this->input->get('code')) {
                switch ($user->estado_id) {
                    case USR_PENDING:
                        $data_user['estado_id'] = USR_ENABLED;
                        $this->load->model('mensajes/Mensajes_model');
                        $this->Auth_model->updateUser($data_user, $email);

                        $configuracion_mensaje_correo_plataforma = $this->Mensajes_model->getMensaje('mensaje_cuenta_verificada');

                        $email_mensaje = $configuracion_mensaje_correo_plataforma->texto_mensaje;
                        $email_asunto = $configuracion_mensaje_correo_plataforma->asunto_mensaje;
                        $email_de = $configuracion_mensaje_correo_plataforma->notificador_correo;
                        $nombre_de = $configuracion_mensaje_correo_plataforma->notificador_nombre;
                        $email_para = $email;

                        $email_id = encolar_email($email_de, $nombre_de, $email_para, $email_mensaje, $email_asunto);

                        modules::run('cli/enviarcorreosencolados', $email_id);



                        $mensaje_verificacion = $email_mensaje;
                        $color_verificacion = 'success';

                        break;
                    case USR_VERIFIED:
                    case USR_ENABLED:
                        $mensaje_verificacion = 'Estimado usuario, su cuenta ya se encuentra habilitada, intente iniciar sesión con sus credenciales.';
                        $color_verificacion = 'success';
                        break;
                    case USR_DISABLED:
                        $mensaje_verificacion = 'Estimado usuario, su cuenta se encuentra deshabilitada, para mas información contactese con los administradores.';
                        $color_verificacion = 'danger';
                        break;
                }
                switch (ENVIRONMENT) {
                    case 'development':
                        $this->session->set_flashdata('message', '<div class="alert alert-' . $color_verificacion . '">' . $mensaje_verificacion . '</div>');
                        redirect(base_url() . 'auth/message');
                        break;
                    case 'testing':
                    case 'production':
                        $_SESSION['mensaje_back'] = $mensaje_verificacion;
                        redirect(base_url() . URI_WP . '/mensajes');
                        break;
                }
            } else {
                $mensaje_verificacion = 'La cuenta de correo no es valida, o el código de verificación es incorrecto, verifique que el enlace este correctamente. Si el problema persiste contactese con nosotros.';
                $color_verificacion = 'danger';
                switch (ENVIRONMENT) {
                    case 'development':
                        $this->session->set_flashdata('message', '<div class="alert alert-' . $color_verificacion . '">' . $mensaje_verificacion . '</div>');
                        redirect(base_url() . 'auth/message');
                        break;
                    case 'testing':
                    case 'production':
                        $_SESSION['mensaje_back'] = $mensaje_verificacion;
                        redirect(base_url() . URI_WP . '/mensajes');
                        break;
                }
            }
        }
        switch (ENVIRONMENT) {
            case 'development':
                redirect(base_url() . 'registro');
                break;
            case 'testing':
            case 'production':
                redirect(base_url() . URI_WP . '#registrate');
                break;
        }
    }

    public function message()
    {
        if (ENVIRONMENT != 'development') {
            redirect(base_url() . URI_WP);
        }
        if (!$this->session->flashdata('message')) {
            redirect(base_url() . 'auth/login');
        }
        $data['sections_view'] = "message_view";
        $this->load->view('layout_front_view', $data);
        $this->session->sess_destroy();
    }

    private function loginrules()
    {
        $this->form_validation->set_error_delimiters('<div class="alert text-white" style="background-color:#9D71CC;">', '</div>');
        $this->form_validation->set_rules(
            'email',
            'E-Mail',
            'trim|required|valid_email',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );

        $this->form_validation->set_rules(
            'password',
            'Contraseña',
            'trim|required|max_length[72]',
            array(
                'required' => 'El campo {field} es obligatorio.',
            )
        );
        $this->form_validation->set_rules(
            'g-recaptcha',
            'Google ReCaptcha V3',
            'required|callback_valid_captcha',
            array(
                'valid_captcha' => 'El campo {field} no pudo ser validado correctamente, recargue la página e intente nuevamente.',
            )
        );
    }

    public function valid_captcha($captcha)
    {
        return valid_captcha_helper($captcha);
    }

    public function google_login()
    {
        if (ENVIRONMENT == 'testing') {
            if (!$this->session->userdata('prelogin')) {
                redirect(base_url() . 'auth/prelogin');
            }
        }

        require APPPATH . '../vendor/autoload.php';

        $google_client =  new Google_Client();
        $google_client->setClientId($this->google_api->setClientId);
        $google_client->setClientSecret($this->google_api->setClientSecret);
        $google_client->setRedirectUri(base_url() . $this->google_api->setRedirectUri);

        //endpoints a consultar
        $google_client->addScope('email');
        $google_client->addScope('profile');

        if ($this->input->get('code')) {
            $token = $google_client->fetchAccessTokenWithAuthCode($this->input->get('code'));
            if (!isset($token['error'])) {

                $google_client->setAccessToken($token['access_token']);

                $google_service = new Google_Service_Oauth2($google_client);

                $google_data = $google_service->userinfo->get();

                $user_data['oauth_uid'] = $google_data->id;

                $usuario_existente = $this->Auth_model->getUserDataByEmail($google_data['email']);

                if ($usuario_existente) {
                    if ($usuario_existente->oauth_uid) {
                        //si existe usuario oauth_uid comparo si es igual al oauth_id
                        if ($usuario_existente->oauth_uid != $google_data->id) {
                            //actualizo oauth_id
                            $this->Auth_model->updateUser($user_data, $google_data['email']);
                        }
                    } else {
                        //actualizo oauth_id
                        $this->Auth_model->updateUser($user_data, $google_data['email']);
                    }
                } else {
                    //inserto usuario
                    $user_data['oauth_uid'] = $google_data->id;
                    $user_data['rol_id'] = null;
                    $user_data['nombre'] = $google_data->givenName;
                    $user_data['apellido'] = $google_data->familyName;
                    $user_data['email'] = $google_data->email;


                    $user_data['fecha_alta'] = date('Y-m-d H:i:s', time());
                    $user_data['codigo_de_verificacion'] = md5($user_data['fecha_alta']);

                    $user_data['estado_id'] = 3;
                    $user_data['ultimo_login'] = date('Y-m-d H:i:s', time());

                    $this->Auth_model->insertarUsuarioApi($user_data);

                    $usuario_existente = $this->Auth_model->getUserDataByEmail($google_data['email']);
                }
                //guardo la sesion
                $this->session->set_userdata('user_data', $usuario_existente);
                redirect(base_url() . 'home');
            }
        }
        redirect($google_client->createAuthUrl());
    }

    public function linkedin_login()
    {
        if (ENVIRONMENT == 'testing') {
            if (!$this->session->userdata('prelogin')) {
                redirect(base_url() . 'auth/prelogin');
            }
        }
        // si existe error imprimo el error que linkedin retrono
        if ($this->input->get('error')) {
            $mensaje_status_login = $this->input->get('error_description');
            switch (ENVIRONMENT) {
                case 'development':
                    $this->session->set_flashdata('message', '<div class="alert alert-warning">' . $mensaje_status_login . '</div>');
                    redirect(base_url('auth/message'));
                    break;
                case 'testing':
                case 'production':
                    $_SESSION['mensaje_back'] = $mensaje_status_login;
                    redirect(base_url() . URI_WP . '/mensajes');
                    break;
            }
        } elseif ($this->input->get('code')) { //si no hay error y si existe CODE, quiere decir que el usuario dio su autorizacion
            // User authorized your application
            if ($this->session->userdata('state') == $this->input->get('state')) {


                $this->getAccessTokenLinkedin();

                $user_nombre_y_apellido = $this->getDataLinkedin($this->linkedin_api->urlGetProfileData);
                $user_email = $this->getDataLinkedin($this->linkedin_api->urlGetEmailData);

                // $data_user['nombre'] = $user_nombre_y_apellido->firstName->localized->es_ES;
                // $data_user['apellido'] = $user_nombre_y_apellido->lastName->localized->es_ES;
                // $data_user['email'] = $user_email->elements[0]->{'handle~'}->emailAddress;
                $data_user['linkedin_id'] =  $user_nombre_y_apellido->id;
                $data_user['email_linkedin'] = $user_email->elements[0]->{'handle~'}->emailAddress;


                $usuario_existente = $this->Auth_model->getUserDataByEmail($user_email->elements[0]->{'handle~'}->emailAddress);

                if ($usuario_existente) {
                    if ($usuario_existente->linkedin_id) {
                        //si existe usuario oauth_uid comparo si es igual al oauth_id
                        if ($usuario_existente->linkedin_id != $data_user['linkedin_id']) {
                            //actualizo oauth_id
                            $this->Auth_model->updateUser($data_user, $data_user['email_linkedin']);
                        }
                    } else {
                        //actualizo oauth_id
                        $this->Auth_model->updateUser($data_user, $data_user['email_linkedin']);
                    }
                } else {
                    //inserto usuario

                    $data_user['nombre'] = $user_nombre_y_apellido->firstName->localized->es_ES;
                    $data_user['apellido'] = $user_nombre_y_apellido->lastName->localized->es_ES;
                    $data_user['email'] = $user_email->elements[0]->{'handle~'}->emailAddress;
                    $data_user['rol_id'] = null;

                    $data_user['fecha_alta'] = date('Y-m-d H:i:s', time());
                    $data_user['codigo_de_verificacion'] = md5($data_user['fecha_alta']);

                    $data_user['estado_id'] = 3;
                    $data_user['ultimo_login'] = date('Y-m-d H:i:s', time());

                    $this->Auth_model->insertarUsuarioApi($data_user);

                    $usuario_existente = $this->Auth_model->getUserDataByEmail($data_user['email']);
                }
                //guardo la sesion
                $this->session->set_userdata('user_data', $usuario_existente);
                redirect(base_url() . 'home');
            }
        }
        // Start authorization process
        $this->getAuthorizationCodeLinkedin();
    }

    protected function getAuthorizationCodeLinkedin()
    {
        $params = array(
            'response_type' => 'code',
            'client_id' => $this->linkedin_api->clientId,
            'scope' => $this->linkedin_api->scope,
            'state' => uniqid('', true), // unique long string
            'redirect_uri' => base_url() . $this->linkedin_api->redirectUri,
        );

        // Authentication request
        $url = $this->linkedin_api->urlAuthorization . http_build_query($params);

        // Needed to identify request when it returns to us
        $this->session->set_userdata('state', $params['state']);

        // Redirect user to authenticate
        redirect($url);
    }

    protected function getDataLinkedin($url)
    {
        $options = array('http' => array(
            'method'  => 'GET',
            'header' => 'Authorization: Bearer ' . $this->token->access_token
        ));
        $context  = stream_context_create($options);
        $data = json_decode(file_get_contents($url, false, $context));

        return $data;
    }

    protected function getAccessTokenLinkedin()
    {
        // Access Token request
        $result = $this->http_post($this->linkedin_api->urlAccessToken, 'POST', array(
            'grant_type' => 'authorization_code',
            'client_id' => $this->linkedin_api->clientId,
            'client_secret' => $this->linkedin_api->clientSecret,
            'code' => $this->input->get('code'),
            'redirect_uri' => base_url() . $this->linkedin_api->redirectUri,
        ), false);

        // Retrieve access token information

        // Native PHP object, please
        $this->token = json_decode($result['body']);

        return;
    }

    protected function http_post($url, $method, $data, $ignore_errors = false)
    {
        $data_query = http_build_query($data);
        $data_len = strlen($data_query);

        $headers = array(
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/xml',
            'Content-Length' => $data_len
        );

        $response =
            file_get_contents($url, false, stream_context_create(
                array(
                    'http' => array(
                        'method' => $method,
                        'header' => $this->prepare_headers($headers),
                        'content' => $data_query,
                        'ignore_errors' => $ignore_errors
                    )
                )
            ));

        return (false === $response) ? false :
            array(
                'headers' => $http_response_header,
                'body' => $response
            );
    }

    protected function prepare_headers($headers)
    {
        return
            implode(
                '',
                array_map(function ($key, $value) {
                    return "$key: $value\r\n";
                }, array_keys($headers), array_values($headers))
            );
    }
}
