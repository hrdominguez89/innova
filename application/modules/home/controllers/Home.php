<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . 'auth/login');
        }
        $this->load->model('Home_model');
    }

    public function index()
    {
        switch ($this->session->userdata('user_data')->rol_id) {
            case ROL_STARTUP:
                $data['sections_view'] = 'home_startup_view';
                break;
            case ROL_EMPRESA:
                $data['sections_view'] = 'home_empresas_view';
                break;
            case ROL_PARTNER:
                $data['sections_view'] = 'home_partner_view';
                break;
            case ROL_VALIDADOR:
                $data['sections_view'] = 'home_validador_view';
                break;
            case ROL_ADMIN_PLATAFORMA:
                $data['sections_view'] = 'home_admin_plataforma_view';
                $data['files_js'] = array('excellentexport.js', 'html2canvas.js', 'canvas2image.js', 'apexcharts.js', 'graficos/graficos_home.js');
                break;
        }
        $data['title'] = 'Home';
        $this->load->view('layout_back_view', $data);
    }

    public function getTotalesPorRoles()
    {
        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . 'auth/login');
        }
        if (!($this->session->userdata('user_data')->rol_id == ROL_ADMIN_PLATAFORMA || $this->session->userdata('user_data')->rol_id == ROL_VALIDADOR)) {
            redirect(base_url() . 'home');
        }
        $total_de_usuarios_por_rol = $this->Home_model->getTotalesPorRoles();
        echo json_encode($total_de_usuarios_por_rol);
    }

    public function getTotalesCategorias()
    {
        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . 'auth/login');
        }
        if (!($this->session->userdata('user_data')->rol_id == ROL_ADMIN_PLATAFORMA || $this->session->userdata('user_data')->rol_id == ROL_VALIDADOR)) {
            redirect(base_url() . 'home');
        }
        $categorias['categorias'] = $this->Home_model->getCategoriasActivas();
        $categorias['categorias_desafios'] = $this->Home_model->getTotalCategoriasPorDesafio();
        $categorias['categorias_startups'] = $this->Home_model->getTotalCategoriasPorStartup();
        echo json_encode($categorias);
    }
}
