<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notificaciones extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('notificaciones/Notificaciones_model');
        $this->load->model('configuraciones/Configuraciones_model');
        // $this->load->model('startups/Startups_model');
        // $this->load->model('matches/Matches_model');
    }

    public function index()
    {
        if (!$this->session->userdata('user_data')) {
            redirect('/auth/login');
        }
        switch ($this->session->userdata('user_data')->rol_id) {
            case ROL_ADMIN_ORGANIZACION:
                $data['total_notificaciones'] = $this->Notificaciones_model->getNotificacionesAdminOrganizacion($this->session->userdata('user_data')->id);
                break;
            case ROL_ADMIN_PLATAFORMA:
                $data['total_notificaciones'] = $this->Notificaciones_model->getNotificacionesAdminPlataforma($this->session->userdata('user_data')->id);
                break;
            default:
                $data['total_notificaciones'] = $this->Notificaciones_model->getNotificaciones($this->session->userdata('user_data')->id);
                break;
        }
        $data['title'] = 'Notificaciones';
        $data['sections_view'] = 'notificaciones_view';

        $this->load->view('layout_back_view', $data);
    }

    public function ver()
    {
        if (!$this->session->userdata('user_data')) {
            redirect('/auth/login');
        }

        $notificacion_id = $this->input->post('notificacion_id');
        $notificacion = $this->Notificaciones_model->getNotificacionById($notificacion_id);
        if (!$notificacion) {
            echo json_encode(array(
                'data' => 'nada',
                'status' => true,
            ));
        }

        if ($notificacion->leido == 0) {
            $notificacion_data['leido'] = true;
            $notificacion_data['fecha_leido'] = date('Y-m-d H:i:s', time());
            $this->Notificaciones_model->updateNotificacionById($notificacion_data, $notificacion_id);
        }
        echo json_encode(array(
            'data' => $notificacion,
            'status' => true,
        ));
    }

    public function cargar_notificaciones()
    {   //ESTO ES UN HOOK, carga notificaciones antes de cargar cualquier controlador.
        if ($this->session->userdata('user_data')) {
            $configuraciones = $this->Configuraciones_model->getConfiguracionesDeLaPlataforma();
            switch ($this->session->userdata('user_data')->rol_id) {
                case ROL_ADMIN_ORGANIZACION:
                    $this->session->notificaciones = $this->Notificaciones_model->getNotificacionesAdminOrganizacion($this->session->userdata('user_data')->id);
                    break;
                case ROL_ADMIN_PLATAFORMA:
                    $this->session->notificaciones = $this->Notificaciones_model->getNotificacionesAdminPlataforma($this->session->userdata('user_data')->id);
                    break;
                default:
                    $this->session->notificaciones = $this->Notificaciones_model->getNotificaciones($this->session->userdata('user_data')->id);
                    break;
            }
            $this->session->notificaciones_maximas_header = $configuraciones->notificaciones_maximas_header;
            $this->session->notificaciones_maximas_menu = $configuraciones->notificaciones_maximas_menu_lateral;
        }
    }

    public function verificar_perfil_completo()
    {   //ESTO ES UN HOOK, carga notificaciones antes de cargar cualquier controlador.
        if ($this->session->userdata('user_data') && !(int)$this->session->userdata('user_data')->perfil_completo && !$this->input->post() && $this->uri->segment(URI_SEGMENT) != "auth") {
            $titulo = "Complete su perfil.";
            $mensaje_cuerpo = $this->Notificaciones_model->getTextoCargarPerfil()->texto_mensaje;

            $buscar_y_reemplazar = array(
                array('buscar' => '{{NOMBRE_USUARIO}}', 'reemplazar' => $this->session->userdata('user_data')->nombre),
                array('buscar' => '{{APELLIDO_USUARIO}}', 'reemplazar' => $this->session->userdata('user_data')->apellido),
            );

            for ($i = 0; $i < count($buscar_y_reemplazar); $i++) {
                $mensaje_cuerpo = str_replace($buscar_y_reemplazar[$i]['buscar'], $buscar_y_reemplazar[$i]['reemplazar'], $mensaje_cuerpo);
            }

            $message = (object)[
                'titulo' => $titulo,
                'mensaje_cuerpo' => $mensaje_cuerpo,
            ];
            $this->session->set_flashdata('message', $message);
            if ($this->uri->segment(URI_SEGMENT) != "profile") {
                redirect(base_url() . 'profile');
            }
        }
    }
}
