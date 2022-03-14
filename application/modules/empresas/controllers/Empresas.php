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
            // case ROL_VALIDADOR:
                $data['empresas'] = $this->Empresas_model->getEmpresas();
                $data['files_js'] = array('activar_tabla_comun.js','empresas/empresas.js');
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
            case ROL_VALIDADOR:
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

    
    public function cambiarEstadoEmpresa()
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
            if ($this->Empresas_model->actualizarEmpresa($user_estado, $usuario_id)) {
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
            if($this->Empresas_model->actualizarEmpresa($data_usuario,$usuario_id)){
                $data = array(
                    'status'    => true,
                );
            }else{
                $data = array(
                    'status'    => false,
                    'msg'       => 'No fue posible modificar el estado del usuario.'
                );
            }
        }
        echo json_encode($data);
    }
}
