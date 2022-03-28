<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function getDataComplementaria($rol_id, $usuario_id)
    {
        //trae los datos de la tabla correspondientes, admin plataforma no tiene otra tabla
        switch ($rol_id) {
            case ROL_STARTUP:
                $tabla = 'startups';
                break;
            case ROL_EMPRESA:
                $tabla = 'empresas';
                break;
            case ROL_PARTNER:
                $tabla = 'partners';
                break;
            case ROL_VALIDADOR:
                $tabla = 'validadores';
                break;
        }
        $query = $this->db->select('*')
            ->from($tabla)
            ->where('usuario_id', $usuario_id)
            ->get()
            ->row();
        return $query;
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
            es.estado as estado_descripcion,
            va.razon_social,
            va.descripcion,
            ');
        $this->db->from('usuarios as u');
        $this->db->join('roles as r', 'r.id = u.rol_id');
        $this->db->join('estados_usuarios as es', 'es.id = u.estado_id');
        $this->db->join('validadores as va', 'va.usuario_id = u.id', 'left');
        $this->db->where('u.estado_id !=', USR_DELETED);
        $this->db->group_start();
        $this->db->where('u.rol_id', ROL_VALIDADOR);
        $this->db->or_where('u.rol_id', ROL_ADMIN_PLATAFORMA);
        $this->db->group_end();
        $this->db->order_by('email', 'ASC');
        return $this->db->get()->result();
    }

    public function insertarUsuario($data_usuario)
    {
        $this->db->trans_begin();

        $this->db->insert('usuarios', $data_usuario);
        $insert_id = $this->db->insert_id();

        // Condicional del Rollback 
        if ($this->db->trans_status() === FALSE) {
            //Hubo errores en la consulta, entonces se cancela la transacción.   
            $this->db->trans_rollback();
            return FALSE;
        } else {
            //Todas las consultas se hicieron correctamente.  
            $this->db->trans_commit();
            return $insert_id;
        } //If Rollback
    }

    public function insertarUsuarioValidador($data_usuario)
    {
        $this->db->trans_begin();

        $this->db->insert('validadores', $data_usuario);
        $insert_id = $this->db->insert_id();

        // Condicional del Rollback 
        if ($this->db->trans_status() === FALSE) {
            //Hubo errores en la consulta, entonces se cancela la transacción.   
            $this->db->trans_rollback();
            return FALSE;
        } else {
            //Todas las consultas se hicieron correctamente.  
            $this->db->trans_commit();
            return $insert_id;
        } //If Rollback
    }

    public function updateUsuario($data_usuario, $usuario_id)
    {
        $this->db->trans_begin();

        $this->db->where('id', $usuario_id);
        $this->db->update('usuarios', $data_usuario);

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

    public function getUsuarioById($usuario_id)
    {
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
        $this->db->where('u.estado_id !=', USR_DELETED);
        $this->db->join('roles as r', 'r.id = u.rol_id');
        return $this->db->get()->row();
    }

    public function eliminarValidador($usuario_id)
    {
        $this->db->trans_begin();

        $this->db->where('usuario_id', $usuario_id);
        $this->db->delete('validadores');

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
