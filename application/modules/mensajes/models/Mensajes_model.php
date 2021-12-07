<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensajes_model extends CI_Model {
    public function __construct()
	{
        parent::__construct();
        $this->load->database();
    }

    public function getMensaje($nombre_mensaje){
        return $this->db->select('*')->from('vi_mensajes_de_la_plataforma')->where('nombre_mensaje',$nombre_mensaje)->get()->row();
    }
}

?>