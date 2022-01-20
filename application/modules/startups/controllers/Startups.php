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
            case ROL_PARTNER:
                $this->config_pagination['base_url'] = base_url() . 'desafios';
                $this->config_pagination['total_rows'] = count($this->Startups_model->getStartupsActivos());
                $this->pagination->initialize($this->config_pagination);

                $data['startups'] = $this->Startups_model->getStartupsActivos($this->start, $this->limit);
                $data['files_js'] =  array('startups/startups_partner.js');
                $data['sections_view'] = 'startups_cartelera_partner_view';

                break;
            case ROL_ADMIN_PLATAFORMA:
            case ROL_ADMIN_ORGANIZACION:
                $data['startups'] = $this->Startups_model->getStartups();
                $data['files_js'] = array('activar_tabla_comun.js', 'startups/startups.js');
                $data['sections_view'] = 'startups_list_admin_view';
                break;
            default:
                redirect(base_url() . 'home');
                break;
        }
        
        $data['title'] = 'Startups';
        $this->load->view('layout_back_view', $data);
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
