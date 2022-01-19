<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Startups extends MX_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model('Startups_model');
        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . 'auth/login');
        }
    }

    public function index()
    {
        switch ($this->session->userdata('user_data')->rol_id) {
            case ROL_ADMIN_PLATAFORMA:
            case ROL_ADMIN_ORGANIZACION:
                $data['startups'] = $this->Startups_model->getStartups();
                $data['title'] = 'Startups';
                $data['files_js'] = array('activar_tabla_comun.js', 'startups/startups.js');
                $data['sections_view'] = 'startups_list_admin_view';
                $this->load->view('layout_back_view', $data);
                break;
            default:
                redirect(base_url() . 'home');
                break;
        }
    }

    public function ver($startup_id)
    {
        if (!(int)$startup_id) {
            redirect(base_url() . 'home');
        }

        switch ($this->session->userdata('user_data')->rol_id) {
            case ROL_ADMIN_PLATAFORMA:
            case ROL_ADMIN_ORGANIZACION:
                $data['startup'] = $this->Startups_model->getStartupById($startup_id);
                if (!$data['startup']) {
                    redirect(base_url() . 'home');
                }
                $data['postulaciones'] = $this->Startups_model->getPostulacionesByStartupId($startup_id);
                // echo '<pre>';var_dump($data['startup'],$data['postulaciones']);die();
                $data['title'] = 'Startup';
                $data['files_js'] = array('activar_tabla_comun.js');
                $data['sections_view'] = 'ficha_startup_view';
                $this->load->view('layout_back_view', $data);
                break;
            default:
                redirect(base_url() . 'home');
                break;
        }
    }

    public function cambiarEstadoStartup()
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
            $usuario_id = $this->input->post('usuario_id');
            $estado = $this->input->post('estado') === "true" ? true : false;
            $user_estado['usuario_id_modifico'] = $this->session->userdata('user_data')->id;
            $user_estado['fecha_modifico'] = date('Y-m-d H:i:s', time());
            if ($estado) {
                $user_estado['estado_id'] = USR_ENABLED;
            } else {
                $user_estado['estado_id'] = USR_DISABLED;
            }
            if ($this->Startups_model->actualizarStartup($user_estado, $usuario_id)) {
                $data = array(
                    'status' => true
                );
            } else {
                $data = array(
                    'status'    => false,
                    'msg'       => 'No fue posible modificar el estado del usuario.'
                );
            }
        }
        echo json_encode($data);
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
            $usuario_id = $this->input->post('usuario_id');
            $data_usuario['estado_id'] = USR_DELETED;
            $data_usuario['usuario_id_modifico'] = $this->session->userdata('user_data')->id;
            $data_usuario['fecha_modifico'] = date('Y-m-d H:i:s', time());
            if ($this->Startups_model->actualizarStartup($data_usuario, $usuario_id)) {
                $data = array(
                    'status'    => true,
                );
            } else {
                $data = array(
                    'status'    => false,
                    'msg'       => 'No fue posible modificar el estado del usuario.'
                );
            }
        }
        echo json_encode($data);
    }

    public function getStartupsCompatiblesPorDesafioId()
    {
        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . 'auth/login');
        }

        if (!$this->input->is_ajax_request() && $this->session->userdata('user_data')->rol_id != ROL_PARTNER) {
            redirect(base_url() . 'home');
        }

        $desafio_id = $this->input->post('desafio_id');
        $partner_id = $this->session->userdata('user_data')->id;
        $this->load->model('desafios/Desafios_model');
        $categorias_desafio = $this->Desafios_model->getCategoriasDelDesafio($desafio_id);
        $array_categorias_desafio = [];
        foreach ($categorias_desafio as $categoria) {
            $array_categorias_desafio[] = $categoria->categoria_id;
        }
        $startupsCompatibles = $this->Startups_model->getStartupsCompatiblesPorDesafioId($array_categorias_desafio, $partner_id, $desafio_id);
        $data = array(
            'status' => true,
            'data' => $startupsCompatibles
        );
        echo json_encode($data);
    }

    public function getStartupById()
    {
        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . 'auth/login');
        }

        if (!$this->input->is_ajax_request() && $this->session->userdata('user_data')->rol_id != ROL_PARTNER) {
            redirect(base_url() . 'home');
        }

        $desafio_id = $this->input->post('desafio_id');
        $startup_id = $this->input->post('startup_id');
        $partner_id = $this->session->userdata('user_data')->id;
        $startup_data = $this->Startups_model->getStartupByIdForPartner($startup_id, $partner_id, $desafio_id);
        $data = array(
            'status' => true,
            'data' => $startup_data
        );
        echo json_encode($data);
    }
}
