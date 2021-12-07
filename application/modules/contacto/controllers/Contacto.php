<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contacto extends MX_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model('Contacto_model');
        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . 'auth/login');
        }
    }

    public function index()
    {
        switch ($this->session->userdata('user_data')->rol_id) {
            case ROL_STARTUP:
                $data['contactos_data'] = $this->Contacto_model->getContactosData($this->session->userdata('user_data')->id, $this->session->userdata('user_data')->rol_id);
                $data['title'] = 'Contacto';
                $data['sections_view'] = 'contacto_listar_empresas_view';
                break;
            case ROL_EMPRESA:
                $data['contactos_data'] = $this->Contacto_model->getContactosData($this->session->userdata('user_data')->id, $this->session->userdata('user_data')->rol_id);
                $data['title'] = 'Contacto';
                $data['sections_view'] = 'contacto_listar_startups_view';
                break;
                // case ROL_ADMIN_PLATAFORMA:
                //     break;

                // case ROL_ADMIN_PLATAFORMA:
                //     break;
            default:
                redirect(base_url() . 'home');
                break;
        }
        $data['files_js'] = array('activar_tabla_comun.js');
        $this->load->view('layout_back_view', $data);
    }

    public function startup($startup_id, $desafio_id)
    {
        if (!$this->session->userdata('user_data')->rol_id == ROL_EMPRESA) {
            redirect(base_url() . 'home');
        }
        $data['contacto_data'] = $this->Contacto_model->getContactoData($this->session->userdata('user_data')->id, $this->session->userdata('user_data')->rol_id, $startup_id, $desafio_id);

        $data['title'] = 'Ver contacto';
        $data['sections_view'] = 'contacto_ver_startup_view';
        $this->load->view('layout_back_view', $data);
    }
    public function empresa($empresa_id, $desafio_id)
    {
        if (!$this->session->userdata('user_data')->rol_id == ROL_STARTUP) {
            redirect(base_url() . 'home');
        }
        $data['contacto_data'] = $this->Contacto_model->getContactoData($this->session->userdata('user_data')->id, $this->session->userdata('user_data')->rol_id, $empresa_id, $desafio_id);
        $data['title'] = 'Ver contacto';
        $data['sections_view'] = 'contacto_ver_empresa_view';
        $this->load->view('layout_back_view', $data);
    }
}
