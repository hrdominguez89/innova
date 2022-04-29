<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registro_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    public function getEmail($email)
    {
        $this->db->select('email,id');
        $this->db->where('email', $email);
        $this->db->where('estado_id!=', USR_DELETED);
        return $this->db->get('usuarios')->row();
    }

    public function getNombreDeEmpresa($enterprise_name, $kind_of_enterprise)
    {
        $this->db->select('razon_social');
        if ($kind_of_enterprise == ROL_STARTUP) {
            $this->db->from('startups');
            $this->db->join('usuarios', 'usuarios.id = startups.usuario_id');
        } else if ($kind_of_enterprise == ROL_EMPRESA){
            $this->db->from('empresas');
            $this->db->join('usuarios', 'usuarios.id = empresas.usuario_id');
        } else{
            $this->db->from('partners');
            $this->db->join('usuarios', 'usuarios.id = partners.usuario_id');
        }
        $this->db->where('razon_social', $enterprise_name);
        $this->db->where('usuarios.estado_id!=', USR_DELETED);
        return $this->db->get()->row();
    }

    public function setUserAndEnterprise($user_data, $enterprise_data, $table_enterprise)
    {
        $this->db->trans_begin();

        $this->db->insert('usuarios', $user_data);
        $insert_id = $this->db->insert_id();
        $enterprise_data['usuario_id'] = $insert_id;
        $this->db->insert($table_enterprise, $enterprise_data);

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

    public function getMensajeRegistro($rol_id)
    {
        $this->db->select('*');
        switch ($rol_id) {
            case ROL_STARTUP:
                $this->db->where('nombre_mensaje', 'mensaje_alta_registro_startup');
                break;
            case ROL_EMPRESA:
                $this->db->where('nombre_mensaje', 'mensaje_alta_registro_empresa');
                break;
            case ROL_PARTNER:
                $this->db->where('nombre_mensaje', 'mensaje_alta_registro_partner');
                break;
        }
        $this->db->from('vi_mensajes_de_la_plataforma');
        return $this->db->get()->row();
    }

    public function getMensajeRegistroGral()
    {
        $this->db->select('*');
        $this->db->where('nombre_mensaje', 'mensaje_registro_general');
        $this->db->from('vi_mensajes_de_la_plataforma');
        return $this->db->get()->row();
    }
}
