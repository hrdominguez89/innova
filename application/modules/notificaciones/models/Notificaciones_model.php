<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notificaciones_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function updateNotificacionById($data, $notificacion_id)
    {
        $this->db->where('id', $notificacion_id)
            ->update('notificaciones', $data);
    }

    public function getNotificaciones($usuario_id)
    {
        $this->db->select('*');
        $this->db->where('para_usuario_id', $usuario_id);
        $this->db->order_by('fecha_alta', 'DESC');
        return $this->db->get('notificaciones')->result();

        //$this->db->get('notificaciones')->result();
        //var_dump($this->db->last_query());die();
    }


    public function getNotificacionById($notificacion_id)
    {
        return $this->db->select('*')
            ->where('id', $notificacion_id)
            ->get('vi_notificaciones')
            ->row();
    }

    public function getTextoCargarPerfil()
    {
        return $this->db->select('texto_mensaje')
            ->where('nombre_mensaje', 'mensaje_completar_perfil')
            ->get('mensajes_de_la_plataforma')
            ->row();
    }

    public function getTextoCargarRol()
    {
        return $this->db->select('texto_mensaje')
            ->where('nombre_mensaje', 'mensaje_cargar_rol')
            ->get('mensajes_de_la_plataforma')
            ->row();
    }

    public function insertarNotificacion($notificacion_data)
    {
        $this->db->trans_begin();

        $this->db->insert('notificaciones', $notificacion_data);
        // Condicional del Rollback 
        if ($this->db->trans_status() === FALSE) {
            //Hubo errores en la consulta, entonces se cancela la transacción.   
            $this->db->trans_rollback();
            return FALSE;
        } else {
            //Todas las consultas se hicieron correctamente.  
            $this->db->trans_commit();
            return true;
        } //If Rollback
    }

    public function getNotificacionesAdminOrganizacion($usuario_id)
    { {
            $this->db->select('*')
                ->group_start()
                ->where('para_usuario_id', $usuario_id)
                ->or_group_start()
                ->where('para_usuario_id', 0)
                ->where('para_rol_id', ROL_VALIDADOR)
                ->group_end()
                ->group_end();
            $this->db->order_by('fecha_alta', 'DESC');
            return $this->db->get('notificaciones')->result();

            //$this->db->get('notificaciones')->result();
            //var_dump($this->db->last_query());die();
        }
    }

    public function getNotificacionesAdminPlataforma($usuario_id)
    {
        $this->db->select('*')
            ->group_start()
            ->where('para_usuario_id', $usuario_id)
            ->or_group_start()
            ->where('para_usuario_id', 0)
            ->where('para_rol_id', ROL_VALIDADOR)
            ->group_end()
            ->or_group_start()
            ->where('para_usuario_id', 0)
            ->where('para_rol_id', ROL_ADMIN_PLATAFORMA)
            ->group_end()
            ->group_end();
        $this->db->order_by('fecha_alta', 'DESC');
        return $this->db->get('notificaciones')->result();

        //$this->db->get('notificaciones')->result();
        //var_dump($this->db->last_query());die();
    }
}
