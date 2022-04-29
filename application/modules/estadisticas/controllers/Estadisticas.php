<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Estadisticas extends MX_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model('Estadisticas_model');
    }

    public function index()
    {
        $data['title'] = 'Estadísticas';
        $data['sections_view'] = 'estadisticas_view';
        $data['files_js'] = array('excellentexport.js', 'html2canvas.js', 'canvas2image.js', 'apexcharts.js', 'graficos/estadisticas.js');
        $this->load->view('layout_back_view', $data);
    }

    public function getDesafiosPorMes()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url() . 'home');
        }

        $fecha_desde = $this->input->get('fecha_desde') != 'false' ? $this->input->get('fecha_desde') : false;
        $fecha_hasta = $this->input->get('fecha_hasta') != 'false' ? $this->input->get('fecha_hasta') : false;

        $data = array(
            'status' => true,
            'data' => $this->Estadisticas_model->getDesafiosPorMes($fecha_desde, $fecha_hasta),
        );
        echo json_encode($data);
    }

    public function getPostulacionesPorMes()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url() . 'home');
        }
        $fecha_desde = $this->input->get('fecha_desde') != 'false' ? $this->input->get('fecha_desde') : false;
        $fecha_hasta = $this->input->get('fecha_hasta') != 'false' ? $this->input->get('fecha_hasta') : false;

        $data = array(
            'status' => true,
            'data' => $this->Estadisticas_model->getPostulacionesPorMes($fecha_desde, $fecha_hasta),
        );
        echo json_encode($data);
    }

    public function getMatchPorMes()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url() . 'home');
        }
        $fecha_desde = $this->input->get('fecha_desde') != 'false' ? $this->input->get('fecha_desde') : false;
        $fecha_hasta = $this->input->get('fecha_hasta') != 'false' ? $this->input->get('fecha_hasta') : false;

        $data = array(
            'status' => true,
            'data' => $this->Estadisticas_model->getMatchPorMes($fecha_desde, $fecha_hasta),
        );

        echo json_encode($data);
    }

    public function getRegistrosPorRolPorMes()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url() . 'home');
        }
        $fecha_desde = $this->input->get('fecha_desde') != 'false' ? $this->input->get('fecha_desde') : false;
        $fecha_hasta = $this->input->get('fecha_hasta') != 'false' ? $this->input->get('fecha_hasta') : false;

        $data = array(
            'status' => true,
            'data' => $this->Estadisticas_model->getRegistrosPorRolPorMes($fecha_desde, $fecha_hasta),
        );
        echo json_encode($data);
    }
}
