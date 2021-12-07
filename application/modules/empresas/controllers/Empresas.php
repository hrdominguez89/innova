<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Empresas extends MX_Controller
{

    public function __construct()
    {

        parent::__construct();
        
        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . 'auth/login');
        }
        $this->load->model('Empresas_model');
    }

    public function index()
    {
        switch ($this->session->userdata('user_data')->rol_id) {
            case ROL_ADMIN_PLATAFORMA:
            // case ROL_ADMIN_ORGANIZACION:
                $data['empresas'] = $this->Empresas_model->getEmpresas();
                // echo '<pre>';var_dump($data['empresas']);die();
                $data['files_js'] = array('activar_tabla_comun.js');
                $data['title'] = 'Empresas';
                $data['sections_view'] = 'empresas_list_admin_view';
                $this->load->view('layout_back_view', $data);
                break;
            default:
                redirect(base_url() . 'home');
                break;
        }
    }
    public function ver($empresa_id)
    {
        if (!(int)$empresa_id) {
            redirect(base_url() . 'home');
        }

        switch ($this->session->userdata('user_data')->rol_id) {
            case ROL_ADMIN_PLATAFORMA:
            case ROL_ADMIN_ORGANIZACION:
                $data['empresa'] = $this->Empresas_model->getEmpresaById($empresa_id);
                if (!$data['empresa']) {
                    redirect(base_url() . 'home');
                }
                $data['desafios'] = $this->Empresas_model->getDesafiosByEmpresaId($empresa_id);
                // echo '<pre>';var_dump($data['empresa'],$data['desafios']);die();
                $data['title'] = 'Empresa';
                $data['files_js'] = array('activar_tabla_comun.js');
                $data['sections_view'] = 'ficha_empresa_view';
                $this->load->view('layout_back_view', $data);
                break;
            default:
                redirect(base_url() . 'home');
                break;
        }
    }
}
