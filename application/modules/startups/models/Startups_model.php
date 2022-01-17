<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Startups_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getStartups()
    {
        $this->db->select('*,SUM(CASE WHEN p.startup_id IS NULL THEN 0 ELSE 1 END) as cantidad_de_postulaciones,SUM(CASE WHEN cs.startup_id IS NULL THEN 0 ELSE 1 END) as cantidad_de_matcheos');
        $this->db->from('usuarios as u');
        $this->db->join('startups as st', 'st.usuario_id = u.id');
        $this->db->join('postulaciones as p', 'p.startup_id = u.id', 'left');
        $this->db->join('contacto_startups as cs', 'cs.startup_id = u.id', 'left');
        $this->db->where('u.rol_id', ROL_STARTUP);
        $this->db->group_start();
        $this->db->where('u.estado_id !=', USR_DELETED);
        if ($this->session->userdata('user_data')->rol_id != ROL_ADMIN_PLATAFORMA) {
            $this->db->or_where('u.estado_id', USR_ENABLED);
            $this->db->or_where('u.estado_id', USR_VERIFIED);
        }
        $this->db->group_end();
        $this->db->group_by('u.id');
        return $this->db->get()->result();
        // $this->db->get()->result();
        // var_dump($this->db->last_query());
        // die();
    }


    public function getStartupById($startup_id)
    {
        $this->db->select('*');
        $this->db->where('usuario_id', $startup_id);
        $this->db->from('vi_startups_info');
        return $this->db->get()->row();
    }

    public function getStartupByIdForPartner($startup_id)
    {
        $this->db->select('vs.razon_social,vs.descripcion,vs.antecedentes,vs.exporta,vs.objetivo_y_motivacion,vs.nombre_de_categorias,vs.rubro,vs.logo');
        $this->db->from('vi_startups_info vs');
        $this->db->where('usuario_id', $startup_id);
        return $this->db->get()->row();
    }

    public function getPostulacionesByStartupId($startup_id)
    {
        $this->db->select('*,ep.estado as estado_postulacion_nombre');
        $this->db->from('postulaciones as p');
        $this->db->join('usuarios as u', 'u.id = p.startup_id', 'left');
        $this->db->join('vi_desafios as vd', 'vd.desafio_id = p.desafio_id', 'left');
        $this->db->join('estados_postulaciones as ep', 'ep.id = p.estado_postulacion', 'left');
        $this->db->where('p.startup_id', $startup_id);
        return $this->db->get()->result();
    }

    public function actualizarStartup($data, $startup_id)
    {
        $this->db->trans_begin();

        $this->db->where('id', $startup_id);

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
    public function getStartupsCompatiblesPorDesafioId($array_categorias, $partner_id)
    {
        $query = $this->db->select('vs.razon_social, vs.usuario_id as startup_id')
            ->from('vi_startups_info vs')
            ->join('categorias_startups as cs', 'cs.startup_id = vs.usuario_id')
            ->where_in('cs.categoria_id', $array_categorias)
            ->group_start()
            ->where('vs.estado_usuario_id', USR_ENABLED)
            ->or_where('vs.estado_usuario_id', USR_VERIFIED)
            ->group_end()
            ->order_by('vs.usuario_id')
            ->group_by('vs.usuario_id')
            ->get()->result();
        return $query;
    }
}
