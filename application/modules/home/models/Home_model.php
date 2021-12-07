<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getTotalesPorRoles()
    {
        $this->db->select('*');
        $this->db->from('vi_total_usuarios_por_roles');
        $this->db->order_by('rol_id');
        return $this->db->get()->result();
    }

    public function getTotalCategoriasPorDesafio()
    {
        $this->db->select('*');
        $this->db->order_by('categoria_descripcion');
        return $this->db->get('vi_total_categorias_por_desafio')->result();
    }

    public function getTotalCategoriasPorStartup()
    {
        $this->db->select('*');
        $this->db->order_by('categoria_descripcion');
        return $this->db->get('vi_total_categorias_por_startup')->result();
    }

    public function getCategoriasActivas()
    {
        $this->db->select('*');
        $this->db->where('activo', 1);
        $this->db->order_by('descripcion');
        return $this->db->get('categorias')->result();
    }
}
