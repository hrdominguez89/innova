<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partners_model extends CI_Model {
    public function __construct()
	{
        parent::__construct();
        $this->load->database();
    }

    public function getStartups(){
        $this->db->select('*,SUM(CASE WHEN p.startup_id IS NULL THEN 0 ELSE 1 END) as cantidad_de_postulaciones,SUM(CASE WHEN cs.startup_id IS NULL THEN 0 ELSE 1 END) as cantidad_de_matcheos');
        $this->db->from('usuarios as u');
        $this->db->join('startups as st','st.usuario_id = u.id');
        $this->db->join('postulaciones as p','p.startup_id = u.id','left');
        $this->db->join('contacto_startups as cs','cs.startup_id = u.id','left');
        $this->db->group_by('u.id');
        return $this->db->get()->result();
        // var_dump($this->db->last_query(''));die();
    }


    public function getStartupById($startup_id){
        $this->db->select('*');
        $this->db->where('usuario_id',$startup_id);
        $this->db->from('vi_startups_info');
        return $this->db->get()->row();
    }

    public function getPostulacionesByStartupId($startup_id){
        $this->db->select('*,ep.estado as estado_postulacion_nombre');
        $this->db->from('postulaciones as p');
        $this->db->join('usuarios as u','u.id = p.startup_id','left');
        $this->db->join('vi_desafios as vd','vd.desafio_id = p.desafio_id','left');
        $this->db->join('estados_postulaciones as ep','ep.id = p.estado_postulacion','left');
        $this->db->where('p.startup_id',$startup_id);
        return $this->db->get()->result();
    }
}

?>