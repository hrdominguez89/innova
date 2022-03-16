<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Postulados extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Postulados_model');
        $this->load->library(array('my_form_validation'));
        $this->form_validation->run($this);

        $this->load->library('pagination');


        //config paginacion
        $this->limit_default = 10;
        $this->page = $this->input->get('page') ? $this->input->get('page') : 0;
        $this->limit = $this->input->get('limit') ? $this->input->get('limit') : $this->limit_default;
        $this->start = $this->page >= 1 ? ($this->page - 1) * $this->limit : 0;
        $this->config_pagination = array(
            'per_page'             => $this->limit,
            'use_page_numbers'     => TRUE,
            'page_query_string'    => TRUE,
            'query_string_segment' => 'page',
            'reuse_query_string'   => TRUE,
            'full_tag_open'        => '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">',
            'full_tag_close'       => '</ul></nav>',
            'first_link'           => 'Primero',
            'first_tag_open'       => '<li class="page-item">',
            'first_tag_close'      => '</li>',
            'last_link'            => 'Último',
            'last_tag_open'        => '<li class="page-item">',
            'last_tag_close'       => '</li>',
            'next_tag_open'        => '<li class="page-item">',
            'next_tag_close'       => '</li>',
            'prev_tag_open'        => '<li class="page-item">',
            'prev_tag_close'       => '</li>',
            'num_tag_open'         => '<li class="page-item">',
            'num_tag_close'        => '</li>',
            'cur_tag_open'         => '<li class="page-item active"><span class="page-link">',
            'cur_tag_close'        => '</span></li>',
            'attributes'           => array(
                'class' => 'page-link'
            ),
        );
    }

    public function index()
    {
        switch ($this->session->userdata('user_data')->rol_id) {
            case ROL_STARTUP:
                $this->config_pagination['base_url'] = base_url() . 'postulados';
                $this->config_pagination['total_rows'] = count($this->Postulados_model->getDesafiosPostuladosByUserId($this->session->userdata('user_data')->id));
                $this->pagination->initialize($this->config_pagination);

                $data['desafios'] = $this->Postulados_model->getDesafiosPostuladosByUserId($this->session->userdata('user_data')->id, $this->start, $this->limit);
                $data['sections_view'] = 'postulaciones_startup_view';
                $data['title'] = 'Mis postulaciones';


                break;
            case ROL_EMPRESA:
                $this->config_pagination['base_url'] = base_url() . 'postulados';
                $this->config_pagination['total_rows'] = count($this->Postulados_model->getDesafiosYPostuladosByEmpresaUserId($this->session->userdata('user_data')->id));
                $this->pagination->initialize($this->config_pagination);

                $data['desafios'] = $this->Postulados_model->getDesafiosYPostuladosByEmpresaUserId($this->session->userdata('user_data')->id, $this->start, $this->limit);
                $data['sections_view'] = 'postulaciones_empresa_view';
                $data['title'] = 'Postulados a mis desafíos';

                break;
            case ROL_VALIDADOR:
            case ROL_ADMIN_PLATAFORMA:
                $data['postulados'] = $this->Postulados_model->getTodosLosPostulados();
                $data['files_js'] = array('activar_tabla_comun.js','postulaciones/eliminar_postulacion.js');
                $data['sections_view'] = 'postulados_admin_list_view';
                $data['title'] = 'Postulados';
                break;
        }
        $this->load->view('layout_back_view', $data);
    }

    public function desafio($desafio_id)
    {
        if ($this->session->userdata('user_data') && $this->session->userdata('user_data')->rol_id == ROL_EMPRESA) {
            if ((int)$desafio_id) {

                $data['desafio'] = $this->Postulados_model->getDesafiosById($desafio_id, $this->session->userdata('user_data')->id);
                if ($data['desafio']) {
                    $this->config_pagination['base_url'] = base_url() . 'postulados';
                    $this->config_pagination['total_rows'] = count($this->Postulados_model->getPostuladosByDesafioId($desafio_id));
                    $this->pagination->initialize($this->config_pagination);

                    $data['postulados'] = $this->Postulados_model->getPostuladosByDesafioId($desafio_id, $this->start, $this->limit);
                    $data['sections_view'] = 'postulados_desafios_view';
                    $data['title'] = 'Postulados a ' . $data['desafio']->nombre_del_desafio;
                    $this->load->view('layout_back_view', $data);
                } else {
                    redirect(base_url() . 'home');
                }
            } else {
                redirect(base_url() . 'home');
            }
        } else {
            redirect(base_url() . 'home');
        }
    }

    public function startup($startup_id, $desafio_id)
    {
        if ($this->session->userdata('user_data')) {

            if ((int)$desafio_id && (int)$startup_id) {
                $this->load->helper(array('send_email_helper'));
                switch ($this->session->userdata('user_data')->rol_id) {
                    case ROL_EMPRESA:
                        $data['startup'] = $this->Postulados_model->getStartupDataByIdAndDesafioId($desafio_id, $startup_id);
                        if ($data['startup']) {
                            $data['files_js'] = array('postulaciones/contactar.js');
                            $data['sections_view'] = 'ficha_startup_postulado_view';
                            $data['title'] = 'Ficha startup';
                            $this->load->view('layout_back_view', $data);
                        } else {
                            redirect(base_url() . 'home');
                        }

                        break;
                    case ROL_VALIDADOR:
                    case ROL_ADMIN_PLATAFORMA:
                        $this->load->model('mensajes/Mensajes_model');
                        $data['mensaje_de_plataforma_rechazado'] = $this->Mensajes_model->getMensaje('mensaje_rechazo_postulacion');
                        if ($this->input->post()) {
                            $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
                            $this->form_validation->set_rules(
                                'postulacion_id',
                                'postulacion_id',
                                'trim|integer|required',
                                array(
                                    'required' => 'El campo {field} es obligatorio.'
                                )
                            );
                            $this->form_validation->set_rules(
                                'validar_postulacion',
                                'Validar postulación',
                                'trim|integer|required',
                                array(
                                    'required' => 'El campo {field} es obligatorio.'
                                )
                            );
                            if ($this->input->post('validar_postulacion') == POST_RECHAZADO) {
                                $this->form_validation->set_rules(
                                    'detalle_rechazo_cancelado',
                                    'Detalle rechazado',
                                    'trim|required',
                                    array(
                                        'required' => 'El campo {field} es obligatorio.'
                                    )
                                );
                            }
                            if ($this->form_validation->run() != FALSE) {
                                $postulacion_id = $this->input->post('postulacion_id');
                                $estado_validacion['fecha_modifico'] = date('Y-m-d H:i:s', time());
                                $estado_validacion['usuario_id_modifico'] = $this->session->userdata('user_data')->id;
                                $estado_validacion['estado_postulacion'] = $this->input->post('validar_postulacion');
                                if ($this->input->post('validar_postulacion') == POST_RECHAZADO) {
                                    $estado_validacion['detalle_rechazo_cancelado'] = $this->input->post('detalle_rechazo_cancelado');
                                    $data['mensaje_de_plataforma'] = $this->Mensajes_model->getMensaje('mensaje_rechazo_postulacion');
                                    $data['mensaje_de_plataforma']->texto_mensaje .= ' ' . $estado_validacion['detalle_rechazo_cancelado'];
                                } else {
                                    $estado_validacion['detalle_rechazo_cancelado'] = NULL;
                                    $data['mensaje_de_plataforma'] = $this->Mensajes_model->getMensaje('mensaje_postulacion_validada');
                                }
                                $this->Postulados_model->updatePostulacion($estado_validacion, $postulacion_id);

                                $startup_data = $this->Postulados_model->getStartupData($startup_id);
                                $desafio_data = $this->Postulados_model->getDesafioData($desafio_id);


                                $buscar_y_reemplazar = array(
                                    array('buscar' => '{{NOMBRE_RAZON_SOCIAL}}', 'reemplazar' => $startup_data->razon_social),
                                    array('buscar' => '{{NOMBRE_USUARIO}}', 'reemplazar' => $startup_data->nombre),
                                    array('buscar' => '{{APELLIDO_USUARIO}}', 'reemplazar' => $startup_data->apellido),
                                    array('buscar' => '{{DESAFIO_NOMBRE}}', 'reemplazar' => $desafio_data->nombre_del_desafio),
                                    array('buscar' => '{{NOMBRE_EMPRESA}}', 'reemplazar' => $desafio_data->nombre_empresa),
                                );


                                switch ($data['mensaje_de_plataforma']->tipo_de_envio_id) {
                                    case ENVIO_NOTIFICACION:
                                        $mensaje_de_notificacion = $this->Mensajes_model->getMensaje('mensaje_nueva_notificacion');
                                        $this->crearNotificacion($data['mensaje_de_plataforma'], $startup_data, $this->session->userdata('user_data'), $buscar_y_reemplazar);
                                        $this->crearEmail($mensaje_de_notificacion, $startup_data, $buscar_y_reemplazar);
                                        break;
                                    case ENVIO_EMAIL:
                                        $this->crearEmail($data['mensaje_de_plataforma'], $startup_data, $buscar_y_reemplazar);
                                        break;
                                    case ENVIO_NOTIF_EMAIL:
                                        $this->crearNotificacion($data['mensaje_de_plataforma'], $startup_data, $this->session->userdata('user_data'), $buscar_y_reemplazar);
                                        $this->crearEmail($data['mensaje_de_plataforma'], $startup_data, $buscar_y_reemplazar);
                                        break;
                                }
                            }
                        }
                        $data['startup'] = $this->Postulados_model->getStartupDataByIdAndDesafioId($desafio_id, $startup_id);
                        if ($data['startup']) {
                            $data['mensaje_de_plataforma_rechazado'] = $this->Mensajes_model->getMensaje('mensaje_rechazo_postulacion');
                            $data['files_js'] = array('postulaciones/ficha_startup_postulado_admin.js');
                            $data['sections_view'] = 'ficha_startup_postulado_admin_view';
                            $data['title'] = 'Ficha startup';
                            $this->load->view('layout_back_view', $data);
                        } else {
                            redirect(base_url() . 'home');
                        }
                        break;
                    default:
                        redirect(base_url() . 'home');
                        break;
                }
            } else {
                redirect(base_url() . 'home');
            }
        } else {
            redirect(base_url() . 'home');
        }
    }

    public function contactar()
    {
        if ($this->validarAcceso()) {


            $contactar['startup_id'] = $this->input->post('startup_id');
            $contactar['desafio_id'] = $this->input->post('desafio_id');
            $contactar['empresa_id'] = $this->session->userdata('user_data')->id;
            $contactar['fecha_de_contacto'] = date('Y-m-d H:i:s', time());
            $this->Postulados_model->insertarContacto($contactar);
            $postulacion['estado_postulacion'] = POST_ACEPTADO;
            $postulacion['usuario_id_modifico'] = $this->session->userdata('user_data')->id;
            $postulacion['fecha_modifico'] = date('Y-m-d H:i:s',time());
            $this->Postulados_model->updatePostulado($postulacion, $this->input->post('startup_id'), $this->input->post('desafio_id'));

            $startup_data = $this->Postulados_model->getStartupDataByIdAndDesafioId($contactar['desafio_id'], $contactar['startup_id'],);

            $buscar_y_reemplazar = array(
                array('buscar' => '{{NOMBRE_RAZON_SOCIAL_STARTUP}}', 'reemplazar' => $startup_data->razon_social),
                array('buscar' => '{{NOMBRE_CONTACTO_STARTUP}}', 'reemplazar' => $startup_data->nombre),
                array('buscar' => '{{APELLIDO_CONTACTO_STARTUP}}', 'reemplazar' => $startup_data->apellido),
                array('buscar' => '{{NOMBRE_RAZON_SOCIAL_EMPRESA}}', 'reemplazar' => $startup_data->nombre_empresa),
                array('buscar' => '{{DESAFIO_NOMBRE}}', 'reemplazar' => $startup_data->nombre_del_desafio),
            );

            $this->load->model('mensajes/Mensajes_model');
            $this->load->helper(array('send_email_helper'));

            //creo notificacion para administradores
            $mensaje_de_plataforma_a_administradores = $this->Mensajes_model->getMensaje('mensaje_solicitud_de_contacto_a_administradores');
            $this->crearNotificacion($mensaje_de_plataforma_a_administradores, FALSE, $this->session->userdata('user_data'), $buscar_y_reemplazar);


            //creo notificacion y/o email para la startup            
            $mensaje_de_plataforma_a_startup = $this->Mensajes_model->getMensaje('mensaje_solicitud_de_contacto_a_startup');

            switch ($mensaje_de_plataforma_a_startup->tipo_de_envio_id) {
                case ENVIO_NOTIFICACION:
                    $mensaje_de_notificacion = $this->Mensajes_model->getMensaje('mensaje_nueva_notificacion');
                    $this->crearNotificacion($mensaje_de_plataforma_a_startup, $startup_data, $this->session->userdata('user_data'), $buscar_y_reemplazar);
                    $this->crearEmail($mensaje_de_notificacion, $startup_data, $buscar_y_reemplazar);
                    break;
                case ENVIO_EMAIL:
                    $this->crearEmail($mensaje_de_plataforma_a_startup, $startup_data, $buscar_y_reemplazar);
                    break;
                case ENVIO_NOTIF_EMAIL:
                    $this->crearNotificacion($mensaje_de_plataforma_a_startup, $startup_data, $this->session->userdata('user_data'), $buscar_y_reemplazar);
                    $this->crearEmail($mensaje_de_plataforma_a_startup, $startup_data, $buscar_y_reemplazar);
                    break;
            }

            echo json_encode(array(
                'status_code' => 200,
                'startup_data' => $startup_data,
            ));
        }
    }

    public function validarAcceso() //valida los acceso a traves de ajax.
    {
        if (!$this->session->userdata('user_data')) {
            echo json_encode(array(
                'status_code'   => 403,
                'msg'           => 'Sin acceso',
            ));
        } else if (!$this->input->post()) {
            echo json_encode(array(
                'status_code'   => 400,
                'msg'           => 'Error de petición',
            ));
        } else {
            return true;
        }
        return false;
    }

    public function crearNotificacion($data_mensaje, $data_usuario_para, $data_de_usuario, $buscar_y_reemplazar)
    {
        if (!$data_usuario_para) {
            $data_usuario_para_id = 0;
            $data_usuario_rol_id = ROL_VALIDADOR;
        }else{
            $data_usuario_para_id = $data_usuario_para->usuario_id;
            $data_usuario_rol_id = ROL_STARTUP;
        }
        $de_usuario_id = $data_de_usuario->id;
        $de_rol_id = $data_de_usuario->rol_id;

        crear_notificacion($de_usuario_id, $de_rol_id, $data_mensaje, $data_usuario_para_id, $data_usuario_rol_id, $buscar_y_reemplazar);
    }

    public function crearEmail($data_mensaje, $data_usuario_para, $buscar_y_reemplazar)
    {

        $mensaje = $data_mensaje->texto_mensaje;
        $asunto = $data_mensaje->asunto_mensaje;

        if ($buscar_y_reemplazar) {
            for ($i = 0; $i < count($buscar_y_reemplazar); $i++) {
                $mensaje = str_replace($buscar_y_reemplazar[$i]['buscar'], $buscar_y_reemplazar[$i]['reemplazar'], $mensaje);
                $asunto = str_replace($buscar_y_reemplazar[$i]['buscar'], $buscar_y_reemplazar[$i]['reemplazar'], $asunto);
            }
        }

        $email_de = $data_mensaje->notificador_correo;
        $nombre_de = $data_mensaje->notificador_nombre;
        $email_para = $data_usuario_para->email_contacto;
        $email_mensaje = $mensaje;
        $email_asunto =  $asunto;

        encolar_email($email_de, $nombre_de, $email_para, $email_mensaje, $email_asunto);
    }

    public function eliminar()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        if ($this->session->userdata('user_data')->rol_id != ROL_ADMIN_PLATAFORMA) {
            $data = array(
                'status'    => false,
                'msg'       => 'No tiene permisos para realizar esta modificación'
            );
        } else {
            $postulado_id = $this->input->post('postulado_id');
            $data_postulado['estado_id'] = DESAF_ELIMINADO;
            $data_postulado['usuario_id_modifico'] = $this->session->userdata('user_data')->id;
            $data_postulado['fecha_modifico'] = date('Y-m-d H:i:s', time());
            if ($this->Desafios_model->actualizarDesafio($data_postulado, $postulado_id)) {
                $data = array(
                    'status'    => true,
                );
            } else {
                $data = array(
                    'status'    => false,
                    'msg'       => 'No fue posible modificar el desafío.'
                );
            }
        }
        echo json_encode($data);
    }
}
