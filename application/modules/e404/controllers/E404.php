<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class E404 extends MX_Controller {

    public function __construct()
	{
        parent::__construct();
        
    }

	public function index(){
        if($this->session->userdata('user_data')){
            $data['sections_view'] = 'e404_view';
            $data['title'] = 'Error 404';
            $this->load->view('layout_back_view',$data);
        }
        else{
            redirect(base_url().URI_WP);
        }
    }
}