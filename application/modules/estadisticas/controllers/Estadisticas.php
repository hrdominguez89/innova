<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estadisticas extends MX_Controller{
    
    public function __construct(){

        parent::__construct();
        $this->load->model('Estadisticas_model');
    }

    public function index(){
        $data['title'] = 'Estadísticas';
        $data['sections_view'] = 'estadisticas_view';
        $this->load->view('layout_back_view',$data);
    }
}
?>