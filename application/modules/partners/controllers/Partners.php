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
                // case ROL_VALIDADOR:
                $data['partners'] = $this->Partners_model->getPartnersYCantidadDeDesafiosCompartidosDeUsuariosActivos();
                $data['title'] = 'Partners';
                $data['files_js'] = array('activar_tabla_comun.js', 'partners/partners.js');
                $data['sections_view'] = 'partners_list_admin_view';
                $this->load->view('layout_back_view', $data);
                break;
            default:
                redirect(base_url() . 'home');
                break;
        }
    }

    public function ver($partner_id)
    {
        if (!(int)$partner_id) {
            redirect(base_url() . 'home');
        }

        switch ($this->session->userdata('user_data')->rol_id) {
            case ROL_ADMIN_PLATAFORMA:
            // case ROL_VALIDADOR:
                $data['partner'] = $this->Partners_model->getPartnerById($partner_id);
                if (!$data['partner']) {
                    redirect(base_url() . 'home');
                }
                $data['desafios_compartidos'] = $this->Partners_model->getDesafiosCompartidosDeUsuariosActivos($partner_id);
                $data['title'] = 'Partner';
                $data['files_js'] = array('activar_tabla_comun.js');
                $data['sections_view'] = 'ficha_partner_view';
                $this->load->view('layout_back_view', $data);
                break;
            default:
                redirect(base_url() . 'home');
                break;
        }
    }

    public function cambiarEstadoPartner()
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
            if ($this->Partners_model->actualizarPartner($user_estado, $usuario_id)) {
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
            if ($this->Partners_model->actualizarPartner($data_usuario, $usuario_id)) {
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
}
