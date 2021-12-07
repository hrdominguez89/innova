<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class a extends MX_Controller{
    
    public function __construct(){

        parent::__construct();
        $this->load->model('');
    }

    public function index(){
        $data['title'] = '';
        $data['sections_view'] = 'home/home_empresas_view';
        $this->load->view('layout_back_view',$data);
    }
}
?>