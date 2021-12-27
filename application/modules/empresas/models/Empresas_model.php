<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresas_model extends CI_Model {
    public function __construct()
	{
        parent::__construct();
        $this->load->database();
    }

    public function getEmpresas(){
        $this->db->select('*,u.id as id_empresa,SUM(CASE WHEN vd.id_empresa IS NULL THEN 0 ELSE 1 END) as cantidad_de_desafios, SUM(CASE WHEN p.desafio_id IS NULL THEN 0 ELSE 1 END) as cantidad_de_postulaciones,SUM(CASE WHEN cs.empresa_id IS NULL THEN 0 ELSE 1 END) as cantidad_de_matcheos');
        $this->db->from('usuarios as u');
        $this->db->join('empresas as em','em.usuario_id = u.id');
        $this->db->join('vi_desafios as vd','vd.id_empresa = u.id','left');
        $this->db->join('postulaciones as p','p.desafio_id = vd.desafio_id','left');
        $this->db->join('contacto_startups as cs','cs.empresa_id = u.id','left');
        $this->db->where('u.estado_id !=',USR_DELETED);
        if(!$this->session->userdata('user_data')->rol_id == ROL_ADMIN_PLATAFORMA){
            $this->db->where('u.estado_id',USR_ENABLED);
            $this->db->or_where('u.estado_id',USR_VERIFIED);
        }
        $this->db->group_by('u.id');
        return $this->db->get()->result();
        // $this->db->get()->result();
        // var_dump($this->db->last_query());die();
    }

    public function getEmpresaById($empresa_id){
        $this->db->select('*');
        $this->db->where('u.id',$empresa_id);
        $this->db->from('usuarios as u');
        $this->db->join('empresas as em','em.usuario_id = u.id');
        return $this->db->get()->row();
    }

    public function getDesafiosByEmpresaId ($empresa_id){
        $this->db->select('*,vd.desafio_id as id_del_desafio,SUM(CASE WHEN p.desafio_id IS NULL THEN 0 ELSE 1 END) as cantidad_de_postulaciones,SUM(CASE WHEN cs.empresa_id IS NULL THEN 0 ELSE 1 END) as cantidad_de_matcheos');
        $this->db->from('vi_desafios as vd');
        $this->db->join('postulaciones as p','vd.desafio_id = p.desafio_id','left');
        $this->db->join('contacto_startups as cs','cs.empresa_id = vd.id_empresa','left');
        $this->db->group_by('vd.desafio_id');
        $this->db->where('vd.id_empresa',$empresa_id);
        return $this->db->get()->result();
        // $this->db->get()->result();
        // var_dump($this->db->last_query());die();
    }

    public function actualizarEmpresa($data, $empresa_id)
    {
        $this->db->trans_begin();

        $this->db->where('id', $empresa_id);

        $this->db->update('usuarios', $data);

        // Condicional del Rollback 
        if ($this->db->trans_status() === FALSE) {
            //Hubo errores en la consulta, entonces se cancela la transacción.   
            $this->db->trans_rollback();
            return FALSE;
        } else {
            //Todas las consultas se hicieron correctamente.  
            $this->db->trans_commit();
            return TRUE;
        } //If Rollback

    }
}
