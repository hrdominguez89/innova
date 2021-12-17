<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Partners extends MX_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model('Partners_model');
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
                // echo '<pre>';var_dump($data['startups']);die();
                $data['title'] = 'Startups';
                $data['files_js'] = array('activar_tabla_comun.js');
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
}
