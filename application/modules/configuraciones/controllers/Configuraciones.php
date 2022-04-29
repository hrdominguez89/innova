<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Configuraciones extends MX_Controller
{

    public function __construct()
    {

        parent::__construct();

        //Cargo Libreria que repara bug de form_validation
        $this->load->library(array('my_form_validation'));
        $this->form_validation->run($this);

        $this->load->model('Configuraciones_model');
    }

    public function index()
    {
        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . 'auth/login');
        }
        if ($this->session->userdata('user_data')->rol_id != ROL_ADMIN_PLATAFORMA) {
            redirect(base_url() . 'home');
        }
        if ($this->input->post()) {
            if ($this->input->post('config_plataforma')) {
                $this->rulesConfigPlataforma();
                if ($this->form_validation->run() != FALSE) {
                    $config_plataforma['postulaciones_maximas'] = $this->input->post('postulaciones_maximas');
                    $config_plataforma['notificaciones_maximas_header'] = $this->input->post('notificaciones_maximas_header');
                    $config_plataforma['notificaciones_maximas_menu_lateral'] = $this->input->post('notificaciones_maximas_menu_lateral');
                    $config_plataforma['nombre_notificacion_validador'] = $this->input->post('nombre_notificacion_validador');
                    $config_plataforma['correo_notificacion_validador'] = $this->input->post('correo_notificacion_validador');
                    $config_plataforma['nombre_notificacion_admin_plataforma'] = $this->input->post('nombre_notificacion_admin_plataforma');
                    $config_plataforma['correo_notificacion_admin_plataforma'] = $this->input->post('correo_notificacion_admin_plataforma');
                    $config_plataforma['nombre_notificacion_no_responder'] = $this->input->post('nombre_notificacion_no_responder');
                    $config_plataforma['correo_notificacion_no_responder'] = $this->input->post('correo_notificacion_no_responder');
                    $config_plataforma['nombre_notificacion_comunicacion'] = $this->input->post('nombre_notificacion_comunicacion');
                    $config_plataforma['correo_notificacion_comunicacion'] = $this->input->post('correo_notificacion_comunicacion');
                    $config_plataforma['nombre_notificacion_informacion'] = $this->input->post('nombre_notificacion_informacion');
                    $config_plataforma['correo_notificacion_informacion'] = $this->input->post('correo_notificacion_informacion');
                    $config_plataforma['usuario_id_modifico'] = $this->session->userdata('user_data')->id;
                    $config_plataforma['fecha_modifico'] = date('Y-m-d H:i:s', time());

                    $status = $this->Configuraciones_model->updateConfigPlataforma($config_plataforma);
                }
            } else if ($this->input->post('config_mensajes')) {
                $this->rulesConfigMensajes();
                if ($this->form_validation->run() != FALSE) {
                    $config_mensajes_plataforma['usuario_id_modifico'] = $this->session->userdata('user_data')->id;
                    $config_mensajes_plataforma['fecha_modifico'] = date('Y-m-d H:i:s', time());
                    for ($i = 0; $i < count($this->input->post('mensaje_id')); $i++) {
                        $id_mensaje_plataforma = $this->input->post('mensaje_id')[$i];
                        $config_mensajes_plataforma['asunto_mensaje'] = $this->input->post('asunto_mensaje')[$i] == 'NULL' ? NULL:$this->input->post('asunto_mensaje')[$i];
                        $config_mensajes_plataforma['texto_mensaje'] = $this->input->post('texto_mensaje')[$i];
                        $config_mensajes_plataforma['tipo_de_envio_id'] = $this->input->post('tipo_de_envio_id')[$i] == 'NULL' ? NULL:$this->input->post('tipo_de_envio_id')[$i];
                        $config_mensajes_plataforma['notificador_id'] = $this->input->post('notificador_id')[$i] == 'NULL' ? NULL:$this->input->post('notificador_id')[$i];
                        $status = $this->Configuraciones_model->updateConfigMensajes($config_mensajes_plataforma, $id_mensaje_plataforma);
                    }
                }
            }
            //dependiendo del resultado de cada configuracion envio msj.
            if(isset($status)){
                if ($status) {
                    $data['message_sweat_alert'] = array(
                        'status' => true,
                        'msg' => 'Configuración guardada exitosamente.',
                    );
                } else {
                    $data['message_sweat_alert'] = array(
                        'status' => false,
                        'msg' => 'No fue posible guardar la configuración, por favor intente mas tarde.',
                    );
                }
            }
        }
        $data['files_js'] = array('configuraciones/configuraciones.js');
        $data['tipos_de_envio'] = $this->Configuraciones_model->getTiposDeEnvio();
        $data['notificadores'] = $this->Configuraciones_model->getNotificadores();
        $data['mensajes_de_la_plataforma'] = $this->Configuraciones_model->getMensajesDeLaPlataforma();
        $data['configuraciones_de_la_plataforma'] = $this->Configuraciones_model->getConfiguracionesDeLaPlataforma();
        $data['title'] = 'Configuraciones';
        $data['sections_view'] = 'configuraciones_view';
        $this->load->view('layout_back_view', $data);
    }

    public function rulesConfigPlataforma()
    {
        $this->form_validation->set_rules(
            'postulaciones_maximas',
            'Nro de postulaciones permitidas',
            'trim|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'notificaciones_maximas_header',
            'Nro de notificaciones en el Header',
            'trim|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'notificaciones_maximas_menu_lateral',
            'Nro de notificaciones en el menu ateral',
            'trim|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'nombre_notificacion_validador',
            'Nombre "Validador',
            'trim|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'correo_notificacion_validador',
            'Correo "Validador',
            'trim|valid_email|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'nombre_notificacion_admin_plataforma',
            'Nombre "Admin Plataforma',
            'trim|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'correo_notificacion_admin_plataforma',
            'Correo "Admin Plataforma',
            'trim|valid_email|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'nombre_notificacion_no_responder',
            'Nombre "No Responder',
            'trim|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'correo_notificacion_no_responder',
            'Correo "No Responder',
            'trim|valid_email|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'nombre_notificacion_comunicacion',
            'Nombre "Comunicación',
            'trim|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'correo_notificacion_comunicacion',
            'Correo "Comunicación',
            'trim|valid_email|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'nombre_notificacion_informacion',
            'Nombre "Información',
            'trim|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'correo_notificacion_informacion',
            'Correo "Información',
            'trim|valid_email|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
    }

    public function rulesConfigMensajes()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules(
            'mensaje_id[]',
            'mensaje ID',
            'trim|integer|required',
            array(
                'required' => 'El campo {field} es obligatorio'
            )
        );
        $this->form_validation->set_rules(
            'asunto_mensaje[]',
            'Asunto',
            'trim|max_length[255]|callback_check_campo_text_is_null',
            array(
                'check_campo_text_is_null' => 'El campo {field} es requerido y debe ser un valor valido.'
            )
        );
        $this->form_validation->set_rules(
            'texto_mensaje[]',
            'Mensaje',
            'trim|max_length[5000]|required',
            array(
                'required' => 'El campo {field} es obligatorio'
            )
        );
        $this->form_validation->set_rules(
            'tipo_de_envio_id[]',
            'Tipo de envio',
            'trim|callback_check_campo_id_is_null',
            array(
                'check_campo_id_is_null' => 'El campo {field} es requerido y debe ser un valor valido.'
            )
        );
        $this->form_validation->set_rules(
            'notificador_id[]',
            'Enviar mensaje desde',
            'trim|callback_check_campo_id_is_null',
            array(
                'check_campo_id_is_null' => 'El campo {field} es requerido y debe ser un valor valido.'
            )
        );
    }

    public function check_campo_id_is_null($valor_campo)
    {

        if ($valor_campo == 'NULL') {
            return TRUE;
        } else {
            if(!is_int((int)$valor_campo) || $valor_campo == ''){
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }

    public function check_campo_text_is_null($valor_campo)
    {
        if ($valor_campo == 'NULL') {
            return TRUE;
        } else {
            if($valor_campo == ''){
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
}
