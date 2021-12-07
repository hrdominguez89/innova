<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categories extends MX_Controller
{

    public function __construct()
    {

        parent::__construct();

        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . 'auth/login');
        }

        //Seteo rol admin

        if ($this->session->userdata('user_data')->rol_id != ROL_ADMIN_PLATAFORMA) {
            redirect(base_url() . 'home');
        }



        $this->load->model('Categories_model');
        $this->load->library(array('my_form_validation'));
        $this->form_validation->run($this);

        //Configuración de paginación
        $this->load->library('pagination');

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
        $this->config_pagination['base_url'] = base_url() . 'categories';
        $this->config_pagination['total_rows'] = count($this->Categories_model->getTotalCategories());
        $this->pagination->initialize($this->config_pagination);

        $data['files_js'] = array('categories.js');
        $data['categories'] = $this->Categories_model->getCategories($this->start, $this->limit);
        $data['sections_view'] = 'categories_view.php';
        $data['title'] = 'Categorías';
        $data['subtitle'] = 'Listado de categorías';
        $this->load->view('layout_back_view', $data);
    }

    public function insert()
    {
        if ($this->input->post()) {
            $this->form_validation->set_error_delimiters('<div class="text-danger my-2">', '</div>');
            $this->form_validation->set_rules(
                'category_name',
                'Nombre de la categoría',
                'trim|required|callback_valid_category_name',
                array(
                    'required' => 'El campo {field} es obligatorio',
                    'valid_category_name' => 'La categoría indicada ya se encuentra registrada.'
                )
            );
            if ($this->form_validation->run() != FALSE) {
                $category['descripcion'] = $this->input->post('category_name');
                $category['usuario_id_alta'] = $this->session->userdata('user_data')->id;
                $category['fecha_alta'] = date('Y-m-d H:i:s', time());
                $this->Categories_model->setCategory($category);
                $message = '{
                    "title":"Categoría registrada",
                    "text": "Se registró la categoría correctamente.",
                    "type": "success",
                    "buttonsStyling": true,
                    "timer":5000,
                    "confirmButtonClass": "btn btn-success"
                }';
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'categories');
            }
        }
        $data['sections_view'] = 'categories_form_view.php';
        $data['title'] = 'Categorías';
        $data['subtitle'] = 'Nueva categoría';
        $this->load->view('layout_back_view', $data);
    }

    public function edit($id_category = FALSE)
    {
        if (!(int)$id_category) {
            $message = '{
                "title":"Categoría invalida",
                "text": "No se encontró la categoría solicitada.",
                "type": "error",
                "buttonsStyling": true,
                "timer":5000,
                "confirmButtonClass": "btn btn-success"
            }';
            $this->session->set_flashdata('message', $message);
            redirect(base_url() . 'categories');
        }
        $data['category'] = $this->Categories_model->getCategoryById($id_category);
        if (!$data['category']) {
            $message = '{
                "title":"Categoría invalida",
                "text": "No se encontró la categoría solicitada.",
                "type": "error",
                "buttonsStyling": true,
                "timer":5000,
                "confirmButtonClass": "btn btn-success"
            }';
            $this->session->set_flashdata('message', $message);
            redirect(base_url() . 'categories');
        }
        if ($this->input->post()) {
            $this->form_validation->set_error_delimiters('<div class="text-danger my-2">', '</div>');
            $this->form_validation->set_rules(
                'category_name',
                'Nombre de la categoría',
                'trim|required|callback_valid_category_name[' . $data["category"]->description . ']',
                array(
                    'required' => 'El campo {field} es obligatorio',
                    'valid_category_name' => 'La categoría indicada ya se encuentra registrada.'
                )
            );
            if ($this->form_validation->run() != FALSE) {
                $category['descripcion'] = $this->input->post('category_name');
                $category['usuario_id_modifico'] = $this->session->userdata('user_data')->id;
                $category['fecha_modifico'] = date('Y-m-d H:i:s', time());
                $this->Categories_model->updateCategory($category, $id_category);
                $message = '{
                    "title":"Categoría editada",
                    "text": "Se editó la categoría correctamente.",
                    "type": "success",
                    "buttonsStyling": true,
                    "timer":5000,
                    "confirmButtonClass": "btn btn-success"
                }';
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'categories');
            }
        }
        $data['sections_view'] = 'categories_form_view.php';
        $data['title'] = 'Categorías';
        $data['subtitle'] = 'Editar categoría';
        $this->load->view('layout_back_view', $data);
    }

    public function enableDisableCategory()
    {
        if ($this->input->post()) {
            $dataCategory['activo'] = $this->input->post('activo');
            $dataCategory['publicado'] = true;
            $dataCategory['usuario_id_modifico'] = $this->session->userdata('user_data')->id;
            $dataCategory['fecha_modifico'] = date('Y-m-d H:i:s',time());
            $category_id = $this->input->post('id');
            $response = $this->Categories_model->updateCategory($dataCategory, $category_id);
            echo json_encode($response);
        } else {
            redirect(base_url() . 'categories', 'refresh');
        }
    }

    public function valid_category_name($name, $current_name = FALSE)
    {
        if ($current_name && $current_name == $name) {
            return TRUE;
        }
        if ($this->Categories_model->getCategoryByDescription($name)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
