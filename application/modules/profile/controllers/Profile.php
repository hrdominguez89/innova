<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Profile_model');
        $this->load->library(array('my_form_validation'));
        $this->form_validation->run($this);
    }

    public function index()
    {

        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . 'auth/login');
        }

        $data['data_perfil'] = $this->Profile_model->getPerfilData($this->session->userdata('user_data')->id, $this->session->userdata('user_data')->rol_id);
        //CARGO LAS VISTAS Y SUS DATOS SEGUN EL ROL
        $data['subtitle'] = 'Editar perfil';
        switch ($this->session->userdata('user_data')->rol_id) {
            case ROL_STARTUP:
                $data['categorias'] = $this->Profile_model->getCategorias();
                $data['categorias_seleccionadas'] = $this->Profile_model->getCategoriasSeleccionadas($this->session->userdata('user_data')->id);
                $data['sections_view'] = 'profile_startup_view';
                break;
            case ROL_EMPRESA:
                $data['sections_view'] = 'profile_empresa_view';
                break;
            case ROL_PARTNER:
                $data['tipos_de_partners'] = $this->Profile_model->getTiposDePartners();
                $data['sections_view'] = 'profile_partner_view';
                break;
            case ROL_VALIDADOR: // cambio de nombre ahora es validadores
                $data['sections_view'] = 'profile_validador_view';
                break;
            case ROL_ADMIN_PLATAFORMA:
                $data['sections_view'] = 'profile_admins_view';
                break;
            default:
                $data['subtitle'] = 'Elegir rol';
                $data['sections_view'] = 'profile_cargar_rol_view';
                break;
        }

        $data['files_js'] = array('profile.js', 'perfil/images.js');
        $data['title'] = 'Perfil';



        //SEGUN EL ROL, HAGO VALIDACIONES DEL POST.

        if ($this->input->post()) {
            switch ($this->input->post('formulario')) {
                case 'cambiar_rol':
                    $data['collapse_cambiar_rol'] = !$this->formularioCambiarRol();
                    break;
                case 'eliminar_cuenta':
                    $data['collapse_eliminar_cuenta'] = !$this->formularioEliminarCuenta();
                    break;
                case 'elegir_rol':
                    $this->elegir_rol();
                    break;
                default:
                    $this->formularioPerfil($data);
                    break;
            }
        }


        $this->load->view('layout_back_view', $data);
    }

    function rulesPerfil($data_perfil)
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules(
            'titular',
            'Titular',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'razon_social',
            'Razón social',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        // if (!$data_perfil->logo) {
        //     $this->form_validation->set_rules(
        //         'profile_img',
        //         'Logo de la empresa',
        //         'required',
        //         array(
        //             'required'  => 'El campo {field} es obligatorio',
        //         )
        //     );
        // }
        $this->form_validation->set_rules(
            'cuit',
            'CUIT',
            'numeric|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'email_empresa',
            'E-mail',
            'valid_email',
            array(
                'valid_email' => 'El campo {field} no es un e-mail válido',
            )
        );
        $this->form_validation->set_rules(
            'telefono_empresa',
            'Teléfono',
            'trim'
        );
        $this->form_validation->set_rules(
            'pais',
            'País',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'provincia',
            'Provincia/Estado',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'localidad',
            'Localidad/Ciudad',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'direccion',
            'Dirección',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'url_web',
            'URL Web',
            'trim|valid_url',
            array(
                'valid_url' => 'El campo {field} debe ser una url valida, por ejemplo http://www.example.com',
            )
        );
        $this->form_validation->set_rules(
            'url_youtube',
            'URL YouTube',
            'trim|valid_url',
            array(
                'valid_url' => 'El campo {field} debe ser una url valida, por ejemplo http://www.example.com',
            )
        );
        $this->form_validation->set_rules(
            'url_instagram',
            'URL Instagram',
            'trim|valid_url',
            array(
                'valid_url' => 'El campo {field} debe ser una url valida, por ejemplo http://www.example.com',
            )
        );
        $this->form_validation->set_rules(
            'url_facebook',
            'URL Facebook',
            'trim|valid_url',
            array(
                'valid_url' => 'El campo {field} debe ser una url valida, por ejemplo http://www.example.com',
            )
        );
        $this->form_validation->set_rules(
            'url_twitter',
            'URL Twitter',
            'trim|valid_url',
            array(
                'valid_url' => 'El campo {field} debe ser una url valida, por ejemplo http://www.example.com',
            )
        );

        $this->form_validation->set_rules(
            'url_linkedin',
            'URL Linkedin',
            'trim|valid_url',
            array(
                'valid_url' => 'El campo {field} debe ser una url valida, por ejemplo http://www.example.com',
            )
        );

        $this->form_validation->set_rules(
            'rubro',
            'Rubro',
            'trim',
        );
        $this->form_validation->set_rules(
            'descripcion',
            'Descripción',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'exporta',
            'Exporta',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'nombre',
            'Nombre',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'apellido',
            'Apellido',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'email',
            'E-mail',
            'valid_email|required|callback_validar_email[' . $data_perfil->email . ']',
            array(
                'valid_email' => 'El campo {field} no es un e-mail válido',
                'required'  => 'El campo {field} es obligatorio',
                'validar_email' => 'El E-Mail indicado ya se encuentra en uso.'
            )
        );
        $this->form_validation->set_rules(
            'telefono',
            'Teléfono',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        if ($this->session->userdata('user_data')->rol_id == ROL_STARTUP) {
            $this->form_validation->set_rules(
                'antecedentes',
                'Antecedentes',
                'trim',
            );
            $this->form_validation->set_rules(
                'categories[]',
                'Servicios/Productos que ofrece',
                'integer|required',
                array(
                    'required'  => 'Debe seleccionar al menos un servicio/producto',
                )
            );
            foreach ($this->input->post('category_description') as $key => $value) {
                $this->form_validation->set_rules(
                    'category_description[' . $key . ']',
                    'Descripción',
                    'trim'
                );
            }
        }
    }
    function rulesPerfilAdmin($data_perfil)
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        // if (!$data_perfil->logo) {
        //     $this->form_validation->set_rules(
        //         'profile_img',
        //         'Logo de la empresa',
        //         'required',
        //         array(
        //             'required'  => 'El campo {field} es obligatorio',
        //         )
        //     );
        // }
        $this->form_validation->set_rules(
            'nombre',
            'Nombre',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'apellido',
            'Apellido',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'email',
            'E-mail',
            'valid_email|required|callback_validar_email[' . $data_perfil->email . ']',
            array(
                'valid_email' => 'El campo {field} no es un e-mail válido',
                'required'  => 'El campo {field} es obligatorio',
                'validar_email' => 'El E-Mail indicado ya se encuentra en uso.'
            )
        );
    }

    function rulesPerfilPartner($data_perfil)
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        $this->form_validation->set_rules(
            'razon_social',
            'Razón social',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );

        $this->form_validation->set_rules(
            'descripcion',
            'Descripción',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );

        $this->form_validation->set_rules(
            'url_linkedin',
            'URL Linkedin',
            'trim|valid_url',
            array(
                'valid_url' => 'El campo {field} debe ser una url valida, por ejemplo http://www.example.com',
            )
        );

        $this->form_validation->set_rules(
            'tipo_de_partner',
            'Tipo de partner',
            'trim|integer|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );

        if ($this->input->post('tipo_de_partner') == 8) {
            $this->form_validation->set_rules(
                'descripcion_tipo_de_partner',
                'Describa tipo de partner',
                'trim|required|max_length[100]',
                array(
                    'required'  => 'El campo {field} es obligatorio',
                )
            );
        }

        $this->form_validation->set_rules(
            'nombre',
            'Nombre',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'apellido',
            'Apellido',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'email',
            'E-mail',
            'valid_email|required|callback_validar_email[' . $data_perfil->email . ']',
            array(
                'valid_email' => 'El campo {field} no es un e-mail válido',
                'required'  => 'El campo {field} es obligatorio',
                'validar_email' => 'El E-Mail indicado ya se encuentra en uso.'
            )
        );

        $this->form_validation->set_rules(
            'telefono',
            'Teléfono',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
    }

    public function validar_email($email, $current_email = FALSE)
    {
        if ($current_email && $current_email == $email) {
            return TRUE;
        }
        if ($this->Profile_model->getEmails($email)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function verify_password($password)
    {
        $this->load->model('auth/Auth_model');
        $user_data = $this->Auth_model->getUserDataAndPasswordByEmail($this->session->userdata('user_data')->email);
        if ($user_data && password_verify($password, @$user_data->password)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function formularioEliminarCuenta()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        $this->form_validation->set_rules(
            'password',
            'Contraseña',
            'trim|required|callback_verify_password',
            array(
                'required'  => 'El campo {field} es obligatorio',
                'verify_password' => 'Contraseña incorrecta.'
            )
        );
        if ($this->form_validation->run() != FALSE) {
            $this->load->model('auth/Auth_model');
            $user_data['estado_id'] = USR_DELETED;
            $user_data['usuario_id_modifico'] = $this->session->userdata('user_data')->id;
            $user_data['fecha_modifico'] = date('Y-m-d H:i:s', time());
            if ($this->Auth_model->updateUserById($this->session->userdata('user_data')->id, $user_data)) {
                $mensaje_elimino_cuenta = 'Su cuenta se eliminó correctamente.';
                switch (ENVIRONMENT) {
                    case 'development':
                        $this->session->set_flashdata('message', '<div class="alert alert-warning">' . $mensaje_elimino_cuenta . '</div>');
                        redirect(base_url() . 'auth/message');
                        break;
                    case 'testing':
                    case 'production':
                        $_SESSION['mensaje_back'] = $mensaje_elimino_cuenta;
                        redirect(base_url() . URI_WP . '/mensajes');
                        break;
                }
            }
        } else {
            return FALSE;
        }
    }

    public function formularioCambiarRol()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        $this->form_validation->set_rules(
            'rol',
            'Elija un rol',
            'trim|integer|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        if ($this->form_validation->run() != FALSE) {
            $this->load->model('auth/Auth_model');
            $user_data['rol_id'] = $this->input->post('rol');
            $user_data['usuario_id_modifico'] = $this->session->userdata('user_data')->id;
            $user_data['fecha_modifico'] = date('Y-m-d H:i:s', time());
            $user_data['perfil_completo'] = FALSE;
            $options['accion'] = 'eliminar'; //elimina porque al cambiar de rol elimino de la tabla SEGUN ROL los datos de ese usuario
            $options['rol_id'] = $this->session->userdata('user_data')->rol_id;
            $this->Auth_model->updateUserById($this->session->userdata('user_data')->id, $user_data, $options);
            $this->session->userdata('user_data')->perfil_completo = 0;
            $this->session->userdata('user_data')->rol_id = $this->input->post('rol');
            redirect(base_url() . 'profile');
        } else {
            return FALSE;
        }
    }

    public function formularioPerfil($data)
    {
        if ($this->session->userdata('user_data')->rol_id == ROL_VALIDADOR || $this->session->userdata('user_data')->rol_id == ROL_ADMIN_PLATAFORMA) {
            $this->rulesPerfilAdmin($data['data_perfil']);
        } else if ($this->session->userdata('user_data')->rol_id == ROL_PARTNER) {
            $this->rulesPerfilPartner($data['data_perfil']);
        } else {
            $this->rulesPerfil($data['data_perfil']);
        }

        if ($this->form_validation->run() != FALSE) {
            switch ($this->session->userdata('user_data')->rol_id) {
                case ROL_STARTUP:
                    $data_startup['titular'] = $this->input->post('titular');
                    $data_startup['razon_social'] = $this->input->post('razon_social');
                    $data_startup['cuit'] = $this->input->post('cuit');
                    $data_startup['email_startup'] = $this->input->post('email_startup');
                    $data_startup['telefono_startup'] = $this->input->post('telefono_startup');
                    $data_startup['pais'] = $this->input->post('pais');
                    $data_startup['provincia'] = $this->input->post('provincia');
                    $data_startup['localidad'] = $this->input->post('localidad');
                    $data_startup['direccion'] = $this->input->post('direccion');
                    $data_startup['url_web'] = $this->input->post('url_web');
                    $data_startup['url_youtube'] = $this->input->post('url_youtube');
                    $data_startup['url_instagram'] = $this->input->post('url_instagram');
                    $data_startup['url_facebook'] = $this->input->post('url_facebook');
                    $data_startup['url_twitter'] = $this->input->post('url_twitter');
                    $data_startup['url_linkedin'] = $this->input->post('url_linkedin');
                    $data_startup['rubro'] = $this->input->post('rubro');
                    $data_startup['descripcion'] = $this->input->post('descripcion');
                    $data_startup['antecedentes'] = $this->input->post('antecedentes');
                    $data_startup['exporta'] = $this->input->post('exporta');
                    $data_startup['consentimiento'] = true;
                    $data_startup['usuario_id'] = $this->session->userdata('user_data')->id;


                    for ($i = 0; $i < count($this->input->post('categories')); $i++) {
                        $data_categorias_seleccionadas[$i]['startup_id']     = $this->session->userdata('user_data')->id;
                        $data_categorias_seleccionadas[$i]['categoria_id'] = $this->input->post('categories')[$i];
                        $data_categorias_seleccionadas[$i]['descripcion'] = $this->input->post('category_description[' . $this->input->post('categories')[$i] . ']');
                    }

                    //Guardo datos del usuario
                    $data_usuario['nombre'] = $this->input->post('nombre');
                    $data_usuario['apellido'] = $this->input->post('apellido');
                    $data_usuario['email'] = $this->input->post('email');
                    $data_usuario['telefono'] = $this->input->post('telefono');
                    $data_usuario['perfil_completo'] = true;
                    $data_usuario['fecha_modifico'] = date('Y-m-d H:i:s', time());

                    if ($this->Profile_model->updatePerfilStartup($data_startup, $data_usuario, $data_categorias_seleccionadas, $this->session->userdata('user_data')->id)) {
                        $this->session->userdata('user_data')->perfil_completo = 1;
                        if ($this->input->post('profile_img')) {
                            $data_img = explode(',', $this->input->post('profile_img'));
                            $data_img_decoded = base64_decode($data_img[1]);
                            $fichero = './uploads/imagenes_de_usuarios/' . $this->session->userdata('user_data')->id . '.png';
                            file_put_contents($fichero, $data_img_decoded);
                            $this->session->userdata('user_data')->logo = true;
                            $data_usuario_update_logo['logo'] = true;
                            $this->Profile_model->updatePerfilStartup($data_startup, $data_usuario_update_logo, $data_categorias_seleccionadas, $this->session->userdata('user_data')->id);
                        }
                        if ($data['data_perfil']->email != $this->input->post('email')) {
                            $this->session->userdata('user_data')->email = $this->input->post('email');
                        }
                        $message = '{
                            "title":"Perfil cargado con éxito",
                            "text": "Se modificó el perfil correctamente.",
                            "type": "success",
                            "buttonsStyling": true,
                            "timer":5000,
                            "confirmButtonClass": "btn btn-success"
                        }';
                        $this->session->set_flashdata('message', $message);
                        redirect(base_url() . 'home');
                    }
                    break;
                case ROL_EMPRESA:
                    //Guardo datos de empresa
                    $data_empresa['titular'] = $this->input->post('titular');
                    $data_empresa['razon_social'] = $this->input->post('razon_social');
                    $data_empresa['cuit'] = $this->input->post('cuit');
                    $data_empresa['email_empresa'] = $this->input->post('email_empresa');
                    $data_empresa['telefono_empresa'] = $this->input->post('telefono_empresa');
                    $data_empresa['pais'] = $this->input->post('pais');
                    $data_empresa['provincia'] = $this->input->post('provincia');
                    $data_empresa['localidad'] = $this->input->post('localidad');
                    $data_empresa['direccion'] = $this->input->post('direccion');
                    $data_empresa['url_web'] = $this->input->post('url_web');
                    $data_empresa['url_youtube'] = $this->input->post('url_youtube');
                    $data_empresa['url_instagram'] = $this->input->post('url_instagram');
                    $data_empresa['url_facebook'] = $this->input->post('url_facebook');
                    $data_empresa['url_twitter'] = $this->input->post('url_twitter');
                    $data_empresa['url_linkedin'] = $this->input->post('url_linkedin');
                    $data_empresa['rubro'] = $this->input->post('rubro');
                    $data_empresa['descripcion'] = $this->input->post('descripcion');
                    $data_empresa['exporta'] = $this->input->post('exporta');


                    //Guardo datos del usuario
                    $data_usuario['nombre'] = $this->input->post('nombre');
                    $data_usuario['apellido'] = $this->input->post('apellido');
                    $data_usuario['email'] = $this->input->post('email');
                    $data_usuario['telefono'] = $this->input->post('telefono');
                    $data_usuario['perfil_completo'] = true;
                    $data_usuario['fecha_modifico'] = date('Y-m-d H:i:s', time());

                    if ($this->Profile_model->updatePerfilEmpresa($data_empresa, $data_usuario, $this->session->userdata('user_data')->id)) {
                        $this->session->userdata('user_data')->perfil_completo = 1;
                        if ($this->input->post('profile_img')) {
                            $data_img = explode(',', $this->input->post('profile_img'));
                            $data_img_decoded = base64_decode($data_img[1]);
                            $fichero = './uploads/imagenes_de_usuarios/' . $this->session->userdata('user_data')->id . '.png';
                            file_put_contents($fichero, $data_img_decoded);
                            $this->session->userdata('user_data')->logo = true;
                            $data_usuario_update_logo['logo'] = true;
                            $this->Profile_model->updatePerfilEmpresa($data_empresa, $data_usuario_update_logo, $this->session->userdata('user_data')->id);
                        }
                        if ($data['data_perfil']->email != $this->input->post('email')) {
                            $this->session->userdata('user_data')->email = $this->input->post('email');
                        }
                        $message = '{
                            "title":"Perfil cargado con éxito",
                            "text": "Se modificó el perfil correctamente.",
                            "type": "success",
                            "buttonsStyling": true,
                            "timer":5000,
                            "confirmButtonClass": "btn btn-success"
                        }';
                        $this->session->set_flashdata('message', $message);
                        redirect(base_url() . 'home');
                    }
                    break;
                case ROL_PARTNER:
                    $data_partner['razon_social'] = $this->input->post('razon_social');
                    $data_partner['url_linkedin'] = $this->input->post('url_linkedin');
                    $data_partner['descripcion_tipo_de_partner'] = $this->input->post('descripcion_tipo_de_partner');
                    $data_partner['descripcion'] = $this->input->post('descripcion');
                    $data_partner['tipo_de_partner_id'] = $this->input->post('tipo_de_partner');

                    $data_usuario['nombre'] = $this->input->post('nombre');
                    $data_usuario['apellido'] = $this->input->post('apellido');
                    $data_usuario['email'] = $this->input->post('email');
                    $data_usuario['telefono'] = $this->input->post('telefono');
                    $data_usuario['perfil_completo'] = true;
                    $data_usuario['fecha_modifico'] = date('Y-m-d H:i:s', time());

                    $this->Profile_model->updatePerfilPartner($data_partner, $data_usuario, $this->session->userdata('user_data')->id);

                    $this->session->userdata('user_data')->perfil_completo = 1;
                    if ($this->input->post('profile_img')) {
                        $data_img = explode(',', $this->input->post('profile_img'));
                        $data_img_decoded = base64_decode($data_img[1]);
                        $fichero = './uploads/imagenes_de_usuarios/' . $this->session->userdata('user_data')->id . '.png';
                        file_put_contents($fichero, $data_img_decoded);
                        $this->session->userdata('user_data')->logo = true;
                        $data_partner_update_logo['logo'] = true;
                        $this->Profile_model->updatePerfilPartner($data_partner, $data_partner_update_logo, $this->session->userdata('user_data')->id);
                    }
                    if ($data['data_perfil']->email != $this->input->post('email')) {
                        $this->session->userdata('user_data')->email = $this->input->post('email');
                    }
                    $message = '{
                            "title":"Perfil cargado con éxito",
                            "text": "Se modificó el perfil correctamente.",
                            "type": "success",
                            "buttonsStyling": true,
                            "timer":5000,
                            "confirmButtonClass": "btn btn-success"
                        }';
                    $this->session->set_flashdata('message', $message);
                    redirect(base_url() . 'home');
                    break;

                case ROL_VALIDADOR:
                case ROL_ADMIN_PLATAFORMA:
                    //Guardo datos del usuario
                    $data_usuario['nombre'] = $this->input->post('nombre');
                    $data_usuario['apellido'] = $this->input->post('apellido');
                    $data_usuario['email'] = $this->input->post('email');
                    $data_usuario['perfil_completo'] = true;
                    $data_usuario['fecha_modifico'] = date('Y-m-d H:i:s', time());

                    $this->Profile_model->updatePerfilAdmin($data_usuario, $this->session->userdata('user_data')->id);

                    $this->session->userdata('user_data')->perfil_completo = 1;
                    if ($this->input->post('profile_img')) {
                        $data_img = explode(',', $this->input->post('profile_img'));
                        $data_img_decoded = base64_decode($data_img[1]);
                        $fichero = './uploads/imagenes_de_usuarios/' . $this->session->userdata('user_data')->id . '.png';
                        file_put_contents($fichero, $data_img_decoded);
                        $this->session->userdata('user_data')->logo = true;
                        $data_usuario_update_logo['logo'] = true;
                        $this->Profile_model->updatePerfilAdmin($data_usuario_update_logo, $this->session->userdata('user_data')->id);
                    }
                    if ($data['data_perfil']->email != $this->input->post('email')) {
                        $this->session->userdata('user_data')->email = $this->input->post('email');
                    }
                    $message = '{
                            "title":"Perfil cargado con éxito",
                            "text": "Se modificó el perfil correctamente.",
                            "type": "success",
                            "buttonsStyling": true,
                            "timer":5000,
                            "confirmButtonClass": "btn btn-success"
                        }';
                    $this->session->set_flashdata('message', $message);
                    redirect(base_url() . 'home');
                    break;
            }
        }
    }

    public function elegir_rol(){
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        $this->form_validation->set_rules(
            'rol',
            'Elija un rol',
            'trim|integer|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        if ($this->form_validation->run() != FALSE) {
            $this->load->model('auth/Auth_model');
            $user_data['rol_id'] = $this->input->post('rol');
            $user_data['usuario_id_modifico'] = $this->session->userdata('user_data')->id;
            $user_data['fecha_modifico'] = date('Y-m-d H:i:s', time());
            $this->Auth_model->updateUserById($this->session->userdata('user_data')->id, $user_data);
            $this->session->userdata('user_data')->rol_id = $this->input->post('rol');
            $user_data_rol['usuario_id'] = $this->session->userdata('user_data')->id;
            $this->Auth_model->insertRolUsuarioApi($user_data['rol_id'],$user_data_rol);
            redirect(base_url() . 'profile');
        } else {
            return FALSE;
        }
    }
}
