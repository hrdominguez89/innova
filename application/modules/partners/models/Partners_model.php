<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partners_model extends CI_Model {
    public function __construct()
	{
        parent::__construct();
        $this->load->database();
    }

    public function getPartnerById($partner_id){
        $this->db->select('*');
        $this->db->where('u.id',$partner_id);
        $this->db->from('usuarios as u');
        $this->db->join('partners as pa','pa.usuario_id = u.id');
        return $this->db->get()->row();
    }

}

?>