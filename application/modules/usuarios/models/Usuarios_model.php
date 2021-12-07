<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getUsuariosAdmin()
    {
        $this->db->select('
            u.id,
            u.nombre,
            u.apellido,
            u.email,
            u.estado_id,
            u.fecha_alta,
            r.id as rol_id,
            r.rol as rol_descripcion,
            es.id as estado_id,
            es.estado as estado_descripcion
            ');
        $this->db->from('usuarios as u');
        $this->db->join('roles as r', 'r.id = u.rol_id');
        $this->db->join('estados_usuarios as es', 'es.id = u.estado_id');
        $this->db->where('rol_id', ROL_ADMIN_ORGANIZACION);
        $this->db->or_where('rol_id', ROL_ADMIN_PLATAFORMA);
        $this->db->order_by('email', 'ASC');
        return $this->db->get()->result();
    }

    public function insertarUsuario($data_usuario){
        $this->db->trans_begin();

        $this->db->insert('usuarios', $data_usuario);

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

    public function updateUsuario($data_usuario,$usuario_id){
        $this->db->where('id',$usuario_id);
        $this->db->update('usuarios',$data_usuario);
    }

    public function getUsuarioById($usuario_id){
        $this->db->select('
            u.id,
            u.nombre,
            u.apellido,
            u.email,
            u.rol_id,
            r.rol as rol_descripcion
            ');
        $this->db->from('usuarios as u');
        $this->db->where('u.id', $usuario_id);
        $this->db->join('roles as r', 'r.id = u.rol_id');
        return $this->db->get()->row();
    }
}
