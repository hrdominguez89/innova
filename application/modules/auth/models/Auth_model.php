<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    private $custom_config;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getUserDataByEmail($email)
    {
        $this->db->select('*');
        $this->db->where('email', $email);
        $this->db->where('estado_id!=', USR_DELETED);
        return $this->db->get('usuarios')->row();
    }

    public function getDataEmpresa($rol_id, $usuario_id)
    {
        $this->db->select('*');
        switch ($rol_id) {
            case ROL_STARTUP:
                $tabla = 'startups';
            case ROL_EMPRESA:
                $tabla = 'empresas';
            case ROL_PARTNER:
                $tabla = 'partners';
        }
        $this->db->from($tabla);
        $this->db->where('usuario_id', $usuario_id);
        return $this->db->get()->row();
    }

    public function updateUser($data_user, $email)
    {
        $this->db->trans_begin();

        $this->db->where('email', $email);
        $this->db->where('estado_id!=', USR_DELETED);
        $this->db->update('usuarios', $data_user);

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

    public function updateUserById($user_id, $user_data, $options = false)
    { //options debe tener rol_id y accion(eliminar o modificar), y si tiene modificar debe tener los datos a modificar de la tabla ROL
        $this->db->trans_begin();

        $this->db->where('id', $user_id);
        $this->db->update('usuarios', $user_data);

        if ($options && $options['rol_id'] && $options['accion']) {
            switch ($options['rol_id']) {
                case ROL_STARTUP:
                    $tabla = 'startups';
                    break;
                case ROL_EMPRESA:
                    $tabla = 'empresas';
                    break;
                case ROL_PARTNER:
                    $tabla = 'partners';
                    break;
            }
            $this->db->where('usuario_id', $user_id);
            if ($options['accion'] == 'eliminar') {
                $this->db->delete($tabla);
            } else if ($options['accion'] == 'modificar') {
                $this->db->update($tabla, $options['data_usuario']);
            }
        }

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
