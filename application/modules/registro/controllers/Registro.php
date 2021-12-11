<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registro extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();

        //Cargo configuraciones personalizadas
        $this->config->load('custom_config');
        $this->data_captcha_google = $this->config->item('data_captcha_google');

        //Cargo Helper de Recaptcha de Google y Correo
        $this->load->helper(array('grecaptcha_helper', 'send_email_helper'));

        //Cargo Libreria que repara bug de form_validation
        $this->load->library(array('my_form_validation'));
        $this->form_validation->run($this);

        $this->load->model('Registro_model');
    }

    public function index()
    {
        if ($this->input->post()) {
            $this->rulesRegistro();
            if (!$this->form_validation->run() == FALSE) {

                $user_data['nombre'] = ucwords(mb_strtolower($this->input->post('name'), 'UTF-8'));
                $user_data['apellido'] = ucwords(mb_strtolower($this->input->post('lastname'), 'UTF-8'));
                $user_data['email'] = $this->input->post('email');
                $user_data['telefono'] = $this->input->post('phone');
                $user_data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);

                //SI tipo de empresa es mayor o igual a rol_partner (ROL_PARTNER  = 5 los valores superiores a 5 tmb son partner, por ahora....) seteo rol_id partner.
                if ($this->input->post('kind_of_enterprise') >= ROL_PARTNER) {
                    $user_data['rol_id'] = ROL_PARTNER;
                    $enterprise_data['tipo_de_partner_id'] = $this->input->post('kind_of_enterprise');
                } else {
                    $user_data['rol_id'] = $this->input->post('kind_of_enterprise');
                }

                $user_data['fecha_alta'] = date('Y-m-d H:i:s', time());
                $user_data['codigo_de_verificacion'] = md5($user_data['fecha_alta']);

                $enterprise_data['consentimiento'] = true;
                $enterprise_data['razon_social'] = ucwords(mb_strtolower($this->input->post('enterprise_name')));
                $enterprise_data['objetivo_y_motivacion'] = $this->input->post('objetive_and_motivation');

                switch ($user_data['rol_id']) {
                    case ROL_STARTUP:
                        $table_enterprise = 'startups';
                        break;
                    case ROL_EMPRESA:
                        $table_enterprise = 'empresas';
                        break;
                    case ROL_PARTNER:
                        $table_enterprise = 'partners';
                        break;
                }
                $this->Registro_model->setUserAndEnterprise($user_data, $enterprise_data, $table_enterprise);

                $configuracion_mensaje_correo_plataforma = $this->Registro_model->getMensajeRegistro($user_data['rol_id']);

                $enlace_email = base_url() . 'auth/verify_email?email=' . $user_data['email'] . '&code=' . $user_data['codigo_de_verificacion'];

                $enlace_validacion_correo = '<a href="' . $enlace_email . '">' . $enlace_email . '</a>';
                $email_mensaje = $configuracion_mensaje_correo_plataforma->texto_mensaje;
                $email_asunto = $configuracion_mensaje_correo_plataforma->asunto_mensaje;
                $email_de = $configuracion_mensaje_correo_plataforma->notificador_correo;
                $nombre_de = $configuracion_mensaje_correo_plataforma->notificador_nombre;
                $email_para = $user_data['email'];
                $buscar_y_reemplazar = array(
                    array('buscar' => '{{NOMBRE_RAZON_SOCIAL}}', 'reemplazar' => $enterprise_data['razon_social']),
                    array('buscar' => '{{NOMBRE_USUARIO}}', 'reemplazar' => $user_data['nombre']),
                    array('buscar' => '{{APELLIDO_USUARIO}}', 'reemplazar' => $user_data['apellido']),
                    array('buscar' => '{{ENLACE_VALIDACION_CORREO}}', 'reemplazar' => $enlace_validacion_correo)
                );

                for ($i = 0; $i < count($buscar_y_reemplazar); $i++) {
                    $email_mensaje = str_replace($buscar_y_reemplazar[$i]['buscar'], $buscar_y_reemplazar[$i]['reemplazar'], $email_mensaje);
                    $email_asunto = str_replace($buscar_y_reemplazar[$i]['buscar'], $buscar_y_reemplazar[$i]['reemplazar'], $email_asunto);
                }

                $email_id = encolar_email($email_de, $nombre_de, $email_para, $email_mensaje, $email_asunto);

                exec('php index.php cli enviarcorreosencolados ' . $email_id);

                $mensaje_registro_gral = $this->Registro_model->getMensajeRegistroGral();

                switch (ENVIRONMENT){
                    case 'development':
                        $this->session->set_flashdata('message','<div class="alert alert-success">'.$mensaje_registro_gral->texto_mensaje.'</div>');
                        redirect(base_url().'auth/message');
                        break;
                    case 'testing':
                    case 'production':
                        $_SESSION['mensaje_back'] = $mensaje_registro_gral->texto_mensaje;
                        redirect(base_url() . URI_WP . '/mensajes');
                        break;
                }
                
            } else {
                if(ENVIRONMENT !=='development'){
                    $_SESSION['error_registro'] = validation_errors();
                }
            }
        }
        switch (ENVIRONMENT){ //EN MODO DESARROLLO USO MI PROPIA PLANTILLA DE REGISTRO
            case 'development':
                $data['files_js'] = array('grecaptcha.js');
                $data['recaptcha'] = true;
                $data['sections_view'] = 'registro_view';
                $this->load->view('layout_front_view', $data);
                break;
            case 'testing'://TANTO EN TESTING COMO EN PRODUCCION REDIRECCIONO AL FORMULARIO DE REGISTRO.
            case 'production':
                redirect(base_url() . URI_WP . '#registrate');
                break;
        }
    }

    protected function rulesRegistro()
    {
        $this->form_validation->set_error_delimiters('<div class="alert text-white" style="background-color:#9D71CC">', '</div>');
        $this->form_validation->set_rules(
            'name',
            'Nombre',
            'trim|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );

        $this->form_validation->set_rules(
            'lastname',
            'Apellido',
            'trim|required',
            array(
                'required' => 'El campo {field} es obligatorio.',
            )
        );

        $this->form_validation->set_rules(
            'email',
            'E-Mail',
            'trim|valid_email|required|callback_check_email',
            array(
                'required' => 'El campo {field} es obligatorio.',
                'check_email' => 'El {field} ya se encuentra registrado, intente loguearse con esta cuenta, si no recuerda la clave solicite un reinicio.',
            )
        );

        $this->form_validation->set_rules(
            'phone',
            'Teléfono',
            'trim|required',
            array(
                'required' => 'El campo {field} es obligatorio.',
            )
        );

        $this->form_validation->set_rules(
            'password',
            'Contraseña',
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

        $this->form_validation->set_rules(
            'kind_of_enterprise',
            'Tipo de empresa',
            'integer|required',
            array(
                'required' => 'El campo {field} es obligatorio.',
            )
        );

        $this->form_validation->set_rules(
            'enterprise_name',
            'Nombre de la empresa',
            'trim|required|callback_check_nombre_de_empresa',
            array(
                'required' => 'El campo {field} es obligatorio.',
                'check_nombre_de_empresa' => 'El nombre de esta empresa ya se encuentra registrado'
            )
        );

        $this->form_validation->set_rules(
            'objetive_and_motivation',
            'Objetivo y motivacion',
            'trim|required',
            array(
                'required' => 'Por favor indiquenos, cuales son sus objetivos o motivaciones para participar en Innovación Abierta.',
            )
        );

        $this->form_validation->set_rules(
            'terminos',
            'Acepto los terminos',
            'required',
            array(
                'required' => 'Debe aceptar los terminos para poder continuar.',
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

    public function check_email($email)
    {
        if ($this->Registro_model->getEmail($email)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_nombre_de_empresa($enterprise_name)
    {
        if ($this->Registro_model->getNombreDeEmpresa($enterprise_name, $this->input->post('kind_of_enterprise'))) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
